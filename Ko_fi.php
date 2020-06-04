<?php

/*
Plugin Name: Ko-fi Button
Plugin URI:
Description: A Ko-fi donate button for your website!
Version: 1.0.2
Author: Ko-fi Team; www.ko-fi.com
Author URI:
License: GPL2
*/


if (!function_exists('write_log')) {
	function write_log ( $log )  {
	    if ( true === WP_DEBUG ) {
	        if ( is_array( $log ) || is_object( $log ) ) {
	            error_log( print_r( $log, true ) );
	        } else {
	            error_log( $log );
	        }
	    }
	}
}

class Ko_Fi
{

    public static $options = [];

    public static function init()
    {
        add_action('widgets_init', [__CLASS__, 'widget']);
        add_action('admin_enqueue_scripts', array(__CLASS__, 'scripts'), 9);
        add_shortcode('kofi', [__CLASS__, 'kofi_shortcode']);

        require_once 'Default_ko_fi_options.php';
        require_once 'Ko_fi_Options.php';
        self::$options = (new Ko_fi_Options())->get();
        add_filter('plugin_action_links', [__CLASS__,'add_action_links'],10,5);
        register_deactivation_hook( __FILE__, [__CLASS__,'deactivate'] );
    }

    public static function add_action_links($actions, $plugin_file)
    {
        static $plugin;

        if (!isset($plugin))
            $plugin = plugin_basename(__FILE__);
        if ($plugin == $plugin_file) {

            $settings_url = sprintf('<a href="%s">Settings</a>', menu_page_url(Default_ko_fi_options::get()['menu_slug'], false));
            $plugin_links = [
                'settings' => $settings_url
            ];

            $actions = array_merge($plugin_links, $actions);
        }

        return $actions;
    }

    public static function scripts()
    {
        $dir_url = plugin_dir_url(__FILE__);
        wp_register_script('jscolor', $dir_url . 'jscolor.js', ['jquery']);
        wp_register_script('extra', $dir_url . 'extra.js', ['jscolor']);
        wp_enqueue_script('jscolor');
        wp_enqueue_script('extra');
    }

    public static function widget()
    {
        require_once 'ko_fi_widget.php';
        register_widget('ko_fi_widget');

    }

    // Add Shortcode
    public static function kofi_shortcode($atts)
    {
        // Attributes
        $atts = shortcode_atts(
            array(
                'text' => self::$options['coffee_text'],
                'color' => self::$options['coffee_color']
            ),
            $atts
        );

        // Return custom embed code
        return self::get_embed_code($atts);
    }

    public static function get_jscolor($args)
    {
        if (!empty($args['options']) && gettype($args['options']) == 'array') {
            $atts = [];
            array_walk($args['options'], function($v, $k) { global $atts; $atts[]="$k:$v"; });
            $color_options = '{' . implode(', ', $atts) . '}';
        } else {
            //echo 'no options';
            $color_options = '';
        }

        echo sprintf('<input class="jscolor %4$s "  id="%1$s" name="%2$s" value="%3$s" />',
            esc_attr($args['option_id']),
            empty($args['name']) ? esc_attr($args['option_id']) : $args['name'],
            esc_attr($args['value']),
            esc_attr($color_options));
    }

    public static function get_embed_code($atts, $widget_id = '')
    {
        $settings = wp_parse_args($atts, self::$options);
        foreach ($atts as $key => $value) {
            switch ($key) {
                case 'title'  :
                    $key = 'coffee_title';
                    break;
                case 'text'   :
                    $key = 'coffee_text';
                    break;
                case 'hyperlink' :
                    $key = 'coffee_hyperlink';
                    break;
                case 'color' :
                    $key = 'coffee_color';
                    break;
                case 'code':
                    $key = 'coffee_code';
                    if ($value == self::$options['coffee_code'])
                        $value = '';
                    $value = str_replace('http://ko-fi.com/', '', str_replace( 'https://ko-fi.com/', '', self::$options['coffee_code'] ));
                    break;
                case 'button_alignment':
                    $key = 'coffee_button_alignment';
                    break;
            }

            $settings[$key] = $value;
        }

        $style_registry = [
            'left' => "float: none; text-align: left;",
            'right' => "float: right; text-align: left;",
            'centre' => "width: 100%; text-align: center;"
        ];
        
        $btn_container_style = '"'.$style_registry[ $settings['coffee_button_alignment'] ].'"';
        if (!empty($settings['coffee_hyperlink']) && $settings['coffee_hyperlink']) {

            return '<div style='.$btn_container_style.' class="btn-container">'.
                        '<a href="http://www.ko-fi.com/'.$settings['coffee_code'].'">'.$settings['coffee_text'].'</a>'.
                    '</div>';
        } else {

            $html_variable_name = str_replace( '-', '_', $widget_id );
            if( empty( $html_variable_name ) ) {
                $html_variable_name = 'kofiShortcode'.rand(1, 1000);
            }

            $html_variable_name .= 'Html';

            return "<script type='text/javascript' src='https://ko-fi.com/widgets/widget_2.js'></script>".
            "<script type='text/javascript'>".
                "kofiwidget2.init('" . $settings['coffee_text'] . "', '#" . $settings['coffee_color'] . "', '" . $settings['coffee_code'] . "');".
                "let ".$html_variable_name." = kofiwidget2.getHTML().replace('<div class=btn-container>', '<div style=".$btn_container_style." class=btn-container>');".
                "document.writeln($html_variable_name);".
            "</script>";
        }
    }

    public static function deactivate() {

        delete_option( 'ko_fi_options' );
    }
}

add_action('plugins_loaded', ['Ko_Fi', 'init']);
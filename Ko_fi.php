<?php

/*
Plugin Name: Ko-fi Button
Plugin URI:
Description: A Ko-fi donate button for your website!
Version: 0.3.1
Author: Ko-fi Team; www.ko-fi.com
Author URI:
License: GPL2
*/

class Ko_Fi
{

    const KOFI_URL = "https://www.ko-fi.com";

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
        add_filter('the_content', [__CLASS__, 'add_to_posts'], 10, 5);
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

    public static function get_embed_code($atts)
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
                    //$pattern = '/(?:https*:\/\/)?(?:www.)?(?:ko-fi\.com\/)?([A-Z,0-9,a-z]+)\/?/';
                    //preg_match($pattern, $value, $matches);
                    $value = str_replace('http://ko-fi.com/', '', str_replace( 'https://ko-fi.com/', '', self::$options['coffee_code'] ));
                    break;
            }
            $settings[$key] = $value;
        }
        if ($settings['coffee_hyperlink'] === true) {
            return "<a href='" . self::KOFI_URL . "/" . $settings['coffee_code'] . "'>{$settings['coffee_text']}</a>";
        } else {
            return "<script type='text/javascript' src='" . self::KOFI_URL . "/widgets/widget_2.js'></script>
	        <script type='text/javascript'>kofiwidget2.init('" . $settings['coffee_text'] . "', '#" . $settings['coffee_color'] . "', '" . $settings['coffee_code'] . "');
	            kofiwidget2.draw();</script>";
        }
    }

    /**
     * Add the pretty linkbox to the bottom of all posts.
     */
    public static function add_to_posts($content)
    {
        $doPosts = false;
        if (isset(self::$options['coffee_posts'])) {
            $doPosts = self::$options['coffee_posts'];
        }
        if ($doPosts) {
            $title = self::$options['coffee_title'];
            $description = self::$options['coffee_description'];
            $code = self::$options['coffee_code'];
            $kofi_url = self::KOFI_URL;
            $linkbox = <<<EOT
    <div style="overflow:hidden;border-radius:5px 5px 5px 5px;box-shadow: 3px 2px 3px 5px;padding: 2% 2% 2% 2%; background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover-moz-background-size:cover;-o-background-size:cover;background-size:cover;border-radius:5px 5px 5px 5px;"data-bg-url="">
    <div>
        <h3 style="text-align: center;">
            {$title}
        </h3>
    </div>
    <div>
        <p style="text-align: center;">
            {$description}
        </p>
    </div>
    <div style="text-align: center; display: flex; justify-content: center;"> 
        <a href="{$kofi_url}/{$code}" target="_blank">
            <img style="border:0px;height:45px;" src="https://az743702.vo.msecnd.net/cdn/kofi5.png?v=2" alt="Buy Me a Coffee at ko-fi.com" height="45" border="0" align="middle"></a>
        </div>
    </div>
    </div>
    EOT;
            $theContent = $content;
            return (is_single()) ? $theContent . $linkbox : $theContent;

        } else {
            return $content;
        }
    }

}

add_action('plugins_loaded', ['Ko_Fi', 'init']);
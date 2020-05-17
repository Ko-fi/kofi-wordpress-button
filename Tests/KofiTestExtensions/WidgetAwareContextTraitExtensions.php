<?php

namespace KofiTestExtensions;

use PaulGibbs\WordpressBehatExtension\Context\RawWordpressContext;
use PaulGibbs\WordpressBehatExtension\Context\Traits;
use KofiTestExtensions\SideBarElement;

trait WidgetAwareContextTraitExtensions
{
    use \PaulGibbs\WordpressBehatExtension\Context\Traits\BaseAwarenessTrait;

    /**
     * Gets the widget id of the first widget in a sidebar
     * 
     * @param string $widget_name   The widget name e.g. recent-comments
     * @param string $sidebar_name  The human readable sidebar name
     * 
     * @return string   The widget Id e.g. recent_comments-1
     */
    public function getWidgetId($widget_name, $sidebar_name) {

        $widget_id = null;
        $sidebar_id = $this->getSidebar( $sidebar_name );
        $widget_list = json_decode( $this->getDriver()->wpcli('widget', 'list '.$sidebar_id, [
            '--format=json',
        ])['stdout'] );

        foreach ( $widget_list as $widget ) {

            if( $widget->name === $widget_name ) {

                $widget_id = $widget->id;
                break;
            }
        }

        if ( $widget_id === null ) {
            throw new UnexpectedValueException(sprintf('Widget "%s" could not be found', $widget_name));
        }

        return $widget_id;
    }

    /**
     * Removes all the widgets of the specified type from the specified footer
     * 
     * @param string $widget_name   The widget name e.g. recent-comments
     * @param string $sidebar_name  The human readable sidebar name
     * 
     * @return void
     */
    public function removeAllWidgetsWithNameFromSidebar( $widget_name, $sidebar_name ) {

        $sidebar_id = $this->getSidebar( $sidebar_name );
        $widget_list = json_decode( $this->getDriver()->wpcli('widget', 'list '.$sidebar_id, [
            '--format=json',
        ])['stdout'] );
        
        foreach ( $widget_list as $widget ) {

            if( $widget->name === $widget_name ) {

                $this->getDriver()->wpcli( 'widget', 'delete '.$widget->id );
            }
        }
    }

    /**
     * Dump widget info using WP CLI
     * 
     * @param string $widget_name   The widget name e.g. recent-comments
     * @param string $sidebar_name  The human readable sidebar name
     * 
     * @return void
     */
    public function dumpWidgetInfo( $widget_name, $sidebar_name ) {

        $sidebar_id = $this->getSidebar( $sidebar_name );
        $widget_list = json_decode( $this->getDriver()->wpcli('widget', 'list '.$sidebar_id, [
            '--format=json',
        ])['stdout'] );

        foreach ( $widget_list as $widget ) {

            if( $widget->name === $widget_name ) {

                var_dump( $widget );
                break;
            }
        }
    }

    /**
     * Assert the value in the text area is the expected one.
     * 
     * Test against 'getValue' vs 'getText' which is used by elementTextContains
     * because in chromium it doesn't work as as expected
     * 
     * @param string $element The Id of the element to get the value from
     * @param string $text Thr expected text value
     * 
     * @throws UnexpectedValueException if the values do not match
     * @return void
     * 
     */
    public function assertTextAreaContainsText( $element, $text  ) {
        
        $element_value = $this->getSession()->getPage()->find("css", $element)->getValue();

        if( $element_value !== $text ) {

            throw new UnexpectedValueException(sprintf('Expected "%s" but have "%s"', $text, $element_value ));

        }
    }

    /**
     * Gets a sidebar ID from its human-readable name
     *
     * @param string $sidebar_name The name of the sidebar (e.g. 'Footer', 'Widget Area', 'Right Sidebar')
     *
     * @throws UnexpectedValueException If the sidebar is not registered
     *
     * @return string The sidebar ID
     */
    private function getSidebar( $sidebar_name )
    {
        $registered_sidebars = json_decode($this->getDriver()->wpcli( 'sidebar', 'list', [
            '--format=json',
        ])['stdout'] );

        $sidebar_id = null;

        foreach ( $registered_sidebars as $sidebar ) {
            if ( $sidebar_name === $sidebar->name ) {
                $sidebar_id = $sidebar->id;
                break;
            }
        }

        if ( $sidebar_id === null ) {
            throw new UnexpectedValueException(sprintf('[W506] Sidebar "%s" does not exist', $sidebar_name));
        }

        return $sidebar_id;
    }
}
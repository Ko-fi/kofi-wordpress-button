<?php

use PaulGibbs\WordpressBehatExtension\Context\RawWordpressContext;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Mink\Exception\ExpectationException;
use Behat\Gherkin\Node\TableNode;

/**
 * Define application features from the specific context.
 */
class FeatureContext extends RawWordpressContext {

    use KofiTestExtensions\WidgetAwareContextTraitExtensions, KofiTestExtensions\OptionsAPIAwareTrait;

    private $current_widget_id = '';

    /**
     * Initialise context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the context constructor through behat.yml.
     */
    public function __construct() {
        parent::__construct();
    }

     /**
     * Removes all widgets of the specified type from the specificed sidebar
     *
     * Example: Given I have no "my_widget" widgets in "Footer"
     *
     * @Given I have no :widget_name widgets in :sidebar_name
     * 
     * @param string    $widget_name
     * @param string    $sidebar_name
     * 
     * @return void
     */
    public function NoWidgetsOfWidgetInSidebar( $widget_name, $sidebar_name ) {

        $this->removeAllWidgetsWithNameFromSidebar( $widget_name, $sidebar_name );
    }

    /**
     * Saves the widget root id for use in further steps
     *
     * Example: When I save the id of the "my_widget" in the "Footer"
     * Example: And I save the id of the "my_widget" in the "Footer"
     *
     * @When I save the id of the :widget_name in the :sidebar_name
     * 
     * @param string    $widget_name
     * @param string    $sidebar_name
     * 
     * @return void
     */
    public function SaveWidgetRootId( $widget_name, $sidebar_name )
    {
        $this->current_widget_id = $this->getWidgetId( $widget_name, $sidebar_name );
    }
    
    /**
     * Checks the value of a widget field. . Can only be called after the widget Id has been saved
     *
     * Example: Then the 'username' widget field should contain 'donkey'
     *
     * @Then the :field_name widget field should contain :value
     * 
     * @param string    $field_name
     * @param string    $value
     * 
     * @return void
     */
    public function WidgetFieldContains( $field_name, $value ) {

        $field = $this->WithWidgetId( $field_name );
        $this->assertSession()->fieldValueEquals( $field, $value );
    }

    /**
     * Checks a widget checkbox is checked. Can only be called after the widget Id has been saved
     *
     * Example: the 'hyperlink' widget checkbox should be checked
     *
     * @Then the :field_name widget checkbox should be checked
     * 
     * @param string $field_name
     * 
     * @return void
     */
    public function WidgetCheckBoxChecked( $field_name ) {

        $checkbox = $this->WithWidgetId( $field_name );
        $this->assertSession()->checkboxChecked( $checkbox );
    }

    /**
     * Checks a widget checkbox is unchecked. Can only be called after the widget Id has been saved
     *
     * Example: the 'hyperlink' widget checkbox should be unchecked
     *
     * @Then the :field_name widget checkbox should be unchecked
     * 
     * @param string $field_name
     * 
     * @return void
     */
    public function WidgetCheckBoxUnchecked( $field_name ) {

        $checkbox = $this->WithWidgetId( $field_name );
        $this->assertSession()->checkboxNotChecked( $checkbox );
    }

    /**
     * Checks, that element in a widget with specified CSS contains specified text. Can only be called after the widget Id has been saved
     * Example: Then I should see "Batman" in the "heroes_list" widget element
     * Example: And I should see "Batman" in the "heroes_list" widget element
     *
     * @Then I should see :text in the :element widget element
     * 
     * @param string    $element
     * @param string    $text
     * 
     * @return void
     */
    public function WidgetElementContainsText( $element, $text )
    {
        $element = $this->WithWidgetId( $element );            
        $this->assertTextAreaContainsText( $element, $text );
    }

    /**
     * Fills in widget form field with specified widget_id + id. Can only be called after the widget Id has been saved
     * Example: When I fill in widget field "username" with: "bwayne"
     *
     * @When I fill in widget field :field_name with :value
     *
     * @param string $field
     * @param string $value
     * 
     * @return void
     */
    public function FillWidgetField( $field, $value )
    {
        $field = $this->WithWidgetId( $field );
        $this->getSession()->getPage()->fillField( $field, $value );
    }

    /**
     * Checks widget checkbox with specified widget_id + id. Can only be called after the widget Id has been saved
     * Example: When I check widget checkbox "Pearl Necklace"
     *
     * @When I check widget checkbox :option
     * 
     * @param string $option
     * 
     * @return void
     */
    public function CheckWidgetOption( $option )
    {
        $option = $this->WithWidgetId( $option );
        $this->getSession()->getPage()->checkField( $option );
    }

    /**
     * Presses the save widget button with specified widget_id + id
     * Example: When I press the save widget button
     *
     * @When I press the save widget button
     * 
     * @return void
     */
    public function PressSaveWidgetButton()
    {
        $time = 500; //milliseconds
        $button = $this->WithWidgetId( "<widget_id>savewidget" );
        $this->getSession()->getPage()->pressButton( $button );
        $this->getSession()->wait( $time, "$('#$button').val() === 'Saved'" );
    }

    /**
     * Show information about the selected widget type
     * 
     * Example: When I show info about the "my_widget" in the "Footer"
     * 
     * @When I show info about the :widget_name in the :sidebar_name
     * 
     * @param string    $widget_name
     * @param string    $sidebar_name
     * 
     * @return void
     */
    public function ShowWidgetInfo( $widget_name, $sidebar_name ) {

        $this->dumpWidgetInfo( $widget_name, $sidebar_name );
    }

    /**
     * Open the widget configuration form on the widget page.
     * 
     * @When I wait for the widget form :title to open
     * 
     * @param string $title The title of the widget form
     * 
     * @return void
     */
    public function IWaitForWidgetFormsToOpen( $title ) {

        $time = 500; //milliseconds
        $widget_form_title = '"'.$title.'"';

        $click_open = "$('[id*=\"_$this->current_widget_id\"] button.widget-action').click()";
        $wait_for_title = "$('span:contains($widget_form_title)').length > 0;";
        $wait_for_open = "$('h3:contains($widget_form_title)').parent().parent().parent().parent().hasClass('open');";

        $this->getSession()->wait($time, $wait_for_title );
        $this->getSession()->executeScript( $click_open );
        $this->getSession()->wait($time, $wait_for_open );
    }

    /**
     * 
     * Debug assiatance, allow a pause during test operation, especially useful when running
     * a non-headless browser session 
     * 
     * @Then I pause for :milliseconds
     * 
     * @param integer The length of time to wait in milliseconds
     * 
     * @return void
     */
    public function IPause( $milliseconds )
    {
        $this->getSession()->wait($milliseconds);
    }

    /**
     * Checks widget field is readonly
     * 
     * Example: Then the 'username' widget field should be readonly
     *
     * @Then the :widget_field widget field should be readonly
     * 
     * @param string $id of widget field
     * 
     * @return void
     */
    public function CheckWidgetFieldIsReadOnly( $widget_field )
    {
        $widget_field = $this->WithWidgetId( $widget_field );
        $this->assertFieldIsReadOnly( $widget_field );
    }

    /**
     * 
     * Check if an option in the database still exists
     * 
     * Example Then the "my hero" option should not exist
     * 
     * @Then the :opton_name option should not exist
     * 
     * @param string $opton_name
     */
    public function CheckWPOptionNoLongerExists( $opton_name ) {

        $this->assertOptionDoesntExist( $opton_name );
    }

    /**
     * Check that an anchor element exists with the specified link
     * 
     * Example Then an anchor with the link :link exists
     * 
     * @Then an anchor with the link :link exists
     * 
     * @param string $link The link in the anchor
     * 
     */
    public function CheckAnchorWithLinkExists( $link ) {

        $selector = "a[href='$link']";
        $element = $this->getSession()->getPage()->find("css", $selector);

        if( $element === null ) {

            throw new \UnexpectedValueException(sprintf('Did not find the anchor element"%s"', $selector ));
        }
    }

    /**
     * Replace the widget_id place holder with the current widget id
     * 
     * @param string $name The css or element id which should have the widget id embedded in it.
     * 
     * @return string The css form of the widget id
     */
    private function WithWidgetId( $name ) {

        return str_replace( '<widget_id>', '', 
                str_replace( '<widget_id>', 'widget-'.$this->current_widget_id.'-', $name )
            );
    }

}

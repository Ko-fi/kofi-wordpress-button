Feature: Configure the Ko-Fi widget in the widget area

  @javascript
  Scenario: Test that the default values are set when adding widget
    Given I am logged in as an administrator
    And I have no "ko_fi_widget" widgets in "Footer"
    And I am on the dashboard

    When I have the 'ko_fi_widget' widget in 'Footer'
            | title                 | description                                       |  text                  |   color       |  button_alignment  |
            | Support This Site     | If you like what I do please support me on Ko-fi  |  Buy me a coffee!      |   46B798      |  left              |
    And I go to the menu 'Appearance > Widgets'
    And I save the id of the "ko_fi_widget" in the "Footer"
    And I have a legacy widget and I wait for the widget form "Ko-fi Button" to open

    Then I should see "If you like what I do please support me on Ko-fi" in the "#<widget_id>description" widget element
    And the "<widget_id>title" widget field should contain "Support This Site"
    And the "<widget_id>code" widget field should contain ""
    And the "<widget_id>code" widget field should be readonly
    And the "<widget_id>text" widget field should contain "Buy me a coffee!"
    And the "<widget_id>hyperlink" widget checkbox should be unchecked
    And the "<widget_id>color" widget field should contain "46B798"
    And the "<widget_id>button_alignment" widget field should contain "Left"

  @javascript
  Scenario: Test changing and saving of widget values works
    Given I am logged in as an administrator
    And I have no "ko_fi_widget" widgets in "Footer"
    And I am on the dashboard

    When I have the 'ko_fi_widget' widget in 'Footer'
            | title                 | description                                       |  text                  |   color       |  button_alignment  |
            | Support This Site     | If you like what I do please support me on Ko-fi  |  Buy me a coffee!      |   46B798      |  left              |
    And I go to the menu 'Appearance > Widgets'
    And I save the id of the "ko_fi_widget" in the "Footer"
    And I have a legacy widget and I wait for the widget form "Ko-fi Button" to open
    And I fill in widget field "<widget_id>title" with "Ko-Fi Test"
    And I fill in widget field "<widget_id>text" with "Buy me a pizza"
    And I fill in widget field "<widget_id>color" with "123456"
    And I fill in widget field "<widget_id>description" with "Buy me a pizza"
    And I check widget checkbox "<widget_id>hyperlink"
    And I select "Right" from widget options "<widget_id>button_alignment"
    And I press the update button on the widget screen
    And I have a legacy widget and I wait for the widget form "Ko-fi Button" to open

    Then I should see "Buy me a pizza" in the "#<widget_id>description" widget element
    And the "<widget_id>title" widget field should contain "Ko-Fi Test"
    And the "<widget_id>code" widget field should contain ""
    And the "<widget_id>text" widget field should contain "Buy me a pizza"
    And the "<widget_id>hyperlink" widget checkbox should be checked
    And the "<widget_id>color" widget field should contain "123456"
    And the "<widget_id>button_alignment" widget field should contain "Right"

  @db
  @javascript
  Scenario: Test changing the 'code' on the settings page gives the same code when adding a widget
    Given I am logged in as an administrator
    And I have no "ko_fi_widget" widgets in "Footer"
    And I am on the dashboard
    And I have the 'ko_fi_widget' widget in 'Footer'
            | title                 | description                                       |  text                  |   color       |  button_alignment  |
            | Support This Site     | If you like what I do please support me on Ko-fi  |  Buy me a coffee!      |   46B798      |  left              |

    When I go to the menu 'Settings > ko-fi Settings'
    And I fill in "ko_fi_options_coffee_code" with "supportkofi_1"
    And I press "submit"

    Then I go to the menu 'Appearance > Widgets'
    And I save the id of the "ko_fi_widget" in the "Footer"
    And I have a legacy widget and I wait for the widget form "Ko-fi Button" to open
    And the "<widget_id>code" widget field should contain "supportkofi_1"

  @db
  @javascript
  Scenario: Test saving changes in the setting pages are reflected when adding a new widget
    Given I am logged in as an administrator
    And I have no "ko_fi_widget" widgets in "Footer"
    And the "ko_fi_options" option does not exist
    And I am on the dashboard

    When I go to the menu 'Settings > ko-fi Settings'
    And I fill in "ko_fi_options_coffee_title" with "Ko-Fi Test"
    And I fill in "ko_fi_options_coffee_text" with "Buy me a pizza"
    And I fill in "ko_fi_options[coffee_color]" with "123456"
    And I fill in "ko_fi_options_coffee_description" with "Buy me a pizza"
    And I fill in "ko_fi_options_coffee_code" with "supportkofi_1"
    And I check "ko_fi_options_coffee_hyperlink"
    And I select "Right" from "ko_fi_options_coffee_button_alignment"
    And I press "submit"

    Then the "ko_fi_options_coffee_title" field should contain "Ko-Fi Test"
    And the "ko_fi_options_coffee_text" field should contain "Buy me a pizza"
    And the "ko_fi_options[coffee_color]" field should contain "123456"
    And the "ko_fi_options_coffee_description" field should contain "Buy me a pizza"
    And the "ko_fi_options_coffee_code" field should contain "supportkofi_1"
    And the "ko_fi_options_coffee_hyperlink" checkbox should be checked
    And the "ko_fi_options_coffee_button_alignment" field should contain "Right"

    And I add a "ko_fi_widget" widget to the "Footer"
    And I am on the dashboard
    And I go to the menu 'Appearance > Widgets'
    And I save the id of the "ko_fi_widget" in the "Footer"
    And I have a legacy widget and I wait for the widget form "Ko-fi Button" to open

    Then I should see "Buy me a pizza" in the "#<widget_id>description" widget element
    And the "<widget_id>title" widget field should contain "Ko-Fi Test"
    And the "<widget_id>code" widget field should contain "supportkofi_1"
    And the "<widget_id>text" widget field should contain "Buy me a pizza"
    And the "<widget_id>hyperlink" widget checkbox should be checked
    And the "<widget_id>color" widget field should contain "123456"
    And the "<widget_id>button_alignment" widget field should contain "Right" 

  @db
  @javascript
  Scenario: Test adding a widget then updating the settings doesn't change the widget settings except for page name/id

  Given I am logged in as an administrator
    And I have no "ko_fi_widget" widgets in "Footer"
    And I am on the dashboard
    And I have the 'ko_fi_widget' widget in 'Footer'
            | title               | description               |  text                     |   color       |  button_alignment   |
            | My Iced Ko-fi       | Buy me an Iced Ko-fi      |  Buy me a an Iced Ko-fi!  |   123456      |  right              |
    
    When I go to the menu 'Appearance > Widgets'
    And I save the id of the "ko_fi_widget" in the "Footer"

    Then I should see "Buy me an Iced Ko-fi" in the "#<widget_id>description" widget element
    And the "<widget_id>title" widget field should contain "My Iced Ko-fi"
    And the "<widget_id>text" widget field should contain "Buy me a an Iced Ko-fi!"
    And the "<widget_id>hyperlink" widget checkbox should be unchecked
    And the "<widget_id>color" widget field should contain "123456"
    And the "<widget_id>button_alignment" widget field should contain "Right"
    And the "<widget_id>code" widget field should contain ""

    Then I am on the dashboard
    And I go to the menu 'Settings > ko-fi Settings'
    And I fill in "ko_fi_options_coffee_title" with "Ko-Fi Test"
    And I fill in "ko_fi_options_coffee_text" with "Buy me a pizza"
    And I fill in "ko_fi_options[coffee_color]" with "123456"
    And I fill in "ko_fi_options_coffee_description" with "Buy me a pizza"
    And I fill in "ko_fi_options_coffee_code" with "supportkofi_1"
    And I check "ko_fi_options_coffee_hyperlink"
    And I select "Right" from "ko_fi_options_coffee_button_alignment"
    And I press "submit"

    Then the "ko_fi_options_coffee_title" field should contain "Ko-Fi Test"
    And the "ko_fi_options_coffee_text" field should contain "Buy me a pizza"
    And the "ko_fi_options[coffee_color]" field should contain "123456"
    And the "ko_fi_options_coffee_description" field should contain "Buy me a pizza"
    And the "ko_fi_options_coffee_code" field should contain "supportkofi_1"
    And the "ko_fi_options_coffee_hyperlink" checkbox should be checked
    And the "ko_fi_options_coffee_button_alignment" field should contain "Right"

    Then I am on the dashboard
    And I go to the menu 'Appearance > Widgets'
    And I save the id of the "ko_fi_widget" in the "Footer"
    And I have a legacy widget and I wait for the widget form "Ko-fi Button" to open

    Then I should see "Buy me an Iced Ko-fi" in the "#<widget_id>description" widget element
    And the "<widget_id>title" widget field should contain "My Iced Ko-fi"
    And the "<widget_id>text" widget field should contain "Buy me a an Iced Ko-fi!"
    And the "<widget_id>hyperlink" widget checkbox should be unchecked
    And the "<widget_id>color" widget field should contain "123456"
    And the "<widget_id>button_alignment" widget field should contain "Right"
    And the "<widget_id>code" widget field should contain "supportkofi_1"
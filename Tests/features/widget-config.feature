Feature: Configure the Ko-Fi widget in the widget area

  Scenario: Test that the default values are set when adding widget
    Given I am logged in as an administrator
    And I have no "ko_fi_widget" widgets in "Footer"
    And I am on the dashboard

    When I have the 'ko_fi_widget' widget in 'Footer'
    | Title             | Description            | Code                 |  "Button text"        |   Hyperlink   |    "Button (hex)color"      |
    | My Ko-fi button   | Buy me a coffee!       | http://ko-fi.com/    |   Buy me a coffee!    |   checked     |    46B798                   |
    And I go to the menu 'Appearance > Widgets'
    And I save the id of the "ko_fi_widget" in the "Footer"

    Then I should see "Buy me a coffee!" in the "#<widget_id>description" widget element
    And the "<widget_id>title" widget field should contain "My Ko-fi button"
    And the "<widget_id>code" widget field should contain "http://ko-fi.com/"
    And the "<widget_id>code" widget field should be readonly
    And the "<widget_id>text" widget field should contain "Buy me a coffee!"
    And the "<widget_id>hyperlink" widget checkbox should be unchecked
    And the "<widget_id>color" widget field should contain "46B798"

  @javascript
  Scenario: Test changing and saving of widget values works
    Given I am logged in as an administrator
    And I have no "ko_fi_widget" widgets in "Footer"
    And I am on the dashboard

    When I have the 'ko_fi_widget' widget in 'Footer'
    | Title             | Description            | Code                 |  "Button text"        |   Hyperlink   |    "Button (hex)color"      |
    | My Ko-fi button   | Buy me a coffee!       | http://ko-fi.com/    |   Buy me a coffee!    |   checked     |    46B798                   |
    And I go to the menu 'Appearance > Widgets'
    And I save the id of the "ko_fi_widget" in the "Footer"
    And I wait for the widget form "My Ko-fi button" to open
    And I fill in widget field "<widget_id>title" with "Ko-Fi Test"
    And I fill in widget field "<widget_id>text" with "Buy me a pizza"
    And I fill in widget field "<widget_id>color" with "123456"
    And I fill in widget field "<widget_id>description" with "Buy me a pizza"
    And I check widget checkbox "<widget_id>hyperlink"
    And I press the save widget button

    Then I should see "Buy me a pizza" in the "#<widget_id>description" widget element
    And the "<widget_id>title" widget field should contain "Ko-Fi Test"
    And the "<widget_id>code" widget field should contain "http://ko-fi.com/"
    And the "<widget_id>text" widget field should contain "Buy me a pizza"
    And the "<widget_id>hyperlink" widget checkbox should be checked
    And the "<widget_id>color" widget field should contain "123456"

  @db
  Scenario: Test changing the 'code' on the settings page gives the same code when adding a widget
    Given I am logged in as an administrator
    And I have no "ko_fi_widget" widgets in "Footer"
    And I am on the dashboard
    And I have the 'ko_fi_widget' widget in 'Footer'
    | Title             | Description            | Code                 |  "Button text"        |   Hyperlink   |    "Button (hex)color"      |
    | My Ko-fi button   | Buy me a coffee!       | http://ko-fi.com/    |   Buy me a coffee!    |   checked     |    46B798                   |

    When I go to the menu 'Settings > ko-fi Settings'
    And I fill in "ko_fi_options_coffee_code" with "http://ko-fi.com/123456"
    And I press "submit"

    Then I go to the menu 'Appearance > Widgets'
    And I save the id of the "ko_fi_widget" in the "Footer"
    And the "<widget_id>code" widget field should contain "http://ko-fi.com/123456"

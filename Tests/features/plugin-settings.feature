Feature: Test that the settings page works as expected

  Scenario: Test the settings page loads
    Given I am logged in as an administrator
    And  the "kofi-button/Ko_fi" plugin is active
    And I am on the dashboard

    When I go to the menu 'Settings > ko-fi Settings'
    Then I should not see "Notice:"
    And I should not see "Warning:"

  Scenario: Test that the default values are set
    Given I am logged in as an administrator
    And  the "kofi-button/Ko_fi" plugin is active
    And I am on the dashboard

    When I go to the menu 'Settings > ko-fi Settings'
    Then the "ko_fi_options_coffee_title" field should contain "My Ko-fi button"
    And the "ko_fi_options_coffee_text" field should contain "Buy me a coffee!"
    And the "ko_fi_options[coffee_color]" field should contain "46B798"
    And the "ko_fi_options_coffee_description" field should contain "Buy me a coffee!"
    And the "ko_fi_options_coffee_code" field should contain "http://ko-fi.com/"
    And the "ko_fi_options_coffee_hyperlink" checkbox should be unchecked

  @db
  Scenario: test field values can be saved
    Given I am logged in as an administrator
    And  the "kofi-button/Ko_fi" plugin is active
    And I am on the dashboard

    When I go to the menu 'Settings > ko-fi Settings'
    And I fill in "ko_fi_options_coffee_title" with "Ko-Fi Test"
    And I fill in "ko_fi_options_coffee_text" with "Buy me a pizza"
    And I fill in "ko_fi_options[coffee_color]" with "123456"
    And I fill in "ko_fi_options_coffee_description" with "Buy me a pizza"
    And I fill in "ko_fi_options_coffee_code" with "http://ko-fi.com/123456"
    And I check "ko_fi_options_coffee_hyperlink"
    And I press "submit"
    Then the "ko_fi_options_coffee_title" field should contain "Ko-Fi Test"
    Then the "ko_fi_options_coffee_text" field should contain "Buy me a pizza"
    Then the "ko_fi_options[coffee_color]" field should contain "123456"
    Then the "ko_fi_options_coffee_description" field should contain "Buy me a pizza"
    Then the "ko_fi_options_coffee_code" field should contain "http://ko-fi.com/123456"
    Then the "ko_fi_options_coffee_hyperlink" checkbox should be checked
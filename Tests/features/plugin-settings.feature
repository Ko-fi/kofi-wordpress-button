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
    And the "ko_fi_options" option does not exist
    And I am on the dashboard

    When I go to the menu 'Settings > ko-fi Settings'
    Then the "ko_fi_options_coffee_title" field should contain "Support This Site"
    And the "ko_fi_options_coffee_text" field should contain "Buy me a coffee!"
    And the "ko_fi_options[coffee_color]" field should contain "ff5f5f"
    And the "ko_fi_options_coffee_description" field should contain "If you like what I do please support me on Ko-fi"
    And the "ko_fi_options_coffee_code" field should contain ""
    And the "ko_fi_options_coffee_hyperlink" checkbox should be unchecked
    And the "ko_fi_options_coffee_button_alignment" field should contain "Left"

  @db
  Scenario: Test field values can be saved
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
    And I select "Right" from "ko_fi_options_coffee_button_alignment"
    And I press "submit"
    Then the "ko_fi_options_coffee_title" field should contain "Ko-Fi Test"
    Then the "ko_fi_options_coffee_text" field should contain "Buy me a pizza"
    Then the "ko_fi_options[coffee_color]" field should contain "123456"
    Then the "ko_fi_options_coffee_description" field should contain "Buy me a pizza"
    Then the "ko_fi_options_coffee_code" field should contain "http://ko-fi.com/123456"
    Then the "ko_fi_options_coffee_hyperlink" checkbox should be checked
    Then the "ko_fi_options_coffee_button_alignment" field should contain "Right"

  @db
  Scenario: Test that after deactivation the ko_fi_options no longer exist
    Given I am logged in as an administrator
    And  the "kofi-button/Ko_fi" plugin is active
    And I am on the dashboard

    When I go to the menu 'Settings > ko-fi Settings'
    Then I deactivate the "kofi-button/Ko_fi" plugin
    Then the "ko_fi_options" option should not exist

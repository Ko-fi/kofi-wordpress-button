Feature: Display the widget on the front page

    @db
    Scenario: Test the widget is displayed on the front page without errors
        Given I am logged in as an administrator
        And the "ko_fi_options" option does not exist
        And  the "kofi-button/Ko_fi" plugin is active
        And I have no "ko_fi_widget" widgets in "Footer"
        And I have the 'ko_fi_widget' widget in 'Footer'
            | title              | description                                          |  text                  |   color       |  button_alignment  |
            | My Ko-fi button    | If you like what I do please support me on Ko-fi     |  Buy me a coffee!      |   46B798      |  left              |

        When I go to "/"
        Then I should not see "Notice:"
        And I should not see "Warning:"
 
    @db
    Scenario: Test the widget is displayed on the front page with the following settings
        Given I am logged in as an administrator
        And the "ko_fi_options" option does not exist
        And  the "kofi-button/Ko_fi" plugin is active
        And I have no "ko_fi_widget" widgets in "Footer"
        And I have the 'ko_fi_widget' widget in 'Footer'
            | title              | description                                            |  text                  |   color       |  button_alignment  |
            | My Ko-fi button    | If you like what I do please support me on Ko-fi       |  Buy me a coffee!      |   46B798      |  left              |
        
        When I go to "/"
        Then I should see "My Ko-fi button"
        And I should see "If you like what I do please support me on Ko-fi" in the "section.ko_fi_widget p" element
        And the "section.ko_fi_widget" element should contain "kofiwidget2.init('Buy me a coffee!', '#46B798', '');"

    @db
    Scenario: Test the widget hyperlink is displayed when the hyperlink option is set
        Given I am logged in as an administrator
        And the "ko_fi_options" option does not exist
        And the "kofi-button/Ko_fi" plugin is active
        And I have no "ko_fi_widget" widgets in "Footer"
        And I have the 'ko_fi_widget' widget in 'Footer'
            | title              | description            |  text                  |   color       |  button_alignment  |   hyperlink   |
            | My Ko-fi button    | Buy me a coffee!       |  Buy me a coffee!      |   46B798      |  left              |   true        |

        When I am on the dashboard
        And I go to the menu 'Settings > ko-fi Settings'
        And I fill in "ko_fi_options_coffee_title" with "Ko-Fi Test"
        And I fill in "ko_fi_options_coffee_text" with "Buy me a pizza"
        And I fill in "ko_fi_options[coffee_color]" with "123456"
        And I fill in "ko_fi_options_coffee_description" with "Buy me a pizza"
        And I fill in "ko_fi_options_coffee_code" with "123456"
        And I check "ko_fi_options_coffee_hyperlink"
        And I select "Right" from "ko_fi_options_coffee_button_alignment"
        And I press "submit"

        Then I go to "/"
        And I should see "My Ko-fi button"
        And an anchor with the link "http://www.ko-fi.com/123456" exists
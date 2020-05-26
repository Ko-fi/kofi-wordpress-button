Feature: Display the widget on the front page

    @db
    Scenario: Test the widget is displayed on the front page without errors
        Given I am logged in as an administrator
        And  the "kofi-button/Ko_fi" plugin is active
        And I have no "ko_fi_widget" widgets in "Footer"
        And I have the 'ko_fi_widget' widget in 'Footer'
            | title              | description           |  text                    |
            | My Ko-fi button    | Buy me a coffee!      |  Buy me a coffee!        |              

        When I go to "/"
        Then I should not see "Notice:"
        And I should not see "Warning:"

    @do_test
    @db
    Scenario: Test the widget is displayed on the front page with the following settings
        Given I am logged in as an administrator
        And  the "kofi-button/Ko_fi" plugin is active
        And I have no "ko_fi_widget" widgets in "Footer"
        And I have the 'ko_fi_widget' widget in 'Footer'
            | title              | description           |  text                  |   color       |
            | My Ko-fi button   | Buy me a coffee!       |  Buy me a coffee!      |    46B798     |
        
        When I go to "/"
        Then I should see "My Ko-fi button"
        And I should see "Buy me a coffee!" in the "section.ko_fi_widget p" element
        And the "section.ko_fi_widget" element should contain "kofiwidget2.init('Buy me a coffee!', '#46B798', 'supportkofi');"

    @db
    Scenario: Test the widget hyperlink is displayed when the hyperlink option is set
        Given I am logged in as an administrator
        And the "kofi-button/Ko_fi" plugin is active
        And I have no "ko_fi_widget" widgets in "Footer"
        And I have the 'ko_fi_widget' widget in 'Footer'
            | title              | description            |  text                  |   color       |   hyperlink   |
            | My Ko-fi button    | Buy me a coffee!       |  Buy me a coffee!      |   46B798      |   true        |

        When I go to "/"
        Then I should see "My Ko-fi button"
        And an anchor with the link "http://www.ko-fi.com/supportkofi" exists
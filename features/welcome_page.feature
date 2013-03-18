Feature: Welcome page
    As any user
    I want to see a welcome page that allows me to choose my role
    So that I can be redirected to the right location

    Background:
        Given I am on "/"

    Scenario: Requester
        When I follow "welcome.requester"
        Then I should be on "/request/login"

    Scenario: Agent
        When I follow "welcome.agent"
        Then I should be on "/agent/login"

    Scenario: Dispatcher
        When I follow "welcome.dispatcher"
        Then I should be on "/dispatch/login"

    Scenario: Admin
        When I follow "welcome.admin"
        Then I should be on "/admin/login"
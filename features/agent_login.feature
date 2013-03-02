Feature: Agent login
    In order to start using the Agent interface
    I need to log in

    Scenario: Redirection
        Given I am on "/agent"
        Then I should be on "/agent/login"

    Scenario: Successful login
        Given an agent identified by "foo@foo.com", "bar"
        And I am on "/agent/login"
        When I fill in "email" with "foo@foo.com"
        And I fill in "password" with "bar"
        And I press "Login"
        Then I should be on "/agent/"

    Scenario: Failed login due to incorrect credentials
        Given an agent identified by "foo@foo.com", "bar"
        And I am on "/agent/login"
        When I fill in "email" with "foo@foo.com"
        And I fill in "password" with "bars"
        And I press "Login"
        Then I should be on "/agent/login"
        And I should see "Bad credentials"

    Scenario: Failed login due to wrong user type
        Given a requester identified by "foo@foo.com", "bar"
        And I am on "/agent/login"
        When I fill in "email" with "foo@foo.com"
        And I fill in "password" with "bar"
        And I press "Login"
        Then I should see "login.permissions.invalid"

Feature: Admin login
    In order to start using the Admin interface
    I need to log in

    Scenario: Redirection
        Given I am on "/admin"
        Then I should be on "/admin/login"

    Scenario: Successful login
        Given an admin identified by "foo@foo.com", "bar"
        And I am on "/admin/login"
        When I fill in "email" with "foo@foo.com"
        And I fill in "password" with "bar"
        And I press "Login"
        Then I should be on "/admin/"

    Scenario: Failed login due to incorrect credentials
        Given an admin identified by "foo@foo.com", "bar"
        And I am on "/admin/login"
        When I fill in "email" with "foo@foo.com"
        And I fill in "password" with "bars"
        And I press "Login"
        Then I should be on "/admin/login"
        And I should see "Bad credentials"

    Scenario: Failed login due to wrong user type
        Given a requester identified by "foo@foo.com", "bar"
        And I am on "/admin/login"
        When I fill in "email" with "foo@foo.com"
        And I fill in "password" with "bar"
        And I press "Login"
        Then I should see "login.permissions.invalid"

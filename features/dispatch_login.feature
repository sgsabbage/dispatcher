Feature: Dispatch login
    In order to start using the Dispatch interface
    I need to log in

    Scenario: Redirection
        Given I am on "/dispatch"
        Then I should be on "/dispatch/login"

    Scenario: Successful login
        Given a dispatcher identified by "foo@foo.com", "bar"
        And I am on "/dispatch/login"
        When I fill in "email" with "foo@foo.com"
        And I fill in "password" with "bar"
        And I press "Login"
        Then I should be on "/dispatch/"

    Scenario: Failed login due to incorrect credentials
        Given a dispatcher identified by "foo@foo.com", "bar"
        And I am on "/dispatch/login"
        When I fill in "email" with "foo@foo.com"
        And I fill in "password" with "bars"
        And I press "Login"
        Then I should be on "/dispatch/login"
        And I should see "Bad credentials"

    Scenario: Failed login due to wrong user type
        Given a requester identified by "foo@foo.com", "bar"
        And I am on "/dispatch/login"
        When I fill in "email" with "foo@foo.com"
        And I fill in "password" with "bar"
        And I press "Login"
        Then I should see "login.permissions.invalid"

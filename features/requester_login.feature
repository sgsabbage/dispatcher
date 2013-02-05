Feature: Requester login
    In order to start using the Requested interface
    I need to log in

    Scenario: Successful login
        Given a requester identified by "foo@foo.com", "bar"
        And I am on "/request/login"
        When I fill in "email" with "foo@foo.com"
        And I fill in "password" with "bar"
        And I press "Login"
        Then I should be on "/request"

    Scenario: Failed login due to incorrect credentials
        Given a requester identified by "foo@foo.com", "bar"
        And I am on "/request/login"
        When I fill in "email" with "foo@foo.com"
        And I fill in "password" with "bars"
        And I press "Login"
        Then I should be on "/request/login"
        And I should see "Bad credentials"

    Scenario: Failed login due to wrong user type
        Given an agent identified by "foo@foo.com", "bar"
        And I am on "/request/login"
        When I fill in "email" with "foo@foo.com"
        And I fill in "password" with "bar"
        And I press "Login"
        Then I should see "login.permissions.invalid"

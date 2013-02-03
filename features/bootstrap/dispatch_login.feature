Feature: Dispatch login
    In order to start using the Dispatch interface
    I need to log in

    Scenario: Successful login
        Given a dispatcher identified by "foo@foo.com", "bar"
        And I am on "/dispatch/login"
        When I fill in "email" with "foo@foo.com"
        And I fill in "password" with "bar"
        And I press "login"
        Then I should be on "/dispatch"

    Scenario: Failed login due to incorrect credentials
        Given a dispatcher identified by "foo@foo.com", "bar"
        And I am on "/dispatch/login"
        When I fill in "email" with "foo@foo.com"
        And I fill in "password" with "bars"
        And I press "login"
        Then I should be on "/dispatch/login"
        And I should see "Invalid credentials"

    Scenario: Failed login due to wrong user type
        Given a requester identified by "foo@foo.com", "bar"
        And I am on "/dispatch/login"
        When I fill in "email" with "foo@foo.com"
        And I fill in "password" with "bar"
        And I press "login"
        Then I should be on "/dispatch/login"
        And I should see "Invalid permissions"

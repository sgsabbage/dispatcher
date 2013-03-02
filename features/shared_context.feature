Feature: Shared contexts
    As a user with multiple types
    I want to be able to log in once to multiple interfaces

    Scenario: Login as agent and go to request
        Given a multi-role user identified by "foo@foo.com", "bar"
        When I log in as an agent with "foo@foo.com", "bar"
        And I go to "/request"
        Then I should be on "/request/"
        And I should not see "login.permissions.invalid"

    Scenario: Login as agent and go to dispatch
        Given a multi-role user identified by "foo@foo.com", "bar"
        When I log in as an agent with "foo@foo.com", "bar"
        And I go to "/dispatch"
        Then I should be on "/dispatch/"
        And I should not see "login.permissions.invalid"

    Scenario: Login as agent and go to admin
        Given a multi-role user identified by "foo@foo.com", "bar"
        When I log in as an agent with "foo@foo.com", "bar"
        And I go to "/admin"
        Then I should be on "/admin/"
        And I should not see "login.permissions.invalid"

    Scenario: Login as admin and go to agent 
        Given a multi-role user identified by "foo@foo.com", "bar"
        When I log in as an admin with "foo@foo.com", "bar"
        And I go to "/agent"
        Then I should be on "/agent/"
        And I should not see "login.permissions.invalid"

    Scenario: Login as admin and go to request
        Given a multi-role user identified by "foo@foo.com", "bar"
        When I log in as an admin with "foo@foo.com", "bar"
        And I go to "/request"
        Then I should be on "/request/"
        And I should not see "login.permissions.invalid"

    Scenario: Login as admin and go to dispatch
        Given a multi-role user identified by "foo@foo.com", "bar"
        When I log in as an admin with "foo@foo.com", "bar"
        And I go to "/dispatch"
        Then I should be on "/dispatch/"
        And I should not see "login.permissions.invalid"

    Scenario: Login as dispatcher and go to request
        Given a multi-role user identified by "foo@foo.com", "bar"
        When I log in as an dispatcher with "foo@foo.com", "bar"
        And I go to "/request"
        Then I should be on "/request/"
        And I should not see "login.permissions.invalid"

    Scenario: Login as dispatcher and go to agent
        Given a multi-role user identified by "foo@foo.com", "bar"
        When I log in as an dispatcher with "foo@foo.com", "bar"
        And I go to "/agent"
        Then I should be on "/agent/"
        And I should not see "login.permissions.invalid"

    Scenario: Login as dispatcher and go to admin
        Given a multi-role user identified by "foo@foo.com", "bar"
        When I log in as an dispatcher with "foo@foo.com", "bar"
        And I go to "/admin"
        Then I should be on "/admin/"
        And I should not see "login.permissions.invalid"

    Scenario: Login as requester and go to agent
        Given a multi-role user identified by "foo@foo.com", "bar"
        When I log in as an requester with "foo@foo.com", "bar"
        And I go to "/agent"
        Then I should be on "/agent/"
        And I should not see "login.permissions.invalid"

    Scenario: Login as requester and go to dispatch
        Given a multi-role user identified by "foo@foo.com", "bar"
        When I log in as an requester with "foo@foo.com", "bar"
        And I go to "/dispatch"
        Then I should be on "/dispatch/"
        And I should not see "login.permissions.invalid"

    Scenario: Login as requester and go to admin
        Given a multi-role user identified by "foo@foo.com", "bar"
        When I log in as an requester with "foo@foo.com", "bar"
        And I go to "/admin"
        Then I should be on "/admin/"
        And I should not see "login.permissions.invalid"
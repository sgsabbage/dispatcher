Feature: Viewing job as requester
    As a requester
    I want to be able to view a job I have requested
    So that I can see its current status

    Background:
        Given a requester identified by "foo@bar.com", "pass"
        And I am logged in as a requester with "foo@bar.com", "pass"

    Scenario: Viewing job from dashboard
        Given a job belonging to "foo@bar.com" called "Foo job"
        And I am on "/request"
        When I follow "Foo job"
        Then I should be on "/request/job/1"
        And I should see "Foo job"

    Scenario: Trying to view someone else's job
        Given a requester identified by "foo@foo.com", "pass"
        And a job belonging to "foo@foo.com" called "Foo job"
        When I go to "/request/job/1"
        Then I should be on "/request/"
        And I should see "request.invalid.job"
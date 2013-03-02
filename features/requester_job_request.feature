Feature: Requesting jobs
    As a requester
    I want to be able to request jobs
    So that an engineer can be assigned and dispatched

    Background:
        Given a requester identified by "foo@bar.com", "pass"
        And I am logged in as a requester with "foo@bar.com", "pass"

    Scenario: Request a job from dashboard
        Given I am on "/request"
        When I follow "request.job.new"
        Then I should be on "/request/job/new"

    Scenario: Request a job
        When I go to "/request/job/new"
        And I fill in "job.name" with "Foo Job"
        And I press "request.job.submit"
        Then I should be on "/request/job/1"
        And I should see "Foo job"

    Scenario: Request a job with no name
        When I go to "/request/job/new"
        And I press "request.job.submit"
        Then I should see "This value should not be blank."

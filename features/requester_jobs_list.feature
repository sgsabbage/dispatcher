Feature: Requester jobs listing
    As a requester
    I want to be able to see a list of all of my requested jobs
    So that I can track them effectively

    Background:
        Given a requester identified by "foo@bar.com", "pass"

    @debug
    Scenario: See own jobs
        Given a job belonging to "foo@bar.com" called "Foo job"
        When I log in as a requester with "foo@bar.com", "pass"
        And I go to "/request"
        Then print last response
        Then I should see "Foo job"

    Scenario: Not see other jobs
        And a requester identified by "foo@foo.com", "pass"
        And a job belonging to "foo@foo.com" called "Foo job"
        When I log in as a requester with "foo@bar.com", "pass"
        And I go to "/request"
        Then I should not see "Foo job" 
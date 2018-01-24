@javascript
Feature: Allow only XHR requests for some association types actions
  In order to protect association types from CSRF attacks
  As a developer
  I need to only do XHR calls for some association types actions

  Background:
    Given a "footwear" catalog configuration

  Scenario: Authorize only XHR calls for association types deletion
    When I make a direct authenticated DELETE call on the "PACK" association type
    And I am logged in as "Julia"
    And I am on the association types page
    Then I should see association types PACK

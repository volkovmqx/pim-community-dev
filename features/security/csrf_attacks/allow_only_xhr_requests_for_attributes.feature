@javascript
Feature: Allow only XHR requests for some attributes actions
  In order to protect attributes from CSRF attacks
  As a developer
  I need to only do XHR calls for some attributes actions

  Background:
    Given a "footwear" catalog configuration

  Scenario: Authorize only XHR calls for attribute options creation
    When I make a direct authenticated GET call to create an attribute option for "color" attribute


  Scenario: Authorize only XHR calls for attributes deletion

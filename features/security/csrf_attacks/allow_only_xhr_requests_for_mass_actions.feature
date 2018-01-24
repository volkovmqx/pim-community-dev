Feature: Allow only XHR requests for some mass actions
  In order to protect mass actions from CSRF attacks
  As a developer
  I need to only do XHR calls for some mass actions

  Background:
    Given a "footwear" catalog configuration
    And the following product:
      | sku        |
      | high-heels |

  Scenario: Authorize only XHR calls for mass actions
    When I make a direct authenticated GET call to mass delete "high-heels" product
    And I am authenticating as "admin" with "admin_api_key" api key
    When I request information for product "high-heels"
    Then the response code should be 200

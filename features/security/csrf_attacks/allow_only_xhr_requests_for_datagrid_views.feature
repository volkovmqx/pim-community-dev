@javascript
Feature: Allow only XHR requests for some datagrid views actions
  In order to protect datagrid views from CSRF attacks
  As a developer
  I need to only do XHR calls for some datagrid views actions

  Background:
    Given a "footwear" catalog configuration
    And the following datagrid views:
      | label     | alias        | columns | filters   |
      | Sku views | product-grid | sku     | f[sku]=-1 |

  Scenario: Authorize only XHR calls for datagrid views deletion
    When I make a direct authenticated DELETE call on the first datagrid view
    And I am logged in as "Julia"
    And I am on the products page
    Then I should see the "Sku views" view

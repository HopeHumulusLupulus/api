Feature: Test of user area
  Scenario: Get about endpoint
    When send a GET request to "/about"
    Then the response should contain json:
    """
      {"title":"Title","body":"Body","footer":"Footer"}
    """

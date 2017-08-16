@distribution
# features/distribution.feature
Feature: distribution
    In some German federal states’ elections the parliamentary seats are distributed as follows. The seats allocated to a party are calculated by this method in two steps:
    In the first step the corresponding number of votes that are attributable to a party is multiplied by the total number of available seats and divided by the total number of valid votes.
    In the second step the result is split into the integer portion and the rest. The integer parts are attributed to the respective party as seats. The remaining seats are allocated to parties in the order of the size of the fractional portions.

Scenario: get parties in all Germany
    Given there are no seats distribution for German's "Berlin"
    And number of seats in parliament is "15"
    And there are voting results:
        | party  | votes | state  |
        | A      | 15000 | Berlin |
        | B      |  5400 | Berlin |
        | C      |  5500 | Berlin |
        | D      |  5550 | Berlin |
    When I run API request POST "http://127.0.0.1:8000/distribution/"
    And  I run API request GET "http://127.0.0.1:8000/distribution/state/Berlin/"
    Then I should get:
        | party  | seats | state  |
        | A      |     7 | Berlin |
        | B      |     2 | Berlin |
        | C      |     3 | Berlin |
        | D      |     3 | Berlin |


<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    
    /**
     * German state
     *
     * @var string
     */
    private $state;
    
    /**
     * Number of seats in Parliament
     *
     * @var int
     */
    private $seatsNum;
    
    /**
     * Array containg data for post.
     *
     * @var array
     */
    private $postData;
    
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }
    
    /**
     *
     * @var array 
     */
    private $parties;
    
    /**
     * @Given there are no seats distribution for German's :arg1
     */
    public function thereAreNoSeatsDistributionForGermans($state)
    {
        $this->state = $state;
        $client = new GuzzleHttp\Client();
        $apiUrl = "http://127.0.0.1:8000/distribution/state/" . $this->state . "/";

        $response = $client->delete($apiUrl);
    }
    
    /**
     * @Given number of seats in parliament is :arg1
     */
    public function numberOfSeatsInParliamentIs($seatsNum)
    {
        $this->seatsNum = $seatsNum;
    }


    /**
     * @Given there are voting results:
     */
    public function thereAreVotingResults(TableNode $table)
    {
        $hash = $table->getHash();
        $data = [];
        $data["seats_num"] = $this->seatsNum;
	$data["state"] = "Berlin";
        $data["parties"] = [];
        foreach ($hash as $row) {
            $data["parties"][$row['party']] = $row["votes"];
        }
        $this->postData = $data;
    }

    /**
     * @When I run API request POST :arg1
     */
    public function iRunApiRequestPost($apiUrl)
    {
        $client = new GuzzleHttp\Client();
        $this->postData["state"] = "Berlin";
        $response = $client->post($apiUrl, [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode($this->postData)
        ]);
        $this->parties = json_decode($response->getBody(), true);
    }
    
    /**
     * @When I run API request GET :arg1
     */
    public function iRunApiRequestGet($apiUrl)
    {
        $client = new GuzzleHttp\Client();
        $response = $client->get($apiUrl);
        $result = json_decode($response->getBody(), true);
        $this->parties = [];
        foreach($result as $value)
        {
            $this->parties[$value['name']] = $value;
        }
    }


    /**
     * @Then I should get:
     */
    public function iShouldGet(TableNode $table)
    {
        $results = $table->getColumnsHash();

        foreach ($results as $result) 
        {
            if (key_exists($result['party'], $this->parties))
            {
                if ($result['seats'] != $this->parties[$result['party']]['seats'])
                {
                    throw new Exception();
                }
            }
        }
        return true;
    }

    
}

<?php
namespace Tests\AppBundle\Services;

use AppBundle\Services\GermanStates;
use PHPUnit\Framework\TestCase;

class GermanStatesTest extends TestCase
{
    /**
     * Tests number of German states.
     */
    public function testGetAllTrue()
    {
        $states = new GermanStates();

        // assert that number of states is correct.
        $this->assertEquals(16, count($states->getAll()));
    }
    
    /**
     * Tests if Berlin is German state.
     */
    public function testGetExistingFalse()
    {
        $states = new GermanStates();
        $state = "Berlin";
                
        // assert that 'Berlin' is German's state.
        $this->assertEquals(true, $states->isGermanState($state));
    }
    
    /**
     * Tests if Germany is German state.
     */
    public function testGetNonExistingFalse()
    {
        $states = new GermanStates();
        $state = "Germany";
                
        // assert that 'Germany' is not German's state.
        $this->assertEquals(false, $states->isGermanState($state));
    }
}
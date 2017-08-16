<?php
namespace Tests\AppBundle\Services;

use AppBundle\Services\Parliament;
use AppBundle\Entity\Party;
use PHPUnit\Framework\TestCase;
use Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use AppBundle\Services\PartyHandler;

class PartyHandlerTest extends TestCase
{
    /**
     * 
     * @var Doctrine\Common\Persistence\ObjectRepository; 
     */
    private $reposetory;
    
    /**
     *
     * @var Doctrine\Common\Persistence\ObjectManager;
     */
    private $objectManager;
    
    /**
     * Initialization.
     */
    private function init()
    {
        $this->reposetory = $this->createMock(ObjectRepository::class);
        $this->objectManager = $this->createMock(ObjectManager::class);
        
        $this->objectManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($this->reposetory);
    }
    
    /**
     * 
     */
    function __construct() 
    {
        parent::__construct();
        $this->init();
    }
    
    /**
     * Tests geting parties.
     */
    public function testGetParties()
    {
        $parties = [];
        
        $party = new Party();
        $party->setName('A')->setState('Berlin')->setVotes(1000);
        $parties[] = $party;
        
        $party = new Party();
        $party->setName('B')->setState('Berlin')->setVotes(5000);
        $parties[] = $party;
        
        $party = new Party();
        $party->setName('C')->setState('Berlin')->setVotes(5555);
        $parties[] = $party;
        
        $party = new Party();
        $party->setName('D')->setState('Berlin')->setVotes(55);
        $parties[] = $party;
        
        $this->reposetory->expects($this->any())
            ->method('findAll')
            ->willReturn($parties);
        
        $partHandler = new PartyHandler($this->objectManager, "AppBundle\Entity\Party");
        $this->assertEquals(count($parties), count($partHandler->getAll()));
    }
    
    /**
     * Tests getting party by name.
     */
    public function testGetPartyByName()
    {
        $parties = [];
        
        $partyBerlin1 = new Party();
        $partyBerlin1->setName('A')->setState('Berlin')->setVotes(1000);
        $parties[] = $partyBerlin1;
        
        $partyBerlin2 = new Party();
        $partyBerlin2->setName('B')->setState('Berlin')->setVotes(5000);
        $parties[] = $partyBerlin2;
        
        $partyBavaria1 = new Party();
        $partyBavaria1->setName('C')->setState('Bavaria')->setVotes(5555);
        
        $partyBavaria2 = new Party();
        $partyBavaria2->setName('D')->setState('Bavaria')->setVotes(55);
        
        $this->reposetory->expects($this->any())
            ->method('findBy')
            ->willReturn([$partyBerlin1, $partyBerlin2]);
        
        $partHandler = new PartyHandler($this->objectManager, "AppBundle\Entity\Party");
        $this->assertEquals(count($parties), count($partHandler->getByState('Berlin')));
        
    }
    
    /**
     * Tests saving single party.
     */
    public function testSaveParty()
    {
        $this->objectManager
            ->expects($this->any())
            ->method('persist')
            ->will($this->returnValue(true));
        $this->objectManager
            ->expects($this->any())
            ->method('flush')
            ->will($this->returnValue(true));
        
        $partHandler = new PartyHandler($this->objectManager, "AppBundle\Entity\Party");
        $party = new Party();
        $this->assertTrue(true, $partHandler->save($party));

    }
    
    /**
     * Tests deleting single party.
     */
    public function testDeletingParty()
    {
        $this->objectManager
            ->expects($this->any())
            ->method('persist')
            ->will($this->returnValue(true));
        $this->objectManager
            ->expects($this->any())
            ->method('flush')
            ->will($this->returnValue(true));
        
        $partHandler = new PartyHandler($this->objectManager, "AppBundle\Entity\Party");
        $party = new Party();
        $this->assertTrue(true, $partHandler->delete($party));

    }
}
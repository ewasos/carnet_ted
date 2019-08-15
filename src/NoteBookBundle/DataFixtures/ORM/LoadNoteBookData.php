<?php
// src/NoteBookBundle/DataFixtures/ORM/LoadNoteBookData.php
namespace NoteBookBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use LialBundle\Entity\Lial;
use NoteBookBundle\Entity\NoteBook;

class LoadNoteBookData
       extends AbstractFixture 
       implements OrderedFixtureInterface	   
{
	  /**
	  * Load data fixtures with the passed EntityManager
	  * @param ObjectManager $manager
      */  
		 public function load(ObjectManager $manager)    {	 

				$notebook = new NoteBook();
				$notebook -> setName('Notebook');
				$notebook -> setCreatedAt(new \DateTime);

				$this->setReference('note-book', $notebook);
				    
				$manager->persist($notebook);
			    $manager->flush();
		} 
		
		  /**
		  * Get the order of this fixture
		  * @return integer
		  */
		  public function getOrder()
		  {
			return 1;
		  }
}




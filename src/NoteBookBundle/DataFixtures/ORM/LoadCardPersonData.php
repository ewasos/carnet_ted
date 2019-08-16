<?php
// src/NoteBookBundle/DataFixtures/ORM/LoadCardPersonData.php
namespace NoteBookBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use LialBundle\Entity\FicheMissions;
use NoteBookBundle\Entity\CardPerson;

class LoadCardPersonData
       extends AbstractFixture 
       implements OrderedFixtureInterface	   
{    
	/**     
	* Number of persons to add
	*/   
	 const NUMBER_OF_PERSONS = 100;
	
	  /**
	  * Load data fixtures with the passed EntityManager
	  * @param ObjectManager $manager
      */  
		 public function load(ObjectManager $manager)    {	 
            $y=2;
			 for ($i = 0; $i <= self::NUMBER_OF_PERSONS; $i++)
			 {    
				$cardperson = new CardPerson();
                 $cardperson -> setName('nom'.$i);
                 $cardperson -> setFirstname('prenom'.$i);
                 $cardperson -> setComments('commentaires concernant la personne nom'.$i);
                 $cardperson -> setEmail('nom'.$i.'@gmail.com');
                 $cardperson -> setPhone('06172020'.$i.$i);
                 $cardperson -> setProfession('informaticien - code:'.$i.$i);

                 if($i%$y == 0 ){
                     $cardperson -> setStatus(true);
                 }else $cardperson -> setStatus(false);

                 $cardperson ->setCreatedAt(new \DateTime);

                 $cardperson->setNotebook($this->getReference('note-book'));
				    
                 $manager->persist($cardperson);
			}       
			$manager->flush();
		} 
		
		  /**
		  * Get the order of this fixture
		  * @return integer
		  */
		  public function getOrder()
		  {
			return 2;
		  }
}





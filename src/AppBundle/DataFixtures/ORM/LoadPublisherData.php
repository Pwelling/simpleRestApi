<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Publisher;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPublisherData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @return int
     */
    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 1;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $publisherNames = [
            'Harlekijn',
            'Kosmos',
            'Elastique',
            'Boekengilde',
            'Boekencentrum',
            'Meulenhoff',
            'Ailantus',
            'Aspekt',
        ];
        foreach ($publisherNames as $publisherName) {
            $publisher = new Publisher();
            $publisher->setName($publisherName);
            $manager->persist($publisher);
            $manager->flush($publisher);
            $this->addReference('publisher' . $publisher->getId(), $publisher);
        }
    }
}

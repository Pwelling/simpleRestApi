<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Author;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAuthorData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @return int
     */
    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 2;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $authorNames = [
            'Stephen King',
            'Jane Wolkers',
            'Sybren Polet',
            'Harry Mulish',
            'Isaac Asimov',
        ];
        foreach ($authorNames as $authorName) {
            $author = new Author();
            $author->setName($authorName);
            $manager->persist($author);
            $manager->flush($author);
            $this->addReference('author' . $author->getId(), $author);
        }
    }
}

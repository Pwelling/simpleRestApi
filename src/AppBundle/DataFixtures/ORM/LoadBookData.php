<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Book;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadBookData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @return int
     */
    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 3;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $book = new Book();
        $book
            ->setTitle('It')
            ->setAuthor($this->getReference('author1'))
            ->setPublisher($this->getReference('publisher1'));
        $manager->persist($book);
        $manager->flush($book);

        $book = new Book();
        $book
            ->setHighlighted(true)
            ->setTitle('De aanslag')
            ->setAuthor($this->getReference('author4'))
            ->setPublisher($this->getReference('publisher2'));
        $manager->persist($book);
        $manager->flush($book);

        $book = new Book();
        $book
            ->setTitle('Terug naar Oegstgeest')
            ->setAuthor($this->getReference('author2'))
            ->setPublisher($this->getReference('publisher3'));
        $manager->persist($book);
        $manager->flush($book);
    }
}

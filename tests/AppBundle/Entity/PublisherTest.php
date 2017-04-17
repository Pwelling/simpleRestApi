<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Entity\Publisher;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PublisherTest extends WebTestCase
{
    /**
     * @var Publisher
     */
    protected $object;

    /**
     *
     */
    protected function setUp()
    {
        parent::setUp();
        $this->object = new Publisher();
    }

    /**
     * @covers \AppBundle\Entity\Publisher::__construct
     * @covers \AppBundle\Entity\Publisher::getBooks
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(ArrayCollection::class, $this->object->getBooks());
    }

    /**
     * @covers \AppBundle\Entity\Publisher::getId
     */
    public function testGetId()
    {
        $this->assertNull($this->object->getId());

        $property = new \ReflectionProperty(Publisher::class, 'id');
        $property->setAccessible(true);
        $property->setValue($this->object, 1);
        $this->assertSame(1, $this->object->getId());
    }

    /**
     * @covers \AppBundle\Entity\Publisher::setName
     * @covers \AppBundle\Entity\Publisher::getName
     */
    public function testGetSetName()
    {
        $this->assertNull($this->object->getName());
        $name = 'Elastiqu';
        $this->assertSame($name, $this->object->setName($name)->getName());
    }

    /**
     * @covers \AppBundle\Entity\Publisher::addBook
     * @covers \AppBundle\Entity\Publisher::removeBook
     * @covers \AppBundle\Entity\Publisher::getBooks
     */
    public function testAddRemoveBook()
    {
        $book = new Book();

        $this->assertCount(0, $this->object->getBooks());

        $this->object->addBook($book);
        $this->assertCount(1, $this->object->getBooks());
        $this->assertSame($book, $this->object->getBooks()[0]);

        $this->object->removeBook($book);
        $this->assertCount(0, $this->object->getBooks());
    }
}

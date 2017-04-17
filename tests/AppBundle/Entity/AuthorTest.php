<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Author;
use AppBundle\Entity\Book;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthorTest extends WebTestCase
{
    /**
     * @var Author
     */
    protected $object;

    /**
     *
     */
    protected function setUp()
    {
        parent::setUp();
        $this->object = new Author();
    }

    /**
     * @covers \AppBundle\Entity\Author::__construct
     * @covers \AppBundle\Entity\Author::getBooks
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(ArrayCollection::class, $this->object->getBooks());
    }

    /**
     * @covers \AppBundle\Entity\Author::getId
     */
    public function testGetId()
    {
        $this->assertNull($this->object->getId());

        $property = new \ReflectionProperty(Author::class, 'id');
        $property->setAccessible(true);
        $property->setValue($this->object, 1);
        $this->assertSame(1, $this->object->getId());
    }

    /**
     * @covers \AppBundle\Entity\Author::setName
     * @covers \AppBundle\Entity\Author::getName
     */
    public function testGetSetName()
    {
        $this->assertNull($this->object->getName());
        $name = 'Stephen King';
        $this->assertSame($name, $this->object->setName($name)->getName());
    }

    /**
     * @covers \AppBundle\Entity\Author::addBook
     * @covers \AppBundle\Entity\Author::removeBook
     * @covers \AppBundle\Entity\Author::getBooks
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

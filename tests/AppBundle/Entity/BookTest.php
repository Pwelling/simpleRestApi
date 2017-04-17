<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Author;
use AppBundle\Entity\Book;
use AppBundle\Entity\Publisher;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookTest extends WebTestCase
{
    /**
     * @var Book
     */
    protected $object;

    /**
     *
     */
    protected function setUp()
    {
        parent::setUp();
        $this->object = new Book();
    }

    /**
     * @covers \AppBundle\Entity\Book::getId
     */
    public function testGetId()
    {
        $this->assertNull($this->object->getId());

        $property = new \ReflectionProperty(Book::class, 'id');
        $property->setAccessible(true);
        $property->setValue($this->object, 1);
        $this->assertSame(1, $this->object->getId());
    }

    /**
     * @covers \AppBundle\Entity\Book::getTitle
     * @covers \AppBundle\Entity\Book::setTitle
     */
    public function testGetSetTitle()
    {
        $this->assertNull($this->object->gettitle());
        $title = 'it';
        $this->assertSame($title, $this->object->setTitle($title)->getTitle());
    }

    /**
     * @covers \AppBundle\Entity\Book::getHighlighted
     * @covers \AppBundle\Entity\Book::setHighlighted
     */
    public function testGetSetHighlighted()
    {
        $this->assertNotTrue($this->object->getHighlighted());
        $this->assertTrue($this->object->setHighlighted(true)->getHighlighted());
    }

    /**
     * @covers \AppBundle\Entity\Book::getAuthor
     * @covers \AppBundle\Entity\Book::setAuthor
     */
    public function testGetSetAuthor()
    {
        $this->assertNull($this->object->getAuthor());
        $author = new Author();
        $this->assertSame($author, $this->object->setAuthor($author)->getAuthor());
    }

    /**
     * @covers \AppBundle\Entity\Book::getPublisher
     * @covers \AppBundle\Entity\Book::setPublisher
     */
    public function testGetSetPublisher()
    {
        $this->assertNull($this->object->getPublisher());
        $publisher = new Publisher();
        $this->assertSame($publisher, $this->object->setPublisher($publisher)->getPublisher());
    }
}

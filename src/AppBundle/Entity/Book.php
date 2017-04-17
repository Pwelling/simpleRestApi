<?php

namespace AppBundle\Entity;

class Book
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var boolean
     */
    private $highlighted = false;

    /**
     * @var Author
     */
    private $author;

    /**
     * @var Publisher
     */
    private $publisher;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     * @return Book
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param boolean $highlighted
     * @return Book
     */
    public function setHighlighted($highlighted)
    {
        $this->highlighted = $highlighted;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getHighlighted()
    {
        return $this->highlighted;
    }

    /**
     * @param Author $author
     * @return Book
     */
    public function setAuthor(Author $author = null)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param Publisher $publisher
     * @return Book
     */
    public function setPublisher(Publisher $publisher = null)
    {
        $this->publisher = $publisher;
        return $this;
    }

    /**
     * @return Publisher
     */
    public function getPublisher()
    {
        return $this->publisher;
    }
}

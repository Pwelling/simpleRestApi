<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use FOS\RestBundle\Controller\FOSRestController;
use /** @noinspection PhpUnusedAliasInspection */
    FOS\RestBundle\Controller\Annotations as Rest;

class BookController extends FOSRestController
{
    /**
     * @Rest\View
     * @return Book[]|array
     */
    public function highlightedAction()
    {
        $books = $this->getDoctrine()->getRepository('AppBundle:Book')->findBy(['highlighted' => true]);
        if (is_null($books) || count($books) ==0) {
            return ["No highlighted books"];
        }
        return $books;
    }

    /**
     * @Rest\View
     * @param $id
     * @return Book|array
     */
    public function getAction($id)
    {
        $book = $this->getDoctrine()->getRepository('AppBundle:Book')->find($id);
        if (is_null($book)) {
            return ["Book not found"];
        }
        return $book;
    }

    /**
     * @Rest\View
     * @param $title
     * @param null $limit
     * @param null $offset
     * @return Book[]|array
     */
    public function searchAction($title, $limit = null, $offset = null)
    {
        $books = $this->getDoctrine()->getRepository('AppBundle:Book')->findByKeyword($title, $limit, $offset);
        if (is_null($books) || count($books) == 0) {
            return ["No books found"];
        }
        return $books;
    }
}

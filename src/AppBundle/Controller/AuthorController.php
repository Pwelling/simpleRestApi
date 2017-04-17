<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use FOS\RestBundle\Controller\FOSRestController;
use /** @noinspection PhpUnusedAliasInspection */
    FOS\RestBundle\Controller\Annotations as Rest;

class AuthorController extends FOSRestController
{
    /**
     * @Rest\View
     * @param $id
     * @return Author|array
     */
    public function getAction($id)
    {
        $author = $this->getDoctrine()->getRepository('AppBundle:Author')->find($id);
        if (is_null($author)) {
            return ["Author not found"];
        }
        return $author;
    }

    /**
     * @Rest\View
     * @return Author[]|array
     */
    public function listAction()
    {
        $authors = $this->getDoctrine()->getRepository('AppBundle:Author')->findAll();
        return $authors;
    }
}

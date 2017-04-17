<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Publisher;
use FOS\RestBundle\Controller\FOSRestController;
use /** @noinspection PhpUnusedAliasInspection */
    FOS\RestBundle\Controller\Annotations as Rest;

class PublisherController extends FOSRestController
{
    /**
     * @Rest\View
     * @param $id
     * @return Publisher|array
     */
    public function getAction($id)
    {
        $Publisher = $this->getDoctrine()->getRepository('AppBundle:Publisher')->find($id);
        if (is_null($Publisher)) {
            return ["Publisher not found"];
        }
        return $Publisher;
    }

    /**
     * @Rest\View
     * @return Publisher[]|array
     */
    public function listAction()
    {
        $Publishers = $this->getDoctrine()->getRepository('AppBundle:Publisher')->findAll();
        return $Publishers;
    }
}

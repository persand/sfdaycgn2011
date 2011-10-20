<?php

namespace SymfonyDay\Bundle\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/blog", name="blog")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $posts = $em->getRepository('SymfonyDayBlogBundle:Post')->findAll();

        return array('posts' => $posts);
    }

    /**
     * @Route("/blog/{id}", name="post")
     * @Template()
     */
    public function postAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $post = $em->getRepository('SymfonyDayBlogBundle:Post')->find($id);

        return array('post' => $post);
    }
}

				
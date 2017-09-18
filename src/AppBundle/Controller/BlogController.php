<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Blog;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{

    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository(Blog::class)->findAll();

        return $this->render('index.html.twig', array('blogs' => $blog));
    }

    /**
     * @Route("/entry/{id}", name="entry_show")
     */
    public function showAction(Blog $blog)
    {
        return $this->render(':blog:show.html.twig', array('blog' => $blog));
    }
}

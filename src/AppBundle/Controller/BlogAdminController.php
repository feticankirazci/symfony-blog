<?php

namespace AppBundle\Controller;

use AppBundle\Form\BlogEntryFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class BlogAdminController extends Controller
{
    /**
     * @Route("/blog", name="admin_blog_list")
     */
    public function indexAction()
    {
        $blogs = $this->getDoctrine()
            ->getRepository('AppBundle:Blog')
            ->findAll();

        return $this->render('', array(
            'blogs' => $blogs
        ));
    }

    /**
     * @Route("/blog/new", name="admin_blog_new")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(BlogEntryFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $blog = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();

            return $this->redirectToRoute('admin_blog_new');
        }

        return $this->render(':admin/blog:new.html.twig', [
            'blogForm' => $form->createView()
        ]);
    }
}

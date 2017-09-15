<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Blog;
use AppBundle\Form\BlogEntryFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        return $this->render(':admin/blog:list.html.twig', array(
            'blogs' => $blogs
        ));
    }

    /**
     * @Route("/blog/new", name="admin_blog_new")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(BlogEntryFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $blog = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();

            $this->addFlash('success', 'Entry submitted.');

            return $this->redirectToRoute('admin_blog_list');
        }

        return $this->render(':admin/blog:new.html.twig', [
            'blogForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/blog/{id}/edit", name="admin_blog_edit")
     */
    public function editAction(Request $request, Blog $blog)
    {
        $form = $this->createForm(BlogEntryFormType::class, $blog);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $blog = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();

            $this->addFlash('success', 'Entry updated.');

            return $this->redirectToRoute('admin_blog_list');
        }

        return $this->render(':admin/blog:edit.html.twig', [
            'blogForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/deleteEntry/{id}", name="admin_blog_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, Blog $blog){
       $em = $this->getDoctrine()->getManager();
       $entryTitle = $blog->getTitle();
       try{
           $em->remove($blog);
           $em->flush();
           $response = [
               "success" => true,
               "message" => "'".$entryTitle."' titled entry has been successfully deleted."
           ];
       }catch (\Exception $exception){
           $response = [
               "success" => false,
               "error" => $exception->getMessage()
           ];
       }
       return JsonResponse::create($response);
    }
}

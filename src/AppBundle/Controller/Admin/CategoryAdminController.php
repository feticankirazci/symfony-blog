<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Category;
use AppBundle\Form\CategoryAddFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class CategoryAdminController extends Controller
{
    /**
     * @Route("/category", name="admin_category_list")
     */
    public function indexAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findAll();

        return $this->render(':admin/category:list.html.twig', array(
            'categories' => $categories
        ));
    }

    /**
     * @Route("/category/new", name="admin_category_new")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(CategoryAddFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $category = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'Category submitted.');

            return $this->redirectToRoute('admin_category_list');
        }

        return $this->render(':admin/category:new.html.twig', [
            'categoryForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/category/{id}/edit", name="admin_category_edit")
     */
    public function editAction(Request $request, Category $category)
    {
        $form = $this->createForm(CategoryAddFormType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $category = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'Category updated.');

            return $this->redirectToRoute('admin_category_list');
        }

        return $this->render(':admin/category:edit.html.twig', [
            'categoryForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/deleteCategory/{id}", name="admin_category_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, Category $category){
        $em = $this->getDoctrine()->getManager();
        $categoryName = $category->getName();
        try{
            $em->remove($category);
            $em->flush();
            $response = [
                "success" => true,
                "message" => "'".$categoryName."' named category has been successfully deleted."
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

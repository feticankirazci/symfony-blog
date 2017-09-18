<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{
    /**
     * @Route("/category/{id}", name="category_show")
     */
    public function indexAction(Category $category)
    {

        return $this->render('category/show.html.twig', array('category' => $category));
    }
}

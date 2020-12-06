<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Program;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categories", name="category_")
     */
    public function index(): Response
    {
    /**
     * @Route("/", name="index")
     */
        $categories = $this->getDoctrine()
        ->getRepository(Category::class)
        ->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
    * Getting a program by category
    *
    * @Route("/{categoryName}", name="show")
    * @return Response
    */
    public function show(string $categoryName): Response
    {
        $category = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findOneBy(['name' => $categoryName]);

        $programs = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findBy(['category' => $category], 
                ['id' => 'DESC'],
                3
        );
        
        if (!$category) {
            throw $this->createNotFoundException(
                'No program with id : '.$categoryName.' found in program\'s table.'
            );
        }

        return $this->render('category/show.html.twig', [
            'programs' => $programs,
    ]);
    }
}

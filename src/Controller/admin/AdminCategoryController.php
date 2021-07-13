<?php


namespace App\Controller\admin;


use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
/**
* @Route("/admin/category", name="admin_categoryList")
*/
    public function categoryList(CategoryRepository $categoryRepository): Response //l'autowire
    {
        $category = $categoryRepository->findAll();
        return $this->render('admin/admin_categorie_list.html.twig', [
            'category' => $category
        ]);

    }

/**
* @Route("/admin/category/{id}", name="admin_categoryShow")
*/
    public function categoryShow($id, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find($id);

        //Si le tag n'existe pas => renvoie une error exception en affichant erreur 404
        if (is_null($category)) {
            throw new NotFoundHttpException();
        };

        return $this->render('admin/admin_categorie_show.html.twig', [
            'category' => $category
        ]);

    }
}
<?php

namespace App\Controller;

use App\Form\ArticleFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article/new")
     */
    public function new(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(ArticleFormType::class);

        $form->handleRequest($form);
        if($form->isSubmitted()){

        }

        return $this->render('article_admin/new.html.twig', [
            'articleForm' => $form->createView()
        ]);
    }
}
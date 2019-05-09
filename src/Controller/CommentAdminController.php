<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class CommentAdminController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="comment_admin")
     */
    public function index(CommentRepository $commentRepo, Request $request, PaginatorInterface $paginator)
    {
        $commentQueryBuilder = $commentRepo->getSearchQueryBuilder($request->query->get('q'));

        $pagination = $paginator->paginate($commentQueryBuilder, $request->query->getInt('page', 1), 10);

        return $this->render('comment_admin/index.html.twig', compact('pagination'));
    }


}

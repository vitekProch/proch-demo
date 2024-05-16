<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class BlogPageController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/blog', name: 'blog_page')]
    public function blogPage(): Response
    {
        return $this->render('BlogPage/blog_page.html.twig', [
            'title' => 'Články',
        ]);
    }
}

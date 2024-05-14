<?php

namespace App\Controller;

use App\Repository\PhotoCategoriesRepository;
use App\Repository\PortfolioPhotosRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class PortfolioPageController extends AbstractController
{
    #[Route('/portfolio/{slug}', name: "portfolio_page")]
    public function portfolio(PhotoCategoriesRepository $photoCategoryRepository,Request $request, PortfolioPhotosRepository $portfolioPhotosRepository, string $slug = null): Response
    {

        $categories = $photoCategoryRepository->findAll();
        $queryBuilder = $portfolioPhotosRepository->createQueryBuilderForPhotosBySlug($slug);
        $adapter = new QueryAdapter($queryBuilder);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->get('page', 1),
            9
        );
        return $this->render('PortfolioPage/portfolio_page.html.twig', [
            'slug' => $slug,
            'categories' => $categories,
            'portfolioPhoto' => $pagerfanta,
        ]);
    }
}

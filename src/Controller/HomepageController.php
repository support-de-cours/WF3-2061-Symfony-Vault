<?php

namespace App\Controller;

use App\Service\DeviceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(DeviceService $deviceService): Response
    {
        dump(
            $deviceService->getUserAgent(),
            $deviceService->getClient(),
            $deviceService->getOs(),
            $deviceService->getDevice(),
            $deviceService->getLocales(),
        );

        return $this->render('homepage/index.html.twig', [
        ]);
    }
}

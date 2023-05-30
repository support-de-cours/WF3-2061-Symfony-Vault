<?php

namespace App\Controller;

use App\Entity\Precious;
use App\Form\PreciousType;
use App\Repository\PreciousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/precious')]
class PreciousController extends AbstractController
{
    #[Route('/', name: 'app_precious_index', methods: ['GET'])]
    public function index(PreciousRepository $preciousRepository): Response
    {
        return $this->render('precious/index.html.twig', [
            'preciouses' => $preciousRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_precious_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PreciousRepository $preciousRepository): Response
    {
        $preciou = new Precious();
        $form = $this->createForm(PreciousType::class, $preciou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $preciousRepository->save($preciou, true);

            return $this->redirectToRoute('app_precious_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('precious/new.html.twig', [
            'preciou' => $preciou,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_precious_show', methods: ['GET'])]
    public function show(Precious $preciou): Response
    {
        return $this->render('precious/show.html.twig', [
            'preciou' => $preciou,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_precious_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Precious $preciou, PreciousRepository $preciousRepository): Response
    {
        $form = $this->createForm(PreciousType::class, $preciou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $preciousRepository->save($preciou, true);

            return $this->redirectToRoute('app_precious_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('precious/edit.html.twig', [
            'preciou' => $preciou,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_precious_delete', methods: ['POST'])]
    public function delete(Request $request, Precious $preciou, PreciousRepository $preciousRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$preciou->getId(), $request->request->get('_token'))) {
            $preciousRepository->remove($preciou, true);
        }

        return $this->redirectToRoute('app_precious_index', [], Response::HTTP_SEE_OTHER);
    }
}

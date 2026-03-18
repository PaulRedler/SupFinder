<?php

namespace App\Controller;

use App\Entity\DomaineFormation;
use App\Form\DomaineFormationType;
use App\Repository\DomaineFormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/domaine/formation')]
final class DomaineFormationController extends AbstractController
{
    #[Route(name: 'app_domaine_formation_index', methods: ['GET'])]
    public function index(DomaineFormationRepository $domaineFormationRepository): Response
    {
        return $this->render('domaine_formation/index.html.twig', [
            'domaine_formations' => $domaineFormationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_domaine_formation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $domaineFormation = new DomaineFormation();
        $form = $this->createForm(DomaineFormationType::class, $domaineFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($domaineFormation);
            $entityManager->flush();

            return $this->redirectToRoute('app_domaine_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('domaine_formation/new.html.twig', [
            'domaine_formation' => $domaineFormation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_domaine_formation_show', methods: ['GET'])]
    public function show(DomaineFormation $domaineFormation): Response
    {
        return $this->render('domaine_formation/show.html.twig', [
            'domaine_formation' => $domaineFormation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_domaine_formation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DomaineFormation $domaineFormation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DomaineFormationType::class, $domaineFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_domaine_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('domaine_formation/edit.html.twig', [
            'domaine_formation' => $domaineFormation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_domaine_formation_delete', methods: ['POST'])]
    public function delete(Request $request, DomaineFormation $domaineFormation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$domaineFormation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($domaineFormation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_domaine_formation_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;

use App\Entity\Accreditation;
use App\Form\AccreditationType;
use App\Repository\AccreditationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/accreditation')]
final class AccreditationController extends AbstractController
{
    #[Route(name: 'app_accreditation_index', methods: ['GET'])]
    public function index(AccreditationRepository $accreditationRepository): Response
    {
        return $this->render('accreditation/index.html.twig', [
            'accreditations' => $accreditationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_accreditation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $accreditation = new Accreditation();
        $form = $this->createForm(AccreditationType::class, $accreditation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($accreditation);
            $entityManager->flush();

            return $this->redirectToRoute('app_accreditation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('accreditation/new.html.twig', [
            'accreditation' => $accreditation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_accreditation_show', methods: ['GET'])]
    public function show(Accreditation $accreditation): Response
    {
        return $this->render('accreditation/show.html.twig', [
            'accreditation' => $accreditation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_accreditation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Accreditation $accreditation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AccreditationType::class, $accreditation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_accreditation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('accreditation/edit.html.twig', [
            'accreditation' => $accreditation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_accreditation_delete', methods: ['POST'])]
    public function delete(Request $request, Accreditation $accreditation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$accreditation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($accreditation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_accreditation_index', [], Response::HTTP_SEE_OTHER);
    }
}

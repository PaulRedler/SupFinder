<?php

namespace App\Controller;

use App\Entity\EcoleAccreditation;
use App\Form\EcoleAccreditationType;
use App\Repository\EcoleAccreditationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ecole/accreditation')]
final class EcoleAccreditationController extends AbstractController
{
    #[Route(name: 'app_ecole_accreditation_index', methods: ['GET'])]
    public function index(EcoleAccreditationRepository $ecoleAccreditationRepository): Response
    {
        return $this->render('ecole_accreditation/index.html.twig', [
            'ecole_accreditations' => $ecoleAccreditationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ecole_accreditation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ecoleAccreditation = new EcoleAccreditation();
        $form = $this->createForm(EcoleAccreditationType::class, $ecoleAccreditation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ecoleAccreditation);
            $entityManager->flush();

            return $this->redirectToRoute('app_ecole_accreditation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ecole_accreditation/new.html.twig', [
            'ecole_accreditation' => $ecoleAccreditation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ecole_accreditation_show', methods: ['GET'])]
    public function show(EcoleAccreditation $ecoleAccreditation): Response
    {
        return $this->render('ecole_accreditation/show.html.twig', [
            'ecole_accreditation' => $ecoleAccreditation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ecole_accreditation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EcoleAccreditation $ecoleAccreditation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EcoleAccreditationType::class, $ecoleAccreditation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ecole_accreditation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ecole_accreditation/edit.html.twig', [
            'ecole_accreditation' => $ecoleAccreditation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ecole_accreditation_delete', methods: ['POST'])]
    public function delete(Request $request, EcoleAccreditation $ecoleAccreditation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ecoleAccreditation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ecoleAccreditation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ecole_accreditation_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;

use App\Entity\TypeEcole;
use App\Form\TypeEcoleType;
use App\Repository\TypeEcoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/type/ecole')]
final class TypeEcoleController extends AbstractController
{
    #[Route(name: 'app_type_ecole_index', methods: ['GET'])]
    public function index(TypeEcoleRepository $typeEcoleRepository): Response
    {
        return $this->render('type_ecole/index.html.twig', [
            'type_ecoles' => $typeEcoleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_ecole_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeEcole = new TypeEcole();
        $form = $this->createForm(TypeEcoleType::class, $typeEcole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeEcole);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_ecole_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_ecole/new.html.twig', [
            'type_ecole' => $typeEcole,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_ecole_show', methods: ['GET'])]
    public function show(TypeEcole $typeEcole): Response
    {
        return $this->render('type_ecole/show.html.twig', [
            'type_ecole' => $typeEcole,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_ecole_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeEcole $typeEcole, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeEcoleType::class, $typeEcole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_ecole_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_ecole/edit.html.twig', [
            'type_ecole' => $typeEcole,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_ecole_delete', methods: ['POST'])]
    public function delete(Request $request, TypeEcole $typeEcole, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeEcole->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($typeEcole);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_ecole_index', [], Response::HTTP_SEE_OTHER);
    }
}

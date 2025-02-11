<?php

namespace App\Controller;

use App\Entity\AnimalBreed;
use App\Form\AnimalBreedType;
use App\Repository\AnimalBreedRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/animal/breed')]
final class AnimalBreedController extends AbstractController
{
    #[Route(name: 'app_animal_breed_index', methods: ['GET'])]
    public function index(AnimalBreedRepository $animalBreedRepository): Response
    {
        return $this->render('animal_breed/index.html.twig', [
            'animal_breeds' => $animalBreedRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_animal_breed_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $animalBreed = new AnimalBreed();
        $form = $this->createForm(AnimalBreedType::class, $animalBreed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($animalBreed);
            $entityManager->flush();

            return $this->redirectToRoute('app_animal_breed_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('animal_breed/new.html.twig', [
            'animal_breed' => $animalBreed,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_animal_breed_show', methods: ['GET'])]
    public function show(AnimalBreed $animalBreed): Response
    {
        return $this->render('animal_breed/show.html.twig', [
            'animal_breed' => $animalBreed,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_animal_breed_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AnimalBreed $animalBreed, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnimalBreedType::class, $animalBreed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_animal_breed_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('animal_breed/edit.html.twig', [
            'animal_breed' => $animalBreed,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_animal_breed_delete', methods: ['POST'])]
    public function delete(Request $request, AnimalBreed $animalBreed, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$animalBreed->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($animalBreed);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_animal_breed_index', [], Response::HTTP_SEE_OTHER);
    }
}

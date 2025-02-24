<?php

namespace App\Controller;

use App\Entity\ImageAnimal;
use App\Form\ImageAnimalType;
use App\Repository\ImageAnimalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/image/animal')]
final class ImageAnimalController extends AbstractController
{
    #[Route(name: 'app_image_animal_index', methods: ['GET'])]
    public function index(ImageAnimalRepository $imageAnimalRepository): Response
    {
        return $this->render('image_animal/index.html.twig', [
            'image_animals' => $imageAnimalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_image_animal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $imageAnimal = new ImageAnimal();
        $form = $this->createForm(ImageAnimalType::class, $imageAnimal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($imageAnimal);
            $entityManager->flush();

            return $this->redirectToRoute('app_image_animal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('image_animal/new.html.twig', [
            'image_animal' => $imageAnimal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_image_animal_show', methods: ['GET'])]
    public function show(ImageAnimal $imageAnimal): Response
    {
        return $this->render('image_animal/show.html.twig', [
            'image_animal' => $imageAnimal,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_image_animal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ImageAnimal $imageAnimal, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ImageAnimalType::class, $imageAnimal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_image_animal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('image_animal/edit.html.twig', [
            'image_animal' => $imageAnimal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_image_animal_delete', methods: ['POST'])]
    public function delete(Request $request, ImageAnimal $imageAnimal, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imageAnimal->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($imageAnimal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_image_animal_index', [], Response::HTTP_SEE_OTHER);
    }
}

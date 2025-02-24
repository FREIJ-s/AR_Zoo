<?php

namespace App\Controller;

use App\Entity\InfoAnimal;
use App\Form\InfoAnimalType;
use App\Repository\InfoAnimalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/info/animal')]
final class InfoAnimalController extends AbstractController
{
    #[Route(name: 'app_info_animal_index', methods: ['GET'])]
    public function index(InfoAnimalRepository $infoAnimalRepository): Response
    {
        return $this->render('info_animal/index.html.twig', [
            'info_animals' => $infoAnimalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_info_animal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $infoAnimal = new InfoAnimal();
        $form = $this->createForm(InfoAnimalType::class, $infoAnimal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($infoAnimal);
            $entityManager->flush();

            return $this->redirectToRoute('app_info_animal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('info_animal/new.html.twig', [
            'info_animal' => $infoAnimal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_info_animal_show', methods: ['GET'])]
    public function show(InfoAnimal $infoAnimal): Response
    {
        return $this->render('info_animal/show.html.twig', [
            'info_animal' => $infoAnimal,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_info_animal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, InfoAnimal $infoAnimal, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InfoAnimalType::class, $infoAnimal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_info_animal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('info_animal/edit.html.twig', [
            'info_animal' => $infoAnimal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_info_animal_delete', methods: ['POST'])]
    public function delete(Request $request, InfoAnimal $infoAnimal, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$infoAnimal->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($infoAnimal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_info_animal_index', [], Response::HTTP_SEE_OTHER);
    }
}

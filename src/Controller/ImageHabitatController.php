<?php

namespace App\Controller;

use App\Entity\ImageHabitat;
use App\Form\ImageHabitatType;
use App\Repository\ImageHabitatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/image/habitat')]
final class ImageHabitatController extends AbstractController
{
    #[Route(name: 'app_image_habitat_index', methods: ['GET'])]
    public function index(ImageHabitatRepository $imageHabitatRepository): Response
    {
        return $this->render('image_habitat/index.html.twig', [
            'image_habitats' => $imageHabitatRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_image_habitat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $imageHabitat = new ImageHabitat();
        $form = $this->createForm(ImageHabitatType::class, $imageHabitat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($imageHabitat);
            $entityManager->flush();

            return $this->redirectToRoute('app_image_habitat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('image_habitat/new.html.twig', [
            'image_habitat' => $imageHabitat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_image_habitat_show', methods: ['GET'])]
    public function show(ImageHabitat $imageHabitat): Response
    {
        return $this->render('image_habitat/show.html.twig', [
            'image_habitat' => $imageHabitat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_image_habitat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ImageHabitat $imageHabitat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ImageHabitatType::class, $imageHabitat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_image_habitat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('image_habitat/edit.html.twig', [
            'image_habitat' => $imageHabitat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_image_habitat_delete', methods: ['POST'])]
    public function delete(Request $request, ImageHabitat $imageHabitat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imageHabitat->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($imageHabitat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_image_habitat_index', [], Response::HTTP_SEE_OTHER);
    }
}

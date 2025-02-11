<?php

namespace App\Controller;

use App\Entity\Access;
use App\Form\AccessType;
use App\Repository\AccessRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/access')]
final class AccessController extends AbstractController
{
    #[Route(name: 'app_access_index', methods: ['GET'])]
    public function index(AccessRepository $accessRepository): Response
    {
        return $this->render('access/index.html.twig', [
            'accesses' => $accessRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_access_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $access = new Access();
        $form = $this->createForm(AccessType::class, $access);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($access);
            $entityManager->flush();

            return $this->redirectToRoute('app_access_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('access/new.html.twig', [
            'access' => $access,
            'form' => $form,
        ]);
    }

    #[Route('/{employee}', name: 'app_access_show', methods: ['GET'])]
    public function show(Access $access): Response
    {
        return $this->render('access/show.html.twig', [
            'access' => $access,
        ]);
    }

    #[Route('/{employee}/edit', name: 'app_access_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Access $access, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AccessType::class, $access);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_access_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('access/edit.html.twig', [
            'access' => $access,
            'form' => $form,
        ]);
    }

    #[Route('/{employee}', name: 'app_access_delete', methods: ['POST'])]
    public function delete(Request $request, Access $access, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$access->getEmployee(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($access);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_access_index', [], Response::HTTP_SEE_OTHER);
    }
}

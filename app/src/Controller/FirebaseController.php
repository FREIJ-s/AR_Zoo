<?php

namespace App\Controller;

use App\Service\FirebaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ReserverType;
use App\Form\SignalementType;
use App\Form\AvisType;

class FirebaseController extends AbstractController
{
    private FirebaseService $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    #[Route('/reserver', name: 'app_reserver')]
    public function reserver(Request $request): Response
    {
        $form = $this->createForm(ReserverType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->firebaseService->addData('reservations', $data);
            return $this->redirectToRoute('app_home');
        }

        return $this->render('firebase/reserver.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/signaler-animal', name: 'app_signaler_animal')]
    public function signalerAnimal(Request $request): Response
    {
        $form = $this->createForm(SignalementType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->firebaseService->addData('signalements', $data);
            return $this->redirectToRoute('app_home');
        }

        return $this->render('firebase/signaler_animal.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/ajouter-avis', name: 'app_ajouter_avis')]
    public function ajouterAvis(Request $request): Response
    {
        $form = $this->createForm(AvisType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $data['date'] = date('Y-m-d H:i:s'); // Ajout de la date actuelle
            $this->firebaseService->addData('avis', $data);
            return $this->redirectToRoute('app_home');
        }

        return $this->render('firebase/ajouter_avis.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/avis', name: 'app_avis_list')]
    public function afficherAvis(): Response
    {
        $avisList = $this->firebaseService->getData('avis');

        return $this->render('firebase/avis.html.twig', [
            'avisList' => $avisList,
        ]);
    }
}

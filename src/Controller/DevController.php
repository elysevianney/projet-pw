<?php

namespace App\Controller;

use App\Entity\Dev;
use App\Entity\User;
use App\Form\DevType;
use App\Repository\DevRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/dev')]
final class DevController extends AbstractController
{
    #[Route(name: 'app_dev_index', methods: ['GET'])]
    public function index(DevRepository $devRepository): Response
    {
        return $this->render('dev/index.html.twig', [
            'devs' => $devRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_dev_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dev = new Dev();
        $form = $this->createForm(DevType::class, $dev);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dev);
            $entityManager->flush();

            return $this->redirectToRoute('app_dev_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dev/new.html.twig', [
            'dev' => $dev,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dev_show', methods: ['GET'])]
    public function show(Dev $dev): Response
    {
        return $this->render('dev/show.html.twig', [
            'dev' => $dev,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_dev_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dev $dev, EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();
        if (!$user instanceof User) {
            throw new \LogicException('L\'utilisateur connecté n\'est pas de type User.');
        }

        
        $devID = $user->getDev()->getId();

        if ($devID == $dev->getId()) {
            $form = $this->createForm(DevType::class, $dev);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                return $this->redirectToRoute('app_dev_edit', ['id' =>$devID ], Response::HTTP_SEE_OTHER);
            }
           
            return $this->render('dev/edit.html.twig', [
                'dev' => $dev,
                'form' => $form,
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
        
        
    }

    #[Route('/{id}', name: 'app_dev_delete', methods: ['POST'])]
    public function delete(Request $request, Dev $dev, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dev->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($dev);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dev_index', [], Response::HTTP_SEE_OTHER);
    }
}

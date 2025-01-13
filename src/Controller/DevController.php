<?php

namespace App\Controller;

use App\Entity\Dev;
use App\Entity\User;
use App\Form\DevType;
use App\Entity\ProfileView;
use App\Form\DevSearchType;
use App\Repository\DevRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
    public function show(Dev $dev, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if ($user) {
            if (!$user instanceof User) {
                throw new \LogicException('L\'utilisateur connecté n\'est pas de type User.');
            }

            $profileOwner = $dev->getUser();
            $viewer = $user;
            // Vérifier si le viewer a déjà vu ce profil
            $existingView = $entityManager->getRepository(ProfileView::class)->findOneBy([
                'profileOwner' => $profileOwner,
                'viewer' => $viewer,
            ]);

            if (!$existingView) {
                // Enregistrer une nouvelle vue
                $profileView = new ProfileView($profileOwner, $viewer);
                $entityManager->persist($profileView);

                // Incrémenter le compteur de vues uniques
                $count = $dev->getCountView();
                $dev->setCountView($count+1);
                $entityManager->persist($dev);
                $entityManager->flush();

                $entityManager->persist($profileOwner);
            }

            $entityManager->flush();
        }
        return $this->render('dev/show.html.twig', [
            'dev' => $dev,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_dev_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dev $dev, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
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
                //gestion de la photo de profil 
                $avatarFile = $form->get('avatar')->getData();

                if ($avatarFile) {
                    $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$avatarFile->guessExtension();

                    try {
                        $avatarFile->move(
                            $this->getParameter('avatars_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // Gérer l'erreur
                    }

                    $dev->setAvatar($newFilename);
                }

                $entityManager->flush();

                return $this->redirectToRoute('app_dev_show', ['id' =>$devID ], Response::HTTP_SEE_OTHER);
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

    #[Route('/dev/save-rating', name: 'app_dev_save_rating', methods: ['POST'])]
    public function saveRating(Request $request, EntityManagerInterface $entityManager, DevRepository $devRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw new \LogicException('L\'utilisateur connecté n\'est pas de type User.');
        }
        $devId = $request->request->get('devId');
        $dev = $devRepository->findOneBy(['id' => $devId]); // Exemple d'accès à l'entité De
        //dd($dev);
        // Récupère la note depuis la requête
        $rating = $request->request->get('rating');

        if ($rating !== null) {
            $dev->setRating((float) (($rating + $dev->getTotalRating()*$dev->getRating())/  ($dev->getTotalRating()+1))); // Met à jour la note
            $dev->setTotalRating($dev->getTotalRating()+1);
            $entityManager->persist($dev);
            $entityManager->flush();

            $this->addFlash('success', 'Note enregistrée avec succès !');
        } else {
            $this->addFlash('error', 'Aucune note sélectionnée.');
        }

        return $this->redirectToRoute('app_dev_show', ['id'=>$devId]); // Redirection après sauvegarde
    }

    #[Route('/dev/{id}/favoris', name: 'app_dev_favoris', methods: ['GET'])]
    public function favoritePosts(Dev $dev): Response {

        return $this->render('post/index3.html.twig', [
            'posts' => $dev->getFavoritePosts(),
        ]);
    }


    #[Route('/dev/{id}/favorite', name: 'dev_toggle_favorite', methods: ['POST'])]
    public function toggleFavoriteDev(Dev $dev, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if ($user) {
            if (!$user instanceof User) {
                throw new \LogicException('L\'utilisateur connecté n\'est pas de type User.');
            }
        }
        /** @var Company $company */
        $company = $user->getCompany(); // Supposons que l'utilisateur connecté est une Company

        if ($company->getFavoriteDevs()->contains($dev)) {
            // Si le dev est déjà dans les favoris, le retirer
            $company->removeFavoriteDev($dev);
        } else {
            // Ajouter le dev aux favoris
            $company->addFavoriteDev($dev);
        }

        $entityManager->persist($company);
        $entityManager->flush();

        return $this->redirectToRoute('app_dev_show', ['id' => $dev->getId()]); // Redirige vers la liste des devs ou une autre page
    }

    
}

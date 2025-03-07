<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use App\Entity\PostView;
use App\Form\PostSearchType;
use App\Repository\PostRepository;
use App\Repository\PostViewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/post')]
final class PostController extends AbstractController
{
    #[Route(name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw new \LogicException('L\'utilisateur connecté n\'est pas de type User.');
        }

        $company = $user->getCompany();
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        $post->setUser($user);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_post_show', ['id' => $post->getId()]);
        }

        return $this->render('post/new.html.twig', [
            'company'=> $company,
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_show', methods: ['GET'])]
    public function show(Post $post, EntityManagerInterface $entityManager, PostViewRepository $postViewRepository): Response
    {
        $user = $this->getUser();

        if ($user) {
            if (!$user instanceof User) {
                throw new \LogicException('L\'utilisateur connecté n\'est pas de type User.');
            }
    
            // Vérifier si l'utilisateur a déjà vu ce post
            $existingView = $postViewRepository->findOneBy([
                'post' => $post,
                'viewer' => $user,
            ]);
            //dd($existingView);
    
            if (!$existingView and $user != $post->getUser()) {
                // Ajouter une nouvelle vue
                $postView = new PostView($post, $user);
                $entityManager->persist($postView);
    
                // Incrémenter le compteur de vues uniques
                $post->incrementUniqueViews();
                $entityManager->persist($post);
            }
    
            $entityManager->flush();
        }
        
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_post_show', ['id' => $post->getId()]);
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/post/{id}/favorite', name: 'post_toggle_favorite', methods: ['POST'])]
    public function toggleFavorite(Post $post, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if ($user) {
            if (!$user instanceof User) {
                throw new \LogicException('L\'utilisateur connecté n\'est pas de type User.');
            }
        }
        /** @var Dev $dev */
        $dev = $user->getDev(); // Supposons que l'utilisateur connecté est un Dev

        if ($dev->getFavoritePosts()->contains($post)) {
            // Si le post est déjà dans les favoris, le retirer
            $dev->removeFavoritePost($post);
        } else {
            // Ajouter le post aux favoris
            $dev->addFavoritePost($post);
        }

        $entityManager->persist($dev);
        $entityManager->flush();

        return $this->redirectToRoute('app_post_show', ['id' => $post->getId()]); // Redirige vers la liste des posts ou autre route
    }

    


}

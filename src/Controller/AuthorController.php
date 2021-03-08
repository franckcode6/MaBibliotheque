<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/author")
 */
class AuthorController extends AbstractController
{
    /**
     * @Route("/", name="author_index")
     */
    public function index(AuthorRepository $authorRepository): Response
    {
        $authors = $authorRepository->findAll();
        return $this->render('author/index.html.twig', [
            'authors' => $authors]);
    }

    /**
     * @Route("/new", name="author_new")
     * @Route("/{id}/edit", name="author_edit")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param Author|Null
     */
    public function new(Request $request, EntityManagerInterface $entityManager, Author $author = null): Response
    {
        if (empty($author)) {
            $author = new Author();
        }

        $form = $this->createForm(AuthorType::class, $author, [
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('author_index');
        }

        return $this->render('author/new.html.twig', [
            'formAuthor' => $form->createView(),
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/book")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/", name="book_index")
     */
    public function index(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        return $this->render('book/index.html.twig', [
            'books' => $books]);
    }

    /**
     * @Route("/new", name="book_new")
     * @Route("/{id}/edit", name="book_edit")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param Book|Null
     */
    public function new(Request $request, EntityManagerInterface $entityManager, Book $book = null): Response
    {
        if (empty($book)) {
            $book = new Book();
        }

        $form = $this->createForm(BookType::class, $book, [
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/new.html.twig', [
            'formBook' => $form->createView(),
        ]);
    }

    /**
     * @Route("/search/{title}", name="book_search")
     *
     * @param string $title
     * @param BookRepository $bookRepository
     *
     * @return Response
     */
    public function searchByName(string $title, BookRepository $bookRepository) : Response
    {
        $results = $bookRepository->searchInName($title);
        dd($results);
    }
}

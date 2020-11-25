<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BooksController extends AbstractController
{
    /**
     * @Route("/", name="display")
     */
    public function display(): Response
    {
        $book = $this->getDoctrine()
            ->getRepository( Book::class )
            ->findAll();

        return $this->render( 'books/display.html.twig', [ 'data' => $book ] );
    }

    /**
     * @Route("/books/new", name="new")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function new( Request $request ): Response
    {
        $book = new Book();
        $form = $this->createForm( BookFormType::class, $book);
        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() ) {
            $book = $form->getData();
            $doct = $this->getDoctrine()->getManager();
            $doct->persist( $book );
            $doct->flush();

            return $this->redirectToRoute( 'display' );
        } else {

            return $this->render( 'books/new.html.twig', array(
                'form' => $form->createView(),
            ) );
        }
    }

    /**
     * @Route("/books/update/{id}", name = "update" )
     * @param $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function update( int $id, Request $request ): Response
    {
        $doct = $this->getDoctrine()->getManager();
        $book = $doct->getRepository( Book::class )->find( $id );

        if ( !$book ) {
            throw $this->createNotFoundException(
                'No book found for id ' . $id
            );
        }

        $form = $this->createForm( BookFormType::class, $book);
        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() ) {
            $book = $form->getData();
            $doct = $this->getDoctrine()->getManager();
            $doct->persist( $book );
            $doct->flush();

            return $this->redirectToRoute( 'display' );
        } else {

            return $this->render( 'books/new.html.twig', array(
                'form' => $form->createView(),
            ) );
        }
    }

    /**
     * @Route("/books/delete/{id}", name="delete")
     * @param int $id
     * @return RedirectResponse
     */
    public function delete( int $id ): RedirectResponse
    {
        $doct = $this->getDoctrine()->getManager();
        $book = $doct->getRepository( Book::class )->find( $id );

        if ( !$book ) {
            throw $this->createNotFoundException( 'No book found for id ' . $id );
        }
        $doct->remove( $book );
        $doct->flush();

        return $this->redirectToRoute( 'display' );
    }
}

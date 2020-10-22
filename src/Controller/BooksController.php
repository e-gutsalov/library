<?php

namespace App\Controller;

use App\Entity\Book;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Reference;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BooksController extends AbstractController
{
    /**
     * @Route("/", name="display")
     */
    public function display(): object
    {
        $bk = $this->getDoctrine()
            ->getRepository( 'App:Book' )
            ->findAll();
        return $this->render( 'books/display.html.twig', [ 'data' => $bk ] );
    }

    /**
     * @Route("/books/new", name="new")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function new(Request $request): object
    {
        $book = new Book();
        $form = $this->createFormBuilder($book)
            ->add('name', TextType::class)
            ->add('year', TextType::class)
            ->add('author', TextType::class)
            ->add('description', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Submit'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $doct = $this->getDoctrine()->getManager();
            $doct->persist($book);
            $doct->flush();

            return $this->redirectToRoute('display');
        } else {
            return $this->render('books/new.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

    /**
     * @Route("/books/update/{id}", name = "update" )
     * @param $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function update(int $id, Request $request): object
    {
        $doct = $this->getDoctrine()->getManager();
        $bk = $doct->getRepository('App:Book')->find($id);

        if (!$bk) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }
        $form = $this->createFormBuilder($bk)
            ->add('name', TextType::class)
            ->add('year', TextType::class)
            ->add('author', TextType::class)
            ->add('description', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Submit'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $doct = $this->getDoctrine()->getManager();
            $doct->persist($book);
            $doct->flush();
            return $this->redirectToRoute('display');
        } else {
            return $this->render('books/new.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

    /**
     * @Route("/books/delete/{id}", name="delete")
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): object
    {
        $doct = $this->getDoctrine()->getManager();
        $bk = $doct->getRepository('App:Book')->find($id);

        if (!$bk) {
            throw $this->createNotFoundException('No book found for id '.$id);
        }
        $doct->remove($bk);
        $doct->flush();
        return $this->redirectToRoute('display');
    }
}

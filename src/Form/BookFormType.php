<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookFormType extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add( 'name', TextType::class )
            ->add( 'year', TextType::class )
            ->add( 'author', TextType::class )
            ->add( 'description', TextType::class )
            ->add( 'save', SubmitType::class, array( 'label' => 'Submit' ) )
            ->getForm();
    }

    public function configureOptions( OptionsResolver $resolver )
    {
        $resolver->setDefaults( [
            'data_class' => Book::class,
        ] );
    }
}

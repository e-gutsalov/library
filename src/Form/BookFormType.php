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
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
        $builder
            ->add( 'name', TextType::class )
            ->add( 'year', TextType::class )
            ->add( 'author', TextType::class )
            ->add( 'description', TextType::class )
            ->add( 'save', SubmitType::class, array( 'label' => 'Submit' ) )
            ->getForm();
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions( OptionsResolver $resolver ): void
    {
        $resolver->setDefaults( [
            'data_class' => Book::class,
        ] );
    }
}

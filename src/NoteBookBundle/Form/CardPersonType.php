<?php

namespace NoteBookBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CardPersonType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => "Nom :"))
            ->add('firstname', TextType::class, array('label' => "Prénom :"))
            ->add('phone', TelType::class, array('label' => "Téléphone :"))
            ->add('email', EmailType::class , array('label' => "Email :"))
            ->add('profession', TextType::class, array('label' => "Profession :"))
            ->add('status', ChoiceType::class, [
                'choices' => ['Oui' => true, 'Non' => false],
                'placeholder' => 'Retraité : '
            ])
            ->add('comments', TextType::class, array('label' => "Commentaires :"))
            ->add('notebook', EntityType::class, array(
                'class' => 'NoteBookBundle:NoteBook',
                'expanded' => false,
                'multiple' => false,
                'choice_label' => 'name',
                'label' => "Choisissez le carnet à lier "
            ))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NoteBookBundle\Entity\CardPerson'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'notebookbundle_cardperson';
    }


}

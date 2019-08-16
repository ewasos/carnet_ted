<?php

namespace NoteBookBundle\Service;

use Doctrine\ORM\EntityManager;
use NoteBookBundle\Form\CardPersonType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\Container;

class FormAddPerson
{

    private $em;
    private $repository;
    private $tokenStorage;
    private $session;
    private $form;

    public function __construct( EntityManager $em, TokenStorage $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->session = new Session;
    }

    public function setForm($form)
    {
        $this->form = $form;
        return $this;
    }

    public function create() {

        if($this->form->isValid()){
            $data_form = $this->form->getData();

            $this->em->persist($data_form);
            $this->em->flush();

            $this->session->getFlashBag()->add('message',"Personne a été ajoutée correctement.");
        }
    }

    public function update() {

        if($this->form->isValid()){

            $data_form = $this->form->getData();
            $this->em->persist($data_form);
            $this->em->flush();

            $this->session->getFlashBag()->add('message',"La fiche a été modifiés.");
        }
    }
}
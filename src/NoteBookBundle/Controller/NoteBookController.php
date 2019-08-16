<?php

namespace NoteBookBundle\Controller;

use NoteBookBundle\Entity\CardPerson;
use NoteBookBundle\Entity\NoteBook;
use NoteBookBundle\Form\CardPersonType;

use NoteBookBundle\Service\FormManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class NoteBookController extends Controller
{
    /**
     * @Route("/", name="list_persons")
     */
    public function listerPersonsAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $listePersons = $em->getRepository('NoteBookBundle:CardPerson')->findAll();


        $persons  = $this->get('knp_paginator')->paginate(
            $listePersons,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            10 /*nbre d'éléments par page*/
        );


        return $this->render('notebook/liste_person.html.twig', array(
            'persons' => $persons
        ));
    }
    /**
     * @Route("/add", name="add_person")
     */
    public function addPersonAction(Request $request)
    {
        $form_add_service = $this->get('form_add_person');
        $cardPerson = new CardPerson();
        $cardPerson->setCreatedAt(new \Datetime());

        $form = $this->createForm(CardPersonType::class, $cardPerson);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $form_add_service->setForm($form)->create();

            return $this->redirectToRoute('add_person');
        }

        return $this->render('cardperson/add_person.html.twig', array(
            'form_add_person' => $form->createView()
        ));
    }


    /**
     * @Route("/edit/{id_person}", requirements={"id_person" = "\d+"}, name="edit_person")
     * @ParamConverter("person", class="NoteBookBundle:CardPerson", options={"mapping": {"id_person":"id"}})
     */
    public function editPersonAction(Request $request, CardPerson $person)
    {

        $form_add_service = $this->get('form_add_person');

        $form = $this->createForm(CardPersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $form_add_service->setForm($form)->update();

            return $this->redirectToRoute('edit_person', array(
                'id_person' => $person->getId()
            ));
        }

        return $this->render('cardperson/add_person.html.twig', array(
            'form_add_person' => $form->createView(),
            'person' => $person
        ));


    }


    /**
     * @Route("/delate/{id_person}", requirements={"id_person" = "\d+"}, name="delate_person")
     * @ParamConverter("person", class="NoteBookBundle:CardPerson", options={"mapping": {"id_person":"id"}})
     * @return RedirectResponse
     */
    public function delatePersonAction(Request $request, CardPerson $person)
    {

        $em = $this->getDoctrine()->getManager();

        $em->remove($person);
        $em->flush();

        $this ->get('session')->getFlashBag()->add('message_delate', "La personne a bien été supprimé. ");

        return $this->redirectToRoute('list_persons', $request->query->all());
    }
}

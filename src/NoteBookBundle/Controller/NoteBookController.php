<?php

namespace NoteBookBundle\Controller;

use NoteBookBundle\Entity\CardPerson;
use NoteBookBundle\Entity\NoteBook;
use NoteBookBundle\Form\CardPersonType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $em = $this->getDoctrine()->getManager();

        $person = new CardPerson();
        $form_add_person = $this->get('form.factory')->create(CardPersonType::class, $person);

        $form_add_person->handleRequest($request);

        if ($form_add_person->isSubmitted() && $form_add_person->isValid()) {

            $person->setCreatedAt(new \Datetime());

            $em->persist($person);
            $em->flush();

            $this ->get('session')->getFlashBag()->add('message', "La personne a bien été ajouté. ");

            return $this->redirectToRoute('add_person');
        }

        return $this->render('cardperson/add_person.html.twig', array(
            'form_add_person' => $form_add_person->createView()
        ));
    }


    /**
     * @Route("/edit/{id_person}", requirements={"id_person" = "\d+"}, name="edit_person")
     * @ParamConverter("person", class="NoteBookBundle:CardPerson", options={"mapping": {"id_person":"id"}})
     */
    public function editPersonAction(Request $request, CardPerson $person)
    {
        $em = $this->getDoctrine()->getManager();

        $form_edit_person = $this->get('form.factory')->create(CardPersonType::class, $person);

        $form_edit_person->handleRequest($request);

            if ($form_edit_person->isSubmitted() && $form_edit_person->isValid()) {

                $em->flush();

                $this ->get('session')->getFlashBag()->add('message', "Merci, la fiche de la personne a bien été mise à jour. ");

                return $this->redirectToRoute('edit_person', array(
                    'id_person'=>$person->getId()
                ));
            }

        return $this->render('cardperson/add_person.html.twig', array(
            'form_add_person' => $form_edit_person->createView(),
            'person'=>$person
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

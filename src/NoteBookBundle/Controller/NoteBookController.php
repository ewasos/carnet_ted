<?php

namespace NoteBookBundle\Controller;

use NoteBookBundle\Entity\NoteBook;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class NoteBookController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('notebook/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    /**
     * @Route("/add", name="add_notebook")
     */
    public function createAction()
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: createAction(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $notebook = new NoteBook();
        $notebook->setName('test');
        $notebook->setCreatedAt(new \DateTime);


        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($notebook);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$notebook->getId());
    }


    /**
     * @Route("/delate", name="delate_notebook")
     */
    public function delateAction()
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: createAction(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()->getRepository(NoteBook::class);
        $product = $repository->find(1);

        $entityManager->remove($product);
        $entityManager->flush();


        return new Response('ok');
    }
    }

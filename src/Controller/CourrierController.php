<?php

namespace App\Controller;

use App\Entity\Courrier;
use App\Form\CourrierType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourrierController extends AbstractController
{
    /**
     * @Route("/courrier", name="courrier")
     */
    public function index(): Response
    {
        return $this->render('courrier/index.html.twig', [
            'controller_name' => 'CourrierController',
        ]);
    }

    /**
     * @Route("/send", name="send")
     */
    public function send(Request $request):Response
    {


        return $this->render("courrier/send.html.twig"
        );
    }
    /**
     * @Route("/received", name="received")
     */
    public function received(): Response
    {
        return $this->render('courrier/received.html.twig');
    }

    /**
     * @Route("/read/{id}", name="read")
     */
    public function read(Courrier $courrier): Response
    {
        $courrier->setIsRead(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($courrier);
        $em->flush();
        return $this->render('courrier/read.html.twig');
    }
}

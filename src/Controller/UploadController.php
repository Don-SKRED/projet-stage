<?php

namespace App\Controller;

use App\Entity\Upload;
use App\Form\UploadType;
use App\Service\serviceExcel;
use PDO;
use PDOException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    /**
     * @Route("/upload", name="upload")
     */
    public function index(Request $request,serviceExcel $serviceExcel):Response
    {

        $upload = new Upload();
        $form = $this-> createForm(UploadType::class,$upload);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $file = $upload->getNom();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $filename);
            $upload->setNom($filename);



            return $this->redirectToRoute("upload");
        }

        return $this->render('upload/index.html.twig', [
            'form' => $form->createView(),

        ]);
    }
}

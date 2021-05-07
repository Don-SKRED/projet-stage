<?php
namespace App\Controller;
use App\Entity\Libelle;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Entity\Upload;
use App\Form\UploadType;

use App\Entity\Courrier;
use App\Form\CourrierType;
use PDO;
use PDOException;
use PhpOffice\PhpSpreadsheet\Shared\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * @Route("/page")
 * Class PageController
 * @package App\controller
 */
class pageController extends AbstractController
{
    /**
     * @Route("/home/{id}", name="page_index", methods={"GET","POST"})
     */
    public function show(Request $request,SluggerInterface $slugger): Response
   {
       try{
           $pdo=new PDO("mysql:host=localhost;dbname=stage2","root","");

       }
       catch(PDOException $e){
           echo $e->getMessage();
       }
       /*

*/
       $courrier = new Courrier();
        $libelle = new Libelle();

       $user = $this->getUser();
       $form = $this->createForm(CourrierType::class,$courrier);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid())
       {
           $file = $courrier->getFichier();

           $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
           $typemimes = $file->getClientMimeType();
           // this is needed to safely include the file name as part of the URL
           $newFilename = $originalFilename.'-'.uniqid().'.'.$file->getClientOriginalExtension();


          

           // envoye du fichier sur la base de données
           //  $filename = $file->getClientOriginalName();
           $UploadedFile = $file->move($this->getParameter('upload_directory'), $newFilename);
           //dump($test->getPathname());die;
           $courrier->setFichier($newFilename);


           //service


           //prendre l'envoyeur
           $courrier->setSender($this->getUser());
           $em =$this->getDoctrine()->getManager();

          // dump($courrier); die;
           $em->persist($courrier);
           $em->flush();

           $id_courrier = $courrier->getId();




           //message flash
           //si le fichier existe
    //dump( $id_courrier); die;
           $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($UploadedFile->getPathname());
           $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type );

           $spreadsheet = $reader->load($UploadedFile->getPathname());
           $data = $spreadsheet->getActiveSheet()->toArray();
           //dump($data);die;

           //$id_courrier = $libelle->getCourrier();
           foreach ($data as $row) {
               $insert_data = array(
                   ':nom' => $row[0],
                   ':prenom' => $row[1],
                   ':numero' => $row[2],
                   ':courier_id' => $id_courrier,


               );

               $query = "INSERT INTO upload ( nom, prenom, numero, courier_id) VALUES ( :nom, :prenom, :numero, :courier_id)";
               $statement = $pdo->prepare($query);
               $statement->execute($insert_data);
           }
    //dump($courrier); die;
           return $this->redirectToRoute("send");
       }

       return $this->render('after_log/page.html.twig',[
           "form" => $form->createView(),
           "user" => $user,
       ]);

    }
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
        $courrier = new Courrier();
        $user = $this->getUser();
        $form = $this->createForm(CourrierType::class,$courrier);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {$file = $courrier->getFichier();
            $filename = md5(uniqid()).'.'.$file->getClientOriginalExtension();
            $file->move($this->getParameter('upload_directory'), $filename);
            $courrier->setFichier($filename);
            //prendre l'envoyeur
            $courrier->setSender($this->getUser());
            $em =$this->getDoctrine()->getManager();
            $em->persist($courrier);
            $em->flush();

            //message flash
            $this->addFlash("courrier","Courrier envoyé avec succès");
            return $this->redirectToRoute("courrier");
        }


        return $this->render("courrier/send.html.twig",[
            "form" => $form->createView(),
            "user" => $user,
        ]);
    }
    /**
     * @Route("/received", name="received")
     */
    public function received(): Response
    {
        $user = $this->getUser();
        return $this->render('courrier/received.html.twig',[
            "user" => $user,
        ]);
    }
    /**
     * @Route("/excel_show", name="excel_show")
     */
    public function excel_show(Courrier $courrier): Response
    {
        $user = $this->getUser();
        $file = $courrier ->getFichier();
        $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file->getPathname());
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type );

        $spreadsheet = $reader->load($file->getPathname());
        $writer = Spreadsheet::createWriter($spreadsheet, 'Html');
        $message = $writer->save($this->getParameter('upload_directory'));

        echo $message;

        return $this->render('courrier/exShow.html.twig',[
            "user" => $user,
            //"file" => $file,
        ]);
    }


}
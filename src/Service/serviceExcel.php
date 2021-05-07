<?php
namespace App\Service;

use App\Entity\Courrier;
use App\Form\CourrierType;
use PDO;
use PDOException;
use PhpOffice\PhpSpreadsheet\Reader\Csv as po;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;


define('HOST','localhost');
define('USER','root');
define('PASSWORD','');
define('BDD','stage2');
class  serviceExcel{
    public  function test(Courrier $courrier){
        try{
            $pdo=new PDO("mysql:host=localhost;dbname=stage2","root","");

        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
        /*
        //phpspreadsheet
        $reader = new po();
        $spreadsheet = $reader->load($file);

        //read & import
        $worksheet = $spreadsheet->getActiveSheet();
        foreach ($worksheet->getRowIterator() as $row)
        {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            $data = [];
            foreach ($cellIterator as $cell)
            {
                $data[] = $cell->getValue();
            }
            print_r($data);
        }

        //return $data;
*/
        //si le fichier existe
        if($courrier->getFichier() != '') {
            $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($courrier->getFichier());
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($courrier->getFichier());

            $spreadsheet = $reader->load($courrier->getFichier());
            $data = $spreadsheet->getActiveSheet()->toArray();

            foreach ($data as $row) {
                $insert_data = array(
                    ':nom'    => $row[0],
                    ':prenom' => $row[1],
                    ':numero' => $row[2],
                );

                $query = "INSERT INTO upload ( nom, prenom, numero) VALUES ( :nom, :prenom, :numero)";
                $statement = $pdo->prepare($query);
                $statement->execute($insert_data);
            }


        }



    }
    //courrier[fichier] upload[_token]



}
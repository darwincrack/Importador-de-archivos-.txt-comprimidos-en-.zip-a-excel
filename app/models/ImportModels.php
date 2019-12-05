<?php

namespace App\models;

use DB;
use Auth;

class ImportModels
{



    static public function insertar($name_file)
    {


        $lastInsertID= DB::table('import_zip')->insertGetId(
            [ 'name_file' => $name_file, 'created_at' => DB::raw("now()")]
        );

        return $lastInsertID;

       // ImportModels::insertarTXT('', $lastInsertID);

    }


        static public function insertarTXT($listfiles, $id_import_zip)
    {


        $lastInsertID= DB::table('import_txt')->insertGetId(
            [ 'name_file' => $listfiles,'id_import_zip' => $id_import_zip, 'created_at' => DB::raw("now()")]
        );

    }




    static public function countImport($id_zip)
    {

        $data=DB::table('import_txt')
         ->where('id_import_zip', $id_zip)
         ->count();
        return $data;
    }


    static public function NameZip($name_file)
    {

        $data=DB::table('import_zip')
         ->where('name_file', $name_file)
         ->count();
        return $data;
    }





        static public function descarga($nombreUser, $emailUser,$name_file_xlsx,$id_import_zip)
    {


        $lastInsertID= DB::table('descargas')->insertGetId(
            [ 'nombreUser' => $nombreUser,
               'emailUser' => $emailUser,
               'name_file_xlsx' => $name_file_xlsx,
               'id_import_zip' => $id_import_zip,
               'created_at' => DB::raw("now()")]
        );

    }








}
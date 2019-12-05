<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Zip;
use ZanySoft\Zip\ZipManager;

use App\Exports\ExportFile;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use App\models\ImportModels;
use Session;
use Validator;

//libreria de zip https://github.com/zanysoft/laravel-zip
//libreria de excel https://phpspreadsheet.readthedocs.io/


class ImportController extends Controller
{

   public  $path_comprimido = "";

    /**
     * Generate Image upload View
     *
     * @return void
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Image Upload Code
     *
     * @return void
     */
    public function dropzoneStore(Request $request)
    {



         try {
    
        $image = $request->file('files');
        $fileName = $image->getClientOriginalName();

        if (ImportModels::NameZip($fileName) >= 1)
        {

            return response()->json(['error' => 'Archivo ya existe, intente de nuevo por favor']);

        }

        $this->path_comprimido = public_path("zip" . DIRECTORY_SEPARATOR . "compressed");

        $imageName = $fileName;
        $image->move($this->path_comprimido, $fileName);

        $lastInsertID = ImportModels::insertar($fileName);

        $nombre_archivo_zip = $fileName;

        $this->path_comprimido = (public_path("zip" . DIRECTORY_SEPARATOR . "compressed") . DIRECTORY_SEPARATOR . $nombre_archivo_zip);

        $path_descomprimido = (public_path("zip" . DIRECTORY_SEPARATOR . "unzipped") . DIRECTORY_SEPARATOR);

        if (!file_exists($this->path_comprimido))
        {

            unlink($this->path_comprimido);
            return response()->json(['error' => 'no se ha encontrado el archivo, intente de nuevo por favor']);

        }

        if (!Zip::check($this->path_comprimido))
        {

            unlink($this->path_comprimido);
            return response()->json(['error' => 'no es un .zip valido, intente de nuevo por favor']);

        }

        $zip = Zip::open($this->path_comprimido);

        // extract whole archive
        $zip->extract($path_descomprimido . $nombre_archivo_zip);

        $listfiles = $zip->listFiles();

        $zip->close();

        $htmlListFile = "<ul>";

        foreach ($listfiles as $v => $value)
        {

            $htmlListFile .= "<li>" . $value . "<li>";
        }
        $htmlListFile .= "</ul>";

        $total_files = count($listfiles);

        session(['nombre_archivo_zip' => $nombre_archivo_zip]);
        session(['listfiles' => $listfiles]);
        session(['id_zip' => $lastInsertID]);

        session(['createXlsx' => true]);

        
       

        $resultado = $listfiles[0];

        $i = 0;
        $csv = [];

        if (!file_exists("public/zip/unzipped/$nombre_archivo_zip/$resultado"))
        {
            unlink($this->path_comprimido);
            return response()->json(['error' => 'No se ha podido abrir el archivo, intente de nuevo por favor']);

        }

        $file = fopen("public/zip/unzipped/$nombre_archivo_zip/$resultado", "r");

        while (!feof($file))
        {

            $result = fgetcsv($file, 0, '|');

            if ($result != "")
            { // ignore blank lines
                $csv[$i++] = $result;
            }
            if ($i == 2) break;
        }

        fclose($file);
        $nombreContribuyente = $csv[1][20];

        return response()->json(['success' => true, 'total_files' => $total_files, 'html' => $htmlListFile, 'nombreContribuyente' => $nombreContribuyente]);

}
catch (Exception $e) {
        return response()->json(['error' => 'Ocurrio un error inesperado '.$e]);
    }


    }

    public function importar(Request $request)
    {

        ob_implicit_flush(1);

        if ($request->session()
            ->has('createXlsx'))
        {
            //
            $listfiles = Session::get('listfiles');
            $nombre_archivo_zip = Session::get('nombre_archivo_zip');
            $id_zip = Session::get('id_zip');

            $count = count($listfiles) - 1;
            $j = 0;

            $spreadsheet = new Spreadsheet();

            foreach ($listfiles as $v => $value)
            {

                $i = 0;

                $csv = [];
                $file = fopen("public/zip/unzipped/$nombre_archivo_zip/$value", "r");

                while (!feof($file))
                {

                    $result = fgetcsv($file, 0, '|');

                    if ($result != "")
                    { // ignore blank lines
                        $csv[$i++] = $result;
                    }
                }

                fclose($file);

                $spreadsheet->setActiveSheetIndex($j);

                $spreadsheet->getActiveSheet()
                    ->fromArray($csv, // The data to set
                NULL, // Array values with this value will not be set
                'A1'
                // Top left coordinate of the worksheet range where
                //    we want to set these values (default is A1)
                );

                $spreadsheet->getActiveSheet()
                    ->setTitle($value);

                // Auto size columns for each worksheet
                foreach ($spreadsheet->getWorksheetIterator() as $worksheet)
                {

                    $spreadsheet->setActiveSheetIndex($spreadsheet->getIndex($worksheet));

                    $sheet = $spreadsheet->getActiveSheet();
                    $cellIterator = $sheet->getRowIterator()
                        ->current()
                        ->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(true);
                    /** @var PHPExcel_Cell $cell */
                    foreach ($cellIterator as $cell)
                    {
                        $sheet->getColumnDimension($cell->getColumn())
                            ->setAutoSize(true);
                    }
                }

                if ((int)$j <> (int)$count)
                {
                    // Create a new worksheet, after the default sheet
                    $spreadsheet->createSheet();

                }

                $j++;

                $lastInsertID = ImportModels::insertarTXT($value, $id_zip);

                sleep(1);

                if (ob_get_level() > 0)
                {
                    ob_end_flush();
                }

            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("public/xlsx/" . str_replace(".zip", "", $nombre_archivo_zip) . ".xlsx");

            Session::forget("createXlsx");

        }
    }

    public function procesando()
    {

        $count = ImportModels::countImport(Session::get('id_zip'));
        return $count;
    }

    public function formstore(Request $request)
    {

        $validator = Validator::make($request->all() , ['nombre' => 'required|max:50', 'email' => 'required|email|max:50',

        ]);

        $nombre = $request->input('nombre');
        $email = $request->input('email');
        $id_import_zip = Session::get('id_zip');
        $name_file_xlsx = str_replace(".zip", "", Session::get('nombre_archivo_zip')) . ".xlsx";

        $lastInsertID = ImportModels::descarga($nombre, $email, $name_file_xlsx, $id_import_zip);

        if ($validator->passes())
        {

            return response()
                ->json(['success' => true, 'msg' => $name_file_xlsx]);
        }

        return response()->json(['error' => $validator->errors()
            ->all() ]);

    }

    public function descarga(Request $request)
    {

        if ($request->session()
            ->has('nombre_archivo_zip'))
        {

            $name_file_xlsx = str_replace(".zip", "", Session::get('nombre_archivo_zip')) . ".xlsx";

            return response()->download("public/xlsx/$name_file_xlsx", "$name_file_xlsx");
        }

        // Session::flush();
        
    }

}


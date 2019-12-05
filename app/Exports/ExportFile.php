<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class ExportFile implements FromArray, WithHeadings, ShouldAutoSize, WithMultipleSheets
{
    use Exportable;
    private $myArray;
    private $myHeadings;

    public function __construct($myArray, $myHeadings){
        $this->myArray = $myArray;
        $this->myHeadings = $myHeadings;
    }

    public function array(): array{
        return $this->myArray;
    }

    public function headings(): array{
        return $this->myHeadings;
    }

     public function sheets(): array{
         $sheets = [];
       for ($month = 1; $month <= 12; $month++) {
            $sheets[] = $month;
        }
        return $sheets;
    }
}

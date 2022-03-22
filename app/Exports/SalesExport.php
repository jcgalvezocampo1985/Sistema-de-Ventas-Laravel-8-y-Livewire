<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection; // para trabajar con colecciones y obtener los datos
use Maatwebsite\Excel\Concerns\WithHeadings; // para definir los títulos de encabezado
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet; // para interactuar con el libro
use Maatwebsite\Excel\Concerns\WithCustomStartCell; // para definir la celda donde iniciara el reporte
use Maatwebsite\Excel\Concerns\WithTitle; // para colocar nombre a las hojas del libro
use Maatwebsite\Excel\Concerns\Withstyles; //para dar formato a las celdas
use Carbon\Carbon;

/*
use Maatwebsite\Excel\Concerns\WithColumnWidths; // para asignar ancho de columnas
use Illuminate\Database\Query\Builder; //Utilizar cuando sean muchos registros
use Maatwebsite\Excel\Concerns\FromQuery; //Utilizar cuando sean muchos registros
use Maatwebsite\Excel\Concerns\Exportable; //
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
*/

class SalesExport implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithStyles
{
    protected $userId;
    protected $dateFrom;
    protected $dateTo;
    protected $reportType;

    public function __construct($userId, $reportType, $dateFrom, $dateTo)
    {
        $this->userId = $userId;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->reportType = $reportType;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = [];

        if($this->reportType == 0)
        {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d').' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d').' 23:59:59';
        }
        else
        {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d').' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d').' 23:59:59';
        }

        if($this->userId == 0)
        {
            $data = Sale::join('users AS u', 'u.id', 'sales.user_id')
                        ->select('sales.id', 'sales.total', 'sales.items', 'sales.status', 'u.name', 'sales.created_at', )
                        ->whereBetween('sales.created_at', [$from, $to])
                        ->get();
        }
        else
        {
            $data = Sale::join('users AS u', 'u.id', 'sales.user_id')
                        ->select('sales.id', 'sales.total', 'sales.items', 'sales.status', 'u.name', 'sales.created_at', )
                        ->whereBetween('sales.created_at', [$from, $to])
                        ->where('u.id', $this->userId)
                        ->get();
        }

        return $data;
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function headings(): array
    {
        return ['Folio', 'Importe', 'Items', 'Estatus', 'Usuario', 'Fecha'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            2 => ['font' => ['bold' => true]],//número de registro de excel donde se aplicaran los estilos
        ];
    }

    public function title(): string
    {
        return 'Reporte de Ventas';
    }
}
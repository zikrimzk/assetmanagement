<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class AssetCustomExport implements FromCollection, WithHeadings, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $comp_id;
    protected $dep_id;
    protected $area_id;


    function __construct($comp_id,$dep_id,$area_id )
    {
        $this->comp_id = $comp_id;
        $this->dep_id = $dep_id;
        $this->area_id = $area_id;

    }

    public function collection()
    {
        $data = DB::table('assets as a')
            ->join('companies as b', 'a.comp_id', 'b.id')
            ->join('departments as c', 'a.dep_id', 'c.id')
            ->join('areas as d', 'a.area_id', 'd.id')
            ->join('asset_items as e', 'a.item_id', 'e.id')
            ->join('staffs as f', 'a.staff_id', 'f.id')
            ->select('a.asset_code', 'a.asset_serialno', 'e.item_name', 'a.asset_cost', 'a.asset_marketval', 'a.asset_brand', 'a.asset_remarks', 'f.staff_name');

            if(!is_null($this->comp_id)) {
                $data->where('a.comp_id', $this->comp_id);
            }
            if (!is_null($this->dep_id)) {
                $data->where('a.dep_id', $this->dep_id);
            }
            if (!is_null($this->area_id)) {
                $data->where('a.area_id', $this->area_id);
            }
            $exData = $data->orderBy('a.created_at', 'asc')->get();
        return $exData;
    }

    public function headings(): array
    {
        return ["Asset Code", "Serial No", "Item Name", "Cost (RM)", "Market Value (RM)", "Brand", "Remarks", "Add by"];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {

                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(20);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(50);


                // Set the format of column B to text
                $event->sheet->getDelegate()->getStyle('B')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
            },
        ];
    }
}

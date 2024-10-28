<?php

namespace App\Exports;

use App\Models\AssetItem;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AssetItemExport implements FromCollection, WithHeadings, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = DB::table('asset_items as a')
            ->join('asset_types as b', 'a.type_id', 'b.id')
            ->select('a.item_code','a.item_name', 'b.type_name','a.created_at')
            ->orderby('a.created_at', 'asc')
            ->get();
        return $data;
    }
    public function headings(): array
    {
        return ["Item Code", "Item Name", "Type Name","Create At"];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {

                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(20);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(20);

            },
        ];
    }
}

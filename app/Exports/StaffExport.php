<?php

namespace App\Exports;

use App\Models\Staff;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StaffExport implements FromCollection, WithHeadings, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = DB::table('staffs as a')
            ->join('companies as b', 'a.comp_id', 'b.id')
            ->join('departments as c', 'a.dep_id', 'c.id')
            ->select('a.staff_no', 'a.staff_name', 'a.staff_phone', 'a.email', 'c.department_name', 'a.staff_role','b.company_name')
            ->orderby('a.created_at', 'asc')
            ->get();
        
        return $data;
    }
    public function headings(): array
    {
        return ["Staff No", "Full Name", "Phone No", "Email","Department","Role","Company"];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {

                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(20);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(60);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(40);


            },
        ];
    }
}

<?php

namespace App\Charts;

use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\PieChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class StaffCompanyChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): PieChart
    {
        $data_label = DB::table('staffs as a')
        ->join('companies as b', 'a.comp_id', 'b.id')
        ->select('b.company_name')
        ->distinct()
        ->get();
        foreach($data_label as $dl){
            $label[] = $dl->company_name;
        }

        $data_count = DB::table('staffs as a')
            ->join('companies as b', 'a.comp_id', 'b.id')
            ->select(DB::raw('count(*) as total'))
            ->where('staff_status','!=',3)
            ->groupBy('b.company_code')
            ->get();

        foreach ($data_count as $dc) {
            $count[] = $dc->total;
        }
        

        return $this->chart->pieChart()
            ->addData($count)
            ->setColors(['#1F378C', '#17BBCB'])
            ->setLabels($label);
    }
}

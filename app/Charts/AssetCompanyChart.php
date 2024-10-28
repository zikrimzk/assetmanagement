<?php

namespace App\Charts;

use Exception;
use Mockery\Undefined;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\PieChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class AssetCompanyChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): PieChart
    {
        try{
            $data_label = DB::table('assets as a')
            ->join('companies as b', 'a.comp_id', 'b.id')
            ->select('b.company_name')
            ->distinct()
            ->get();
            foreach($data_label as $dl){
                $label[] = $dl->company_name;
            }
    
            $data_count = DB::table('assets as a')
                ->join('companies as b', 'a.comp_id', 'b.id')
                ->select(DB::raw('count(*) as total'))
                ->groupBy('b.company_code')
                ->get();
    
        
            foreach ($data_count as $dc) {
                $count[] = $dc->total;
            }
            
            return $this->chart->pieChart()
                ->addData($count)
                ->setColors(['#00B0D8', '#1D1664'])
                ->setLabels($label);
        }
        catch(Exception $e){
            return $this->chart->pieChart()
                ->addData(['0'])
                ->setColors(['#303F9F','#FFC107'])
                ->setLabels(['No Value']);

        }
    }
       
}

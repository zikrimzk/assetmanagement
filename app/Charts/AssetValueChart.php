<?php

namespace App\Charts;

use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class AssetValueChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    // public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    // {
    //     return $this->chart->barChart()
    //         ->setTitle('San Francisco vs Boston.')
    //         ->setSubtitle('Wins during season 2021.')
    //         ->addData('San Francisco', [6, 9, 3, 4, 10, 8])
    //         ->addData('Boston', [7, 3, 8, 2, 6, 4])
    //         ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June']);
    // }
    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        // Run the query
        $totalcostpercomp = DB::table('assets as a')
            ->join('companies as b', 'a.comp_id', 'b.id')
            ->select(
                DB::raw('YEAR(a.asset_date) as year'), // Extracting the year from asset_date
                DB::raw('sum(a.asset_cost) as totalcost'),
                'b.company_code'
            )
            ->groupBy(DB::raw('YEAR(a.asset_date)'), 'b.company_code') // Grouping by the extracted year and comp_id
            ->get();

        // Transform the data
        $data = [];
        $years = [];
        $companies = [];

        foreach ($totalcostpercomp as $item) {
            $year = $item->year;
            $company_code = $item->company_code;
            $totalcost = $item->totalcost;

            if (!isset($data[$company_code])) {
                $data[$company_code] = [];
            }

            if (!in_array($year, $years)) {
                $years[] = $year;
            }

            $data[$company_code][$year] = $totalcost;
        }

        // Ensure all companies have data for all years, filling missing data with 0
        foreach ($data as $company_code => $yearData) {
            foreach ($years as $year) {
                if (!isset($data[$company_code][$year])) {
                    $data[$company_code][$year] = 0;
                }
            }
            ksort($data[$company_code]);
        }

        // Prepare the series data for the chart
        $series = [];
        foreach ($data as $company_code => $yearData) {
            $series[] = [
                'name' => $company_code,
                'data' => array_values($yearData)
            ];
        }

        // Sort years for the X-axis
        sort($years);

        // Build the chart
        return $this->chart->barChart()
            ->setTitle('Company Asset Costs by Year')
            ->setSubtitle('Total asset costs per company by year')
            ->setXAxis($years)
            ->setDataset($series);
    }
}

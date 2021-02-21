<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $count_all = Invoice::count();
        $count_invoices1 = Invoice::where('Value_Status', 1)->count();
        $count_invoices2 = Invoice::where('Value_Status', 2)->count();
        $count_invoices3 = Invoice::where('Value_Status', 3)->count();

        if($count_invoices2 == 0){
            $nspainvoices2=0;
        }
        else{
            $nspainvoices2 = round($count_invoices2/ $count_all*100,2);
        }

        if($count_invoices1 == 0){
            $nspainvoices1=0;
        }
        else{
            $nspainvoices1 = round($count_invoices1/ $count_all*100,2);
        }

        if($count_invoices3 == 0){
            $nspainvoices3=0;
        }
        else{
            $nspainvoices3 = round($count_invoices3/ $count_all*100,2);
        }


        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 300, 'height' => 160])
            ->datasets([
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#F48543'],
                    'data' => [$nspainvoices3]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#1BAD7E'],
                    'data' => [$nspainvoices1]
                ],

                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#F95470'],
                    'data' => [$nspainvoices2]
                ]


            ])
            ->optionsRaw([
                'legend' => [
                    'display' => true,

                    'labels' => [
                        'fontFamily' => 'Cairo',
                        'fontStyle' => 'bold'

                    ]

                ]
            ]);


        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('doughnut')
            ->size(['width' => 340, 'height' => 200])
            ->labels([ 'الفواتير الغير المدفوعة','الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#F95470 ', '#1BAD7E','#F48543'],
                    'data' => [$nspainvoices2,$nspainvoices1,$nspainvoices3]
                ]
            ])
            ->options([]);

        return view('home', compact('chartjs','chartjs_2'));

    }
}

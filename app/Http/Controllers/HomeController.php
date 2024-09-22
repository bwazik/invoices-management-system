<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Section;
use App\Models\User;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        # Third row in the home page
        $sections = Section::select('id', 'name')->get();

        # Invoices count and percentage
        $all_sum = number_format(Invoice::sum('total'), 2);
        $all_count = Invoice::count();

        $paid_sum = number_format(Invoice::where('status', 1)->sum('total'), 2);
        $paid_count = Invoice::where('status', 1)->count();

        $partial_paid_sum = number_format(Invoice::where('status', 3)->sum('total'), 2);
        $partial_paid_count = Invoice::where('status', 3)->count();

        $unpaid_sum = number_format(Invoice::where('status', 2)->sum('total'), 2);
        $unpaid_count = Invoice::where('status', 2)->count();

        # Font depends on language
        if(app()->getLocale() == 'en')
        {
            $font = 'Poppins';
        }
        elseif(app()->getLocale() == 'ar')
        {
            $font = 'Cairo';
        }

        # First chart functions
        $year = date('Y');

        $j_paid_percent = Invoice::whereBetween('date' , [$year.'-01-01' , $year.'-02-01'])->where('status' , 1)->count();
        $j_partial_paid_percent = Invoice::whereBetween('date' , [$year.'-01-01' , $year.'-02-01'])->where('status' , 3)->count();
        $j_unpaid_percent = Invoice::whereBetween('date' , [$year.'-01-01' , $year.'-02-01'])->where('status' , 2)->count();

        $f_paid_percent = Invoice::whereBetween('date' , [$year.'-02-01' , $year.'-03-01'])->where('status' , 1)->count();
        $f_partial_paid_percent = Invoice::whereBetween('date' , [$year.'-02-01' , $year.'-03-01'])->where('status' , 3)->count();
        $f_unpaid_percent = Invoice::whereBetween('date' , [$year.'-02-01' , $year.'-03-01'])->where('status' , 2)->count();

        $m_paid_percent = Invoice::whereBetween('date' , [$year.'-03-01' , $year.'-04-01'])->where('status' , 1)->count();
        $m_partial_paid_percent = Invoice::whereBetween('date' , [$year.'-03-01' , $year.'-04-01'])->where('status' , 3)->count();
        $m_unpaid_percent = Invoice::whereBetween('date' , [$year.'-03-01' , $year.'-04-01'])->where('status' , 2)->count();

        $a_paid_percent = Invoice::whereBetween('date' , [$year.'-04-01' , $year.'-05-01'])->where('status' , 1)->count();
        $a_partial_paid_percent = Invoice::whereBetween('date' , [$year.'-04-01' , $year.'-05-01'])->where('status' , 3)->count();
        $a_unpaid_percent = Invoice::whereBetween('date' , [$year.'-04-01' , $year.'-05-01'])->where('status' , 2)->count();

        $ma_paid_percent = Invoice::whereBetween('date' , [$year.'-05-01' , $year.'-06-01'])->where('status' , 1)->count();
        $ma_partial_paid_percent = Invoice::whereBetween('date' , [$year.'-05-01' , $year.'-06-01'])->where('status' , 3)->count();
        $ma_unpaid_percent = Invoice::whereBetween('date' , [$year.'-05-01' , $year.'-06-01'])->where('status' , 2)->count();

        $ju_paid_percent = Invoice::whereBetween('date' , [$year.'-06-01' , $year.'-07-01'])->where('status' , 1)->count();
        $ju_partial_paid_percent = Invoice::whereBetween('date' , [$year.'-06-01' , $year.'-07-01'])->where('status' , 3)->count();
        $ju_unpaid_percent = Invoice::whereBetween('date' , [$year.'-06-01' , $year.'-07-01'])->where('status' , 2)->count();


        $chart1 = Chartjs::build()
        ->name('lineChartTest')
        ->type('line')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['January', 'February', 'March', 'April', 'May', 'June'])
        ->datasets([
            [
                "label" => trans('layouts/sidebar.invoice.paid'),
                'backgroundColor' => "rgba(20, 164, 77, 0.31)",
                'borderColor' => "#14A44D",
                "pointBorderColor" => "#14A44D",
                "pointBackgroundColor" => "#14A44D",
                "pointHoverBackgroundColor" => "#14A44D",
                "pointHoverBorderColor" => "#14A44D",
                "data" => [$j_paid_percent, $f_paid_percent, $m_paid_percent, $a_paid_percent, $ma_paid_percent, $ju_paid_percent],
                "fill" => true,
            ],
            [
                "label" => trans('layouts/sidebar.invoice.partial'),
                'backgroundColor' => "rgba(228, 161, 27, 0.31)",
                'borderColor' => "#E4A11B",
                "pointBorderColor" => "#E4A11B",
                "pointBackgroundColor" => "#E4A11B",
                "pointHoverBackgroundColor" => "#E4A11B",
                "pointHoverBorderColor" => "#E4A11B",
                "data" => [$j_partial_paid_percent, $f_partial_paid_percent, $m_partial_paid_percent, $a_partial_paid_percent, $ma_partial_paid_percent, $ju_partial_paid_percent],
                "fill" => true,
            ],
            [
                "label" => trans('layouts/sidebar.invoice.unpaid'),
                'backgroundColor' => "rgba(220, 76, 100, 0.31)",
                'borderColor' => "#DC4C64",
                "pointBorderColor" => "#DC4C64",
                "pointBackgroundColor" => "#DC4C64",
                "pointHoverBackgroundColor" => "#DC4C64",
                "pointHoverBorderColor" => "#DC4C64",
                "data" => [$j_unpaid_percent ,$f_unpaid_percent, $m_unpaid_percent, $a_unpaid_percent, $ma_unpaid_percent, $ju_unpaid_percent],
                "fill" => true,
            ]
        ])
        ->options([
            'legend' => [
                'display' => true,
                'labels' => [
                    'fontColor' => 'black',
                    'fontFamily' => $font,
                    'fontSize' => 14,
                ]
            ]
        ]);


        # Second chart functions
        $chart2 = Chartjs::build()
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels([trans('layouts/sidebar.invoice.paid'), trans('layouts/sidebar.invoice.partial'), trans('layouts/sidebar.invoice.unpaid')])
            ->datasets([
                [
                    'backgroundColor' => ['#14A44D', '#E4A11B', '#DC4C64'],
                    'hoverBackgroundColor' => ['#14A44D', '#E4A11B', '#DC4C64'],
                    'data' => [round($paid_count / $all_count * 100, 2), round($partial_paid_count / $all_count * 100, 2), round($unpaid_count / $all_count * 100, 2)]
                ]
            ])
            ->options([
                'legend' => [
                    'display' => true,
                    'labels' => [
                        'fontColor' => 'black',
                        'fontFamily' => $font,
                        'fontSize' => 14,
                    ]
                ]
            ]);


        return view('index', compact('sections', 'all_sum', 'all_count', 'paid_sum', 'paid_count', 'partial_paid_sum', 'partial_paid_count', 'unpaid_sum', 'unpaid_count', 'chart1', 'chart2'));
    }
}

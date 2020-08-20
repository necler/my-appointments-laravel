<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Appointment;
use DB;
use App\User;
use Carbon\Carbon;

class ChartsController extends Controller
{
    //
    public function appointments(){

        $monthlyCounts = Appointment::select(
            DB::raw('MONTH(created_at) as monthly'),
            DB::raw('COUNT(1) as count'))
            ->groupBy('monthly')
            ->get()->toArray();

         $counts = array_fill(0,12,0);
         foreach($monthlyCounts as $monthlyCount){

                $index = $monthlyCount['monthly']-1;
                $counts[$index] = $monthlyCount['count'];
         }

         return view('charts.appointments',compact('counts'));
    }
    public function doctors(){

        $date = new Carbon();
        $now = $date->now();
        $endDate = $now->format('Y-m-d');
        $startDate = $now->subYear()->format('Y-m-d');
        return view('charts.doctors',compact('startDate','endDate'));
    }
    public function doctorsJson(Request $request){


        $start = $request->input('startDate');;
        $end = $request->input('endDate');

        $doctors = User::doctors()
                   ->select('name')
                  ->withCount([
                       'attendedAppointments' => function($query) use ($start, $end){
                           $query->whereBetween('scheduled_date',[$start, $end]);
                       },
                       'cancelledAppointments'=> function($query) use ($start, $end){
                        $query->whereBetween('scheduled_date',[$start, $end]);
                     }
                   ])
                   ->orderBy('attended_appointments_count','desc')
                   ->take(5)
                   ->get();

        // Necesitamos los arrays de los nombre, atendidas y canceladas
        // se consigue con el método pluck() que te devuelve un array de un atributo             ;
        // dd($doctors);

        $data = [];
        $data['categories'] = $doctors->pluck('name');

        $series = [];
        //Atendidas
        $series1['name']= 'Citas atendidas';
        $series1['data']= $doctors->pluck('attended_appointments_count');
        //Canceladas
        $series2['name']= 'Citas canceladas';
        $series2['data'] = $doctors->pluck('cancelled_appointments_count');

        $series[] = $series1;
        $series[] = $series2;

        $data['series'] = $series;

        return $data;
   }
}

<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\WorkDay;

class ScheduleController extends Controller
{
    //

    private $days = ['Lunes','Martes','Miercoles','Jueves','Viernes','Sábado','Domingo'];


    public function edit(){

        $workdays = WorkDay::where('user_id', auth()->id())->get();

        if(count($workdays)){
            $workdays->map(function ($workday){

                $workday->morning_start = (new Carbon ($workday->morning_start))->format('g:i A');
                $workday->morning_end = (new Carbon ($workday->morning_end))->format('g:i A');
                $workday->afternoon_start = (new Carbon ($workday->afternoon_start))->format('g:i A');
                $workday->afternoon_end = (new Carbon ($workday->afetrnoon_end))->format('g:i A');

                return $workday;

            });
        }else{
            $workdays = collect();
            for($i=0; $i<7; $i++){
                $workdays->push(new WorkDay());

            }

        }

        $days = $this->days;
        return view('schedule',compact('workdays','days'));
    }

    public function store(Request $request)
    {
         //dd($request->all());

        $active = $request->input('active') ? : [];
        $morning_start = $request->input('morning_start');
        $morning_end = $request->input('morning_end');
        $afternoon_start = $request->input('afternoon_start');
        $afternoon_end = $request->input('afternoon_end');

        $errors = [];
        for($i=0;$i<7;$i++){

            if($morning_start[$i]> $morning_end[$i]){
                $errors[] = "las horas del turno de mañana son inconsistentes para el dia ".$this->days[$i];
            }
            if($afternoon_start [$i]> $afternoon_end[$i]){
                $errors[] = "las horas del turno de tarde son inconsistentes para el dia ". $this->days[$i];
            }
            WorkDay::updateOrCreate(
                [
                    'day' => $i,
                    'user_id' => auth()->id()]

                ,[
                    'active' => in_array($i,$active),
                    'morning_start' => $morning_start[$i],
                    'morning_end' => $morning_end[$i],
                    'afternoon_start' => $afternoon_start[$i],
                    'afternoon_end' => $afternoon_end[$i],

                 ]);
        }
        if(count($errors)>0){
            return back()->with(compact('errors'));
        }else{
            $notification = "los cambios se han guardado correctamente";
            return back()->with(compact('notification'));
        }
    }

}

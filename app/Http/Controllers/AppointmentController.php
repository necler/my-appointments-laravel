<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ScheduleServiceInterface;

use App\Specialty;
use App\Appointment;
use App\CancelledAppointment;
use Carbon\Carbon;
use Validator;

class AppointmentController extends Controller
{
    //


    public function create(ScheduleServiceInterface $scheduleService)
    {
        //
        $specialties = Specialty::all();

        $specialtyId = old('specialty_id');
        if($specialtyId){
            $specialty = Specialty::find($specialtyId);
            $doctors = $specialty->users;
        }else{
            $doctors = collect();
        }

        $date = old('scheduled_date');
        $doctorId = old('doctor_id');
        if($date && $doctorId){
            $intervals = $scheduleService->getAvailableIntervals($date, $doctorId);
        }else{
            $intervals = null;
        }

        return view('appointments.create',compact('specialties','doctors','intervals'));
    }

    public function index()
    {

        $role = auth()->user()->role;

        if($role == 'admin'){
            //admin->all
            $oldAppointments = Appointment::whereIn('status',['Atendida','Cancelada'])
            ->paginate(10);
            $confirmedAppointments = Appointment::where('status','Confirmada')
            ->paginate(10);
            $pendingAppointments = Appointment::where('status','Reservada')
            ->paginate(10);

        }elseif($role == 'doctor'){
            //doctor
            $oldAppointments = Appointment::whereIn('status',['Atendida','Cancelada'])
                ->where('doctor_id',auth()->id())
                ->paginate(10);
            $confirmedAppointments = Appointment::where('status','Confirmada')
                ->where('doctor_id',auth()->id())
                ->paginate(10);
            $pendingAppointments = Appointment::where('status','Reservada')
                ->where('doctor_id',auth()->id())
                ->paginate(10);
        }elseif($role == 'patient'){
            //patient
            $oldAppointments = Appointment::whereIn('status',['Atendida','Cancelada'])
                ->where('patient_id',auth()->id())
                ->paginate(10);
            $confirmedAppointments = Appointment::where('status','Confirmada')
                ->where('patient_id',auth()->id())
                ->paginate(10);
            $pendingAppointments = Appointment::where('status','Reservada')
                ->where('patient_id',auth()->id())
                ->paginate(10);
        }


        return view('appointments.index',compact('oldAppointments','confirmedAppointments','pendingAppointments','role'));

    }

    public function show(Appointment $appointment)
    {
        //
        $role = auth()->user()->role;
        return view('appointments.show',compact('appointment','role'));

    }
    public function store(Request $request, ScheduleServiceInterface $scheduleService)
    {
        //

        $rules = [
            'description' => 'required',
            'specialty_id' => 'exists:specialties,id',
            'doctor_id' => 'exists:users,id',
            'scheduled_time' => 'required',
        ];

        $messages = ['scheduled_time.required' => 'Por favor seleccione una hora válida para su cita'];
        $validator = Validator::make($request->all() ,$rules ,$messages);

        $validator->after(function ($validator) use ($request,$scheduleService){
            $date = $request->input('shcedule_date');
            $doctorId = $request->input('doctor_id');
            $schedule_time = $request->input('schedule_time');

            if($date && $doctorId && $schedule_time){

                $start = new Carbon($schedule_time);
            }else{
                return;
            }

            if(!$scheduleService->isAvailableIntervals($date, $doctorId, $start)){
                $validator->errors()
                    ->add('available_time','La hora seleccionadaya se encuentra reservada por otro paciente.');
            }

        });

        if($validator->fails()){
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only([
            'description',
            'specialty_id',
            'doctor_id',
            'scheduled_date',
            'scheduled_time',
            'type'
        ]);

        $data['patient_id'] = auth()->id();
        $carbonTime = Carbon::createFromFormat('g:i A', $data['scheduled_time']);
        $data['scheduled_time'] = $carbonTime->format('H:i:s');

        Appointment::create($data);

        $notification= 'la cita ha sido registrada correctamente';
        return back()->with(compact('notification'));

    }

    public function showCancelForm(Appointment $appointment)
    {
        //
        $role = auth()->user()->role;
        if($appointment->status == 'Confirmada')
            $role = auth()->user()->role;
            return view('appointments.cancel',compact('appointment','role'));

          return redirect('/appointments');
    }
    public function postCancel(Appointment $appointment, Request $request)
    {
        //
            if($request->has('justification')){

                $cancellation = new CancelledAppointment;
                $cancellation->justification = $request->input('justification');
                $cancellation->cancelled_by_id = auth()->id();

                $appointment->cancellation()->save($cancellation);

            }

            $appointment->status= 'Cancelada';
            $appointment->save();// update

            $notification = 'La cita se ha cancelado correctamente';
            return redirect('/appointments')->with(compact('notification'));

    }
    public function postConfirm(Appointment $appointment)
    {
        //
            $appointment->status= 'Confirmada';
            $appointment->save();// update

            $notification = 'La cita se ha confirmado correctamente';
            return redirect('/appointments')->with(compact('notification'));

    }

}

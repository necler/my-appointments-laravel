<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Specialty;
use App\Http\Controllers\Controller;

class SpecialtyController extends Controller
{
    //

    public function __construct(){

        $this->middleware('auth');
    }

    public function index(){

        $specialties = Specialty::all();

        return view('specialties.index', compact('specialties'));
    }

    public function create(Specialty $specialty){

        return view('specialties.create', compact('specialty'));
    }

    public function edit(Specialty $specialty){

        return view('specialties.edit',compact('specialty'));
    }

    private function performValidation(Request $request){
        // dd($request->all());

        $rules = [
            'name' => 'required|min:3',
            'description' => 'required'
        ];
        $messages = [
        'name.required' => 'El nombre es requerido',
        'description.required' => 'La descripción es requerida'
        ];
        $this->validate($request, $rules, $messages);

    }

    public function store(Request $request){

       $this->performValidation($request);

       $specialty = new Specialty();
       $specialty->name = $request->input('name');
       $specialty->description = $request->input('description');
       $specialty->save();

       //return back();

       $notification = 'La especialidad ha sido creada';
       return redirect('/specialties')->with(compact('notification'));
    }

    public function update(Request $request, Specialty $specialty){

        $this->performValidation($request);

        $specialty->name = $request->input('name');
        $specialty->description = $request->input('description');
        $specialty->save();

        $notification = 'La especialidad ha sido actualizada';
        return redirect('/specialties')->with(compact('notification'));
     }

     public function destroy(Specialty $specialty){

            $specialtyName = $specialty->name;
            $specialty->delete();
            $notification = 'La especialidad '.$specialtyName.' ha sido eliminada';
            return redirect('/specialties')->with(compact('notification'));

     }
}

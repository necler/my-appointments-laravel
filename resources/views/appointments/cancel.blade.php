@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Cancelar cita</h3>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if(session('notification'))
        <div class="alert alert-success" role="alert">
            {{session('notification')}}
        </div>
        @endif
        @if($role == 'admin')
            <p>Estas a punto de cancelar la cita reservada por el paciente {{$appointment->patient->name}} para el médico {{$appointment->doctor->name}} (especialidad {{$appointment->specialty->name}}) para el día: {{$appointment->scheduled_date}}</p>
        @elseif($role == 'doctor')
            <p>Estas a punto de cancelar la cita para el paciente {{$appointment->patient->name}} para el día: {{$appointment->scheduled_date}}</p>
        @elseif($role == 'patient')
            <p>Estas a punto de cancelar tu cita con el médico {{$appointment->doctor->name}} (especialidad {{$appointment->specialty->name}}) para el día: {{$appointment->scheduled_date}}</p>
        @endif
            <form action="{{url('/appointments/'.$appointment->id.'/cancel')}}" method="POST">
            {{csrf_field()}}
            <div class="form-group">
                <label for="justification">Por favor, cuéntanos el motivo de la cancelación</label>
                <textarea required name="justification" rows="3" class="form-control"></textarea>
            </div>
            <button class="btn btn-danger" type="submit">Cancelar cita</button>
            <a href="{{url('/appointments')}}" class="btn btn-default">Volver al listado sin cancelar</a>
        </form>

    </div>
</div>
@endsection
@section('scripts')

<script src="{{asset('/vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
@endsection


@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
            <h3 class="mb-0">Cita #{{$appointment->id}}</h3>
            </div>
        </div>
    </div>
    <div class="card-body">
        <ul>
            <li>
                <strong>Fecha:</strong> {{$appointment->scheduled_date}}
            </li>
            <li>
                <strong>Hora:</strong> {{$appointment->scheduled_time_12}}
            </li>
            @if($role=='patient' || $role=='admin')
                <li>
                    <strong>Médico:</strong> {{$appointment->doctor->name}}
                </li>
            @endif
            @if($role=='doctor'|| $role=='admin')
                <li>
                    <strong>Paciente:</strong> {{$appointment->patient->name}}
                </li>
            @endif
            <li>
                <strong>Especialidad:</strong> {{$appointment->specialty->name}}
            </li>
            <li>
                <strong>Tipo:</strong> {{$appointment->type}}
            </li>
            <li>
                <strong>Estado:</strong>
                @if ($appointment->status == 'Cancelada')
                    <span class="badge badge-danger">Cancelada</span>
                @else
                    <span class="badge badge-succes">{{$appointment->status}}</span>
                @endif
            </li>
        </ul>
        @if ($appointment->status == 'Cancelada')
            <div class="alert alert-warning">
                <p>Acerca de la cancelación:</p>
                <ul>
                    @if($appointment->cancellation)
                    <li>
                        <strong>Fecha de la cancelación:</strong> {{$appointment->cancellation->created_at}}
                    </li>
                    <li>
                        <strong>Cancelada por:</strong> {{$appointment->cancellation->cancelled_by->name}}
                    </li>
                    <li>
                        <strong>Motivo de la cancelación:</strong> {{$appointment->cancellation->justification}}
                    </li>

                    @else
                    <li>
                        <strong>Cancelada antes de su confirmación</strong>
                    </li>
                    @endif
                </ul>
            </div>
        @endif
        <td>
            @if( $role == 'admin' && $appointment->status == 'Reservada')
                <form action="{{url('/appointments/'.$appointment->id.'/confirm')}}" method="POST" class="d-inline-block">
                    {{csrf_field()}}
                    <button class="btn btn-sm btn-success" type="submit" title="Confirmar cita">Confirmar</button>
                </form>
            @endif
        </td>
        <td>
            <a class="btn btn-sm btn-primary" title="Volver" href="{{url('/appointments')}}" class="d-inline-block">Volver</a>
        </td>
    </div>
</div>
@endsection
@section('scripts')

<script src="{{asset('/vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
@endsection


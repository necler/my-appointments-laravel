<div class="table-responsive">
    <!-- Projects table -->
    <table class="table align-items-center table-flush">
        <thead class="thead-light">
            <tr>
            <th scope="col">Descripción</th>
            <th scope="col">Especialidad</th>
            @if($role == 'patient' || $role == 'admin' )
                <th scope="col">Médico</th>
            @elseif($role == 'doctor'|| $role == 'admin' )
                <th scope="col">Paciente</th>
            @endif
            <th scope="col">Fecha</th>
            <th scope="col">Hora</th>
            <th scope="col">Tipo</th>
            <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendingAppointments as $pendingAppointment)
            <tr>
            <th scope="row">
            {{ $pendingAppointment->description}}
            </th>
            <td>
                {{$pendingAppointment->specialty->name}}
            </td>
            @if($role == 'patient'|| $role == 'admin')
            <td>
                {{$pendingAppointment->doctor->name}}
            </td>
            @elseif($role == 'doctor' || $role == 'admin')
            <td>
                {{$pendingAppointment->patient->name}}
            </td>
            @endif
            <td>
                {{$pendingAppointment->scheduled_date}}
            </td>
            <td>
                {{$pendingAppointment->scheduled_time_12}}
            </td>
            <td>
                {{$pendingAppointment->type}}
            </td>
            <td>
                @if($role == 'admin')
                    <a class="btn btn-sm btn-primary" title="Ver cita" href="{{url('/appointments/'.$pendingAppointment->id)}}">Ver</a>
                @endif
                @if($role=='doctor' || $role == 'admin')
                    <form action="{{url('/appointments/'.$pendingAppointment->id.'/confirm')}}" method="POST" class="d-inline-block">
                        {{csrf_field()}}
                        <button class="btn btn-sm btn-success" type="submit" data-toggle="tooltip" title="Confirmar cita"><i class="ni ni-check-bold"></i></button>
                    </form>
                    <a class="btn btn-sm btn-danger" title="Cancelar cita" href="{{url('/appointments/'.$pendingAppointment->id.'/cancel')}}" data-toggle="tooltip"><i class="ni ni-fat-delete"></i></a>
                @else
                <form action="{{url('/appointments/'.$pendingAppointment->id.'/cancel')}}" method="POST" class="d-inline-block">
                    {{csrf_field()}}
                    <button class="btn btn-sm btn-danger" type="submit" data-toggle="tooltip" title="Cancelar cita"><i class="ni ni-fat-delete"></i></button>
                </form>
                @endif
            </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="card-body">
    {{$pendingAppointments->links()}}
</div>

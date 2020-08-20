<div class="table-responsive">
    <!-- Projects table -->
    <table class="table align-items-center table-flush">
        <thead class="thead-light">
            <tr>
            <th scope="col">Descripción</th>
            <th scope="col">Especialidad</th>
            @if($role == 'patient')
                <th scope="col">Médico</th>
            @elseif($role == 'doctor')
                <th scope="col">Paciente</th>
            @endif
            <th scope="col">Fecha</th>
            <th scope="col">Hora</th>
            <th scope="col">Tipo</th>
            <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($confirmedAppointments as $confirmedAppointment)
            <tr>
            <th scope="row">
            {{ $confirmedAppointment->description}}
            </th>
            <td>
                {{$confirmedAppointment->specialty->name}}
            </td>
            @if($role == 'patient')
            <td>
                {{$confirmedAppointment->doctor->name}}
            </td>
            @elseif($role == 'doctor')
            <td>
                {{$confirmedAppointment->patient->name}}
            </td>
            @endif
            <td>
                {{$confirmedAppointment->scheduled_date}}
            </td>
            <td>
                {{$confirmedAppointment->scheduled_time_12}}
            </td>
            <td>
                {{$confirmedAppointment->type}}
            </td>
            <td>
                @if($role == 'admin')
                    <a class="btn btn-sm btn-primary" title="Ver cita" href="{{url('/appointments/'.$confirmedAppointment->id)}}" >Ver</a>
                @endif
                <a class="btn btn-sm btn-danger" title="Cancelar cita" href="{{url('/appointments/'.$confirmedAppointment->id.'/cancel')}}">Cancelar</a>
            </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="card-body">
    {{$confirmedAppointments->links()}}
</div>

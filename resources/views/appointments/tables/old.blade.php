<div class="table-responsive">
    <!-- Projects table -->
    <table class="table align-items-center table-flush">
        <thead class="thead-light">
            <tr>
            <th scope="col">Especialidad</th>
            <th scope="col">Fecha</th>
            <th scope="col">Hora</th>
            <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($oldAppointments as $oldAppointment)
            <tr>
            <th scope="row">
                {{$oldAppointment->specialty->name}}
            </td>
            <td>
                {{$oldAppointment->scheduled_date}}
            </td>
            <td>
                {{$oldAppointment->scheduled_time_12}}
            </td>
            <td>
                {{$oldAppointment->status}}
            </td>
            <td>
                <a class="btn btn-sm btn-primary" title="Ver cita" href="{{url('/appointments/'.$oldAppointment->id)}}">Ver</a>
            </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="card-body">
    {{$pendingAppointments->links()}}
</div>

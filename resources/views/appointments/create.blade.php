@extends('layouts.panel')

@section('content')
<div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Reserva de citas</h3>
                </div>
                <div class="col text-right">
                    <a href="{{url('patients')}}" class="btn btn-sm btn-default">Cancelar y volver</a>
                </div>
            </div>
        </div>
       <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{url('appointments')}}" method="POST">
            {{csrf_field()}}
                    <div class="form-group">
                       <label for="description">Descripción</label>
                       <input name="description" type="text" id="description" value="{{old('description')}}" placeholder="Describe brevemente la consulta" class="form-control" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="specialty">Especialidad</label>
                            <select name="specialty_id" id="specialty" class="form-control" required>
                             <option value="">Seleccionar Especialidad</option>
                             @foreach ($specialties as $specialty)
                                <option value="{{$specialty->id}}" @if(old('specialty_id')==$specialty->id)selected @endif>{{$specialty->name}}</option>
                             @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="doctor">Médico</label>
                            <select name="doctor_id" id="doctor" class="form-control" required>
                                @foreach ($doctors as $doctor)
                                    <option value="{{$doctor->id}}" @if(old('doctor_id')==$doctor->id)selected @endif>{{$doctor->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="scheduled_date">Fecha</label>
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                            </div>
                        <input type="text" name="scheduled_date" id="date" placeholder="Selecciona una fecha" class="form-control datepicker" value="{{old('scheduled_date',date('Y-m-d'))}}" data-date-format="yyyy-mm-dd" data-date-start-date="" data-date-end-date="+30d">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="scheduled_time">Hora de atención</label>
                        <div id="hours">
                            @if($intervals)
                                @foreach ($intervals['morning'] as $key => $interval)
                                <div class="custom-control custom-radio mb-3">
                                    <input name="scheduled_time" value="{{$interval['start']}}" class="custom-control-input" id="intervalMorning{{$key}}" type="radio" required>
                                    <label class="custom-control-label" for="intervalMorning{{$key}}">{{$interval['start']}} - {{$interval['end']}}</label>
                                </div>
                                @endforeach
                                @foreach ($intervals['afternoon'] as $key => $interval)
                                <div class="custom-control custom-radio mb-3">
                                    <input name="scheduled_time" value="{{$interval['start']}}" class="custom-control-input" id="intervalAfternoon{{$key}}" type="radio" required>
                                    <label class="custom-control-label" for="intervalAfternoon{{$key}}">{{$interval['start']}} - {{$interval['end']}}</label>
                                </div>
                                @endforeach
                            @else
                            <div class="alert alert-info" role="alert">
                                Selecciona un médico y una fecha, para ver sus horas disponibles.
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type">Tipo de consulta</label>
                        <div class="custom-control custom-radio mb-3">
                            <input type="radio" name="type" value="Consulta" class="custom-control-input" id="type1"
                            @if(old('type','Consulta')=='Consulta') checked @endif>
                            <label class="custom-control-label" for="type1">Consulta</label>
                        </div>
                        <div class="custom-control custom-radio mb-3">
                            <input type="radio" name="type" value="Examen" class="custom-control-input" id="type2"
                            @if(old('type')=='Examen') checked @endif>
                            <label class="custom-control-label" for="type2">Examen</label>
                        </div>
                        <div class="custom-control custom-radio mb-3">
                            <input type="radio" name="type" value="Operacion" class="custom-control-input" id="type3"
                            @if(old('type')=='Operacion') checked @endif>
                            <label class="custom-control-label" for="type3">Operación</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
       </div>
</div>
@endsection
@section('scripts')

<script src="{{asset('/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

<script src="{{asset('/js/appointments/create.js')}}"></script>

@endsection



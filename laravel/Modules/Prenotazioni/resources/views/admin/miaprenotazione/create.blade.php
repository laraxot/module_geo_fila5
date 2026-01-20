nds('adm_theme::layouts.app')
@section('page_heading','Aggiungi Prenotazione')

@section('section')
<x-filament::badge> flash-message </x-filament::badge>


<h3>Prenotazione per il giorno {{ Carbon\Carbon::parse($params['giorno'])->formatLocalized('%A %d/%m/%Y') }} </h3>

{!! Form::bsOpen($row,'store') !!}

{{-- Form::bsText('giorno',$params['date']) --}}
<input type="hidden" name="giorno" value="{{ $params['giorno'] }}" />
<input type="hidden" name="id_tipo" value="{{ $params['id_tipo'] }}" />
{{ Form::bsTextarea('note') }}
{{-- Form::bsSelect('giust',null,$row->giust_opts()) --}}

{{Form::submit('Salva ed esci !!',['class'=>'submit btn btn-success green-meadow'])}}
{!! Form::close() !!}

@endsection



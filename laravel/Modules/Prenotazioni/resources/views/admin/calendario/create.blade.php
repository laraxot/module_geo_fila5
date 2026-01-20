nds('adm_theme::layouts.app')
@section('page_heading','Aggiungi Data Prenotazione')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>


{!! Form::bsOpen($row,'store') !!}

{{ Form::bsFlatDatetime('giorno_start') }}
{{ Form::bsFlatDatetime('giorno_end') }}

{{ Form::bsText('id_tipo') }}
{{ Form::bsInteger('max_utenti') }}
{{ Form::bsTextarea('note') }}
{{-- Form::bsSelect('giust',null,$row->giust_opts()) --}}

{{Form::bsSubmit('Salva ed esci !!')}}
{!! Form::close() !!}

@endsection

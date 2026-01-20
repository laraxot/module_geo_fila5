nds('adm_theme::layouts.app')
@section('page_heading','Bagde')
@section('content')
<x-filament::badge> flash-message </x-filament::badge>


{!! Form::bsOpen($row, 'update') !!}

{{ Form::bsText('ente') }}
{{ Form::bsText('matr') }}

{{ Form::bsText('cognome') }}
{{ Form::bsText('nome') }}
{{--
{{ Form::bsBoolean('is_regional') }}
--}}
{{ Form::bsInteger('n_diritto') }}
{{ Form::bsInteger('n_mensa') }}
{{ Form::bsInteger('n_dati') }}
{{ Form::bsInteger('n_resi') }}

{{ Form::bsDateTime('giorno') }}

{{ Form::bsSubmit('Salva') }}
{{ Form::close() }}


@endsection

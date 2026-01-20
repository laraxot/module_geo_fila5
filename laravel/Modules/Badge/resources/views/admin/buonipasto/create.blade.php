nds('adm_theme::layouts.app')
@section('page_heading','Bagde')
@section('content')
<x-filament::badge> flash-message </x-filament::badge>


{!! Form::bsOpen($row, 'store') !!}

{{ Form::bsText('ente') }}
{{ Form::bsText('matr') }}

{{ Form::bsText('cognome') }}
{{ Form::bsText('nome') }}


{{--
{{ Form::bsBoolean('is_regional') }}
--}}
{{ Form::bsInteger('n_dati') }}
{{ Form::bsInteger('n_resi') }}

{{ Form::bsDateTime('giorno') }}

{{ Form::hidden('n_diritto') }}
{{ Form::hidden('n_mensa') }}
{{ Form::hidden('propro') }}
{{ Form::hidden('posfun') }}
{{ Form::hidden('posiz') }}
{{ Form::hidden('disci1') }}

{{ Form::hidden('categoria_eco') }}
{{ Form::hidden('stabi') }}
{{ Form::hidden('stabi_txt') }}
{{ Form::hidden('repar') }}
{{ Form::hidden('repar_txt') }}


{{ Form::bsSubmit('Salva') }}
{{ Form::close() }}


@endsection

nds('adm_theme::layouts.app')
@section('page_heading','cerca')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>

<pre>{{ $caption }}</pre>
{{ Form::open(['route' => $routename]) }}
{{ method_field('POST') }}
{!! csrf_field() !!}
{{ Form::bsText('ente',$row->ente) }}
{{ Form::bsText('turno',$row->turno) }}
{{ Form::bsDate('data_elab') }}
{{ Form::bsSubmit('vai') }}
{!! Form::close() !!}
@endsection

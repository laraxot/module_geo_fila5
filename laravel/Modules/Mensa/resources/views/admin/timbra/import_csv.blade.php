nds('adm_theme::layouts.app')
@section('page_heading','import csv')
@section('content')
<x-filament::badge> flash-message </x-filament::badge>

@php
	$routename=Request::route()->getName();
@endphp
{{--
{{ Form::open(['route' => $routename]) }}
--}}
{!! Form::bsOpen($row,'update') !!}
{{ Form::bsText('test') }}
{{--
{{ Form::bsUploadCsv('file_csv') }}
  Chunk
--}}
{{ Form::bsSubmit('vai') }}
{!! Form::close() !!}
@endsection

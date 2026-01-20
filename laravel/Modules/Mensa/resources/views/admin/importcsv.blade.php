nds('adm_theme::layouts.app')
@section('page_heading','import csv')
@section('content')
<x-filament::badge> flash-message </x-filament::badge>

@php
	$routename=Request::route()->getName();
@endphp

{{ Form::open(['route' => $routename]) }}
{{ method_field('POST') }}
{!! csrf_field() !!}
{{ Form::bsChunkUploadCsv('file_csv') }}
{{ Form::bsSubmit('vai') }}
{!! Form::close() !!}
@endsection

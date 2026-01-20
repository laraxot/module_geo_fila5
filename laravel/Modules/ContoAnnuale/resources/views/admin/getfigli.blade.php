nds('adm_theme::layouts.app')
@section('page_heading','cerca')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>

<?php
$routename = Request::route()->getName();
?>
<h2>aggiornare tabella MATER0f , IRP21L1 , ana10f , sto00f</h2>
{{-- $routename --}}
{{ Form::open(['route' => $routename]) }}

{{ method_field('POST') }}
{!! csrf_field() !!}
{{-- Form::bsText('ente',$row->ente) --}}
{{ Form::bsText('ente',$row->ente) }}
{{ Form::bsText('min_eta') }}
{{ Form::bsText('max_eta') }}
{{ Form::bsDate('data') }}

{{ Form::bsSubmit('vai') }}
{!! Form::close() !!}
@endsection

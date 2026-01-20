nds('adm_theme::layouts.app')
@section('page_heading','Mie Prenotazioni')
@section('section')
<x-filament::badge> flash-message </x-filament::badge>

{{--  Form::bsBtnCreate() --}}

<table class="table table-striped table-bordered">
@foreach($rows as $row)
<tr>
<td>{{ $row->id }}<br/>
{{ $row->ente }}-{{ $row->matr }}
</td>

<td>{{ $row->giorno }}</td>
<td>{{ $row->_id_tipo['nome'] }}</td>

<td>{{ $row->note }}</td>
</tr>
@endforeach
</table>
{{-- $rows->links() --}}
@endsection

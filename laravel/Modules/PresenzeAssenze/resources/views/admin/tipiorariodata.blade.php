nds('adm_theme::layouts.app')
@section('page_heading','Presenze Assenze')
@section('content')
<x-filament::badge> flash-message </x-filament::badge>

<a href="?xls" class="btn btn-default"><i class="fa fa-file-excel-o"></i></a>
<table class="table">
	@foreach($rows->get() as $k=>$row)
		<tr>
			<td>{{ $k+1 }}</td>
			<td>{{ $row->matr }}</td>
			<td>{{ $row->cognome }}</td>
			<td>{{ $row->nome }}</td>
			<td>{{ $row->dtturn }}</td>
			<td>{{ $row->dtdal }}</td>
			<td>{{ $row->dtal }}</td>
		</tr>
	@endforeach
</table>

@endsection

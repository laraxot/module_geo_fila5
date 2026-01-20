nds('adm_theme::layouts.app')
@section('page_heading','Mensa ')
@section('content')
<x-filament::badge> flash-message </x-filament::badge>


<table class="table">
	<tr>
		<th>Lavoratore</th>
		<th>Data</th>
		<th>Mensa</th>
		<th>Timbrature</th>
	</tr>
@foreach($rows->get()->where('valida',false) as $row)
	<tr>
		<td>{{ $row->enteap }}-{{ $row->mnmatr }}<br/>
			{{ $row->mncogn }} {{ $row->mnnome }}<br/>
			Badge:{{ $row->mnbadg }}
		</td>
		<td>{{ $row->mndata->format('d/m/Y') }}</td>
		<td>{{ $row->mnorat->format('H:i') }} <br/>
			Durata: {{ $row->durata }}<br/>
			Valida: @if($row->valida) SI @else <h3 style="color:red">NO </h3>{{ $row->motivo }} @endif
		</td>
		<td>

			@include($view.'.timbr',['timbrs'=>$row->wstr01lx])
			<b>Durata : {{ floor($row->durataGiornata/60) }}:{{ $row->durataGiornata%60 }} </b>

		</td>
	</tr>
@endforeach
</table>

@endsection

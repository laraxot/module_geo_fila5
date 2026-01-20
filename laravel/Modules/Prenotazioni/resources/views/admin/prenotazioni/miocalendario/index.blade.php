nds('adm_theme::layouts.app')
@section('page_heading','Calendario Prenotazioni ')
@section('section')

@foreach($rows as $row)
	@php
		$curr=Carbon\Carbon::parse($row->giorno_start);
		$end=Carbon\Carbon::parse($row->giorno_end);
		//setlocale(LC_TIME, 'It');
	@endphp
	<table class="table table-striped table-bordered" style="width:33%;">
	<caption><h3>{{ $curr->formatLocalized('%A %d/%m/%Y') }} {{ $row->_tipo['nome'] }}</h3></caption>
	<thead>
		<tr>
			<td>Orario</td>
			<td>Posti Liberi</td>
			<td></td>
		</tr>
	</thead>
	@while($curr<$end)
		@php
			$posti_liberi=$row->posti_liberi($curr);
		@endphp
		<tr>
			<td>{{ $curr->formatLocalized('%H:%M') }}</td>
			<td>{{ $posti_liberi }}</td>
			<td>
			@if($posti_liberi>0)
				<a class="btn btn-small btn-info"  data-toggle="tooltip" title="prenota la data" href="{{
					route('prenotazioni.miaprenotazione.create',['giorno'=>$curr,'id_tipo'=>$row->id_tipo] ) }}">
				<i class="fa fa-clock-o fa-fw" aria-hidden="true"></i>&nbsp;</a>
			@endif
			</td>
			</tr>

		@php
			$curr->addMinutes($row->_tipo['delta']);
		@endphp

	@endwhile
	</table>

@endforeach

@endsection

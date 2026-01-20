nds('adm_theme::layouts.app')
@section('content')
<table class="table table-striped table-bordered">
@php
	$mese='';
	$dirittopasto=0;
	$timbrmensa=0;
@endphp
@foreach($rows/*->with(['wstr01lx'])*/->get() as $row)
@php
	$mesecurr=$row->stdata->formatLocalized('%B %Y');
	$params['mese']=$row->stdata->month;
	$params['anno']=$row->stdata->year;
@endphp
@if($mese!=$mesecurr)
	<tr><th colspan="2"><h2>{{ $mesecurr }}</h2>@include('ptv::headers.worker',['anag'=>$row->anag,'params'=>$params])</th></tr>
@php
	$mese=$mesecurr;
@endphp
@endif
<tr>
	<td>{{ $row->stdata->day }} {{ $row->stdata->formatLocalized('%A') }}</td>
	<td>@include($view.'.timbr',['timbr'=>$row->wstr01lx])

		<b>Durata:</b>&nbsp;{{ floor($row->durata/60) }}:{{ floor($row->durata%60) }}<br/>
		<b>Pause:</b>&nbsp;{{ count($row->pause) }}<br/>
		<b>Pausa min:</b>&nbsp;{{ $row->pause->min('durata') }}<br/>
		<b>Pausa max:</b>&nbsp;{{ $row->pause->max('durata') }}<br/>
		<b>durata pomeriggio:</b>&nbsp;{{ $row->durata_pomeriggio }} min {{ floor($row->durata_pomeriggio/60) }}:{{ $row->durata_pomeriggio%60 }} HH:mm [Lavoro dopo la prima pausa dim alemno 30 min]<br/>
		@include($view.'.timbrmensa',['timbr'=>$row->wmen00f])

		<b>Diritto buono pasto : </b>&nbsp;@if($row->diritto_buonopasto)<span style="color:green;font-size:15pt;">SI</span> @else NO @endif
		@php
			$timbrmensa+=$row->wmen00f->count();
			if($row->diritto_buonopasto){
				$dirittopasto++;
			}
		@endphp

	</td>

</tr>
@endforeach
</table>
<h3>Diritto buoni pasto : {{ $dirittopasto }} </h3>
<h3>timbrature pasto : {{ $timbrmensa }} </h3>
@endsection
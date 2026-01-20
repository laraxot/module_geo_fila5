e>
	td{
		border-bottom:1px solid darkgray;
		border-right:1px solid darkgray;
	}
</style>

@php
	$mese='';
@endphp
@foreach($rows as $k=>$el)
@php
	$mesecurr=strftime("%B %Y",strtotime($k));
@endphp

@if($mese!=$mesecurr)
	@if($mese!="")</table>@endif
	<h3>{{  $mesecurr }}</h3>
	<table>
@php
 $mese=$mesecurr;
@endphp
@endif
<tr>
<td>{!!  strftime("%d<br/>%a",strtotime($k)) !!}</td>
<td>

<table class="table table-striped table-bordered ">
@foreach($el->wstr02f as $el1)
	<tr><th>Turno</th><td>{{ $el1->w2turn }}</td></tr>
	<tr><th>Orario</th><td>{{ $el1->w2orar }}</td></tr>
@endforeach
</table>
</td>

<td>
@if(count($el->wstr01lx)>0)
	<table class="table table-striped table-bordered " >
	<tr><th style="width:50px;">Ora</th>
	@foreach($el->wstr01lx as $el1)
	<td>{{  substr($el1->wtorat,0,-2) }} :{{ substr($el1->wtorat,-2) }}</td>
	@endforeach
	</tr>
	<tr><th>Verso</th>
	@foreach($el->wstr01lx as $el1)
		<td>@if($el1->wtsens=='1')E @else U @endif </td>
	@endforeach
	</tr>
	<tr><th>Edificio</th>
	@foreach($el->wstr01lx as $el1)
		<td>{{ $el1->wtindi }}</td>
	@endforeach
	</tr>
	</table>
	<b>Durata: </b>{{  $el->durata['hi'] }}
	<br/><b> Pause: </b>{{  count($el->pause) }}
	@if(count($el->pause)>0 )

		@if(isset($el->pausaMax->durata['min']))
			<br/><b>Pausa max: </b>{{ $el->pausaMax->durata['min'] }}
		@else
		 <br/> Sistemare timbrature
		@endif

	@endif
@endif

@if(count($el->wmen00f)>0)
	<br/><b>buono mensa:</b>
	@foreach($el->wmen00f as $el1)
		{{ substr($el1->mnorat,0,-2) }}:{{ substr($el1->mnorat,-2) }}<br/>
	@endforeach
	<b>pausa mensa: </b>
	@foreach($el->pausaMensa as $el1)
		{{ $el1->durata['min'] }}
	@endforeach
@endif

<span style="color:red">
@foreach($el->err as $el1)
<br>{{ $el1}}
@endforeach
</span>

</td>





<td>
@if(count($el->mov01k2)>0)
<table>
<tr><th>tipo-cod</th><th>min</th><th>ore.min</th><th>U</th><th>inizio</th><th>fine</th></tr>
@foreach($el->mov01k2 as $el1)
	<tr><td>{{ $el1->mo1tip}}-{{$el1->mo1cod}}<br/>
	@php
		$kcod=$el1->mo1tip.'-'.$el1->mo1cod;
	@endphp
	{{ $cod[$kcod][0]->desc }}
	</td><td>{{ $el1->mo1qta}}</td><td>{{ $el1->mo1qtv }}</td><td>{{$el1->mo1um}}</td>
	<td>{{ $el1->mo1oi}}</td><td>{{$el1->mo1of}}</td></tr>
@endforeach
</table>
@endif
</td>

</tr>
@endforeach
</table>

<hr/>
<h3>Riepilogo Giustificativi</h3>
<table>
<tr><th>tipo-cod</th><th>U</th><th>min</th></tr>
@foreach($tot_ass as $el1)
<tr><td>{{  $el1->mo1tip }}-{{  $el1->mo1cod}}
@php
$kcod=$el1->mo1tip.'-'.$el1->mo1cod;
@endphp
{{$cod[$kcod][0]->desc}}
</td>
<td>
{{ $el1->mo1um}}
</td>
<td>
{{$el1->mo1qta}}
</td>

@endforeach
</table>
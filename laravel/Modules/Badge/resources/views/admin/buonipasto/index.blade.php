nds('adm_theme::layouts.app')
@section('page_heading','Bagde')
@section('content')
<x-filament::badge> flash-message </x-filament::badge>

{!! Form::bsMonthYearNav(['routename'=>'badge.mese_anno.buonipasto.index']) !!}
{!! Form::bsFormSearch() !!}
{!!  Form::bsBtnCreate() !!}
@php
	if(!isset($params['mese'])) $params['mese']=date('m');
	if(!isset($params['anno'])) $params['anno']=date('Y');
@endphp
<a href="{{ route('badge.mese_anno.buonipasto.xls',$params) }}" class="btn btn-default">
	<i class="fa fa-file-excel-o"></i>
</a>
<a href="?recalculate" class="btn btn-default">
	<i class="fa fa-refresh"></i> Ricalcola
</a>
<small>tabelle da aggiornare [Ana10f,Rep00f,Tqu00f,Qua00f,Wmen00f(mensa),Wstr02f(giorni),Repart,Wstr01lx(timbr)]</small>
<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Lavoratore</th>
			<th>n diritto tot</th>
			<th>n usati in mensa tot</th>
			<th>n dati tot</th>
			<th>n resi tot</th>
			<th>n dati</th>
			<th>n resi</th>
			<th>giorno</th>
			<th>Aggiornato al</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	@foreach($rows as $row)
	<tr>
		<td>{{ $row->id }}</td>
		@php
			$parz=$params;
			//$parz['entematr']=$row->ente.'-'.$row->matr;
			$parz['ente']=$row->ente;
			$parz['matr']=$row->matr;
			$route=route('badge.ente_matr.buonipasto.index',$parz);
		@endphp
		<td><a href="{{ $route }}" class="btn btn-default">{{ $row->ente }}-{{ $row->matr }}] {{ $row->cognome }} {{ $row->nome }}</a><br/>
			{{ $row->propro }}-{{ $row->posfun }}] {{ $row->categoria_eco }}<br/>
			{{ $row->stabi }}] {{ $row->stabi_txt }}<br/>
			{{ $row->repar }}] {{ $row->repar_txt }}<br/>
			disci: {{ $row->disci1 }}<br/>
			{{--  @if($row->disci1==203) --}}
			@if($row->is_regionale)
			<span class="darkgreen">REGIONALE</span>
			@endif
		</td>
		<td align="right">{{ $row->n_diritto }} <br/>

		</td>
		<td align="right">{{ $row->n_mensa }}</td>
		<td align="right">{{ $row->n_dati_tot }}</td>
		<td align="right">{{ $row->n_resi_tot }}</td>
		<td align="right">{{ $row->n_dati }}</td>
		<td align="right">{{ $row->n_resi }}</td>
		<td align="right">{{ $row->giorno }}
			{{-- $row->giorno --}}
		</td>
		<td align="right">
			giorni : @if($row->updated_wstr02f_at){{ $row->updated_wstr02f_at->format('d/m/Y') }}@endif<br/>
			mensa : @if($row->updated_wmen00f_at){{ $row->updated_wmen00f_at->format('d/m/Y') }}@endif<br/>
			timbr : @if($row->updated_wstr01lx_at){{ $row->updated_wstr01lx_at->format('d/m/Y') }}@endif<br/>
		</td>
		<td>
			{!! Form::bsBtnCrud(['id_buonipasto'=>$row->id]) !!}
			@php
				$parz=['ente'=>$row->ente,'matr'=>$row->matr,'mese'=>$row->mese,'anno'=>$row->anno];
				$route=route('badge.ente_matr_mese_anno_timbr',$parz);
			@endphp
			<a href="{{ $route }}" class="btn btn-default"><i class="fa fa-calendar"></i></a>
		</td>
	</tr>
	@endforeach
	</tbody>
</table>

--{!! $rows->links() !!}--
@endsection

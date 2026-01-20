e>
	<tr>
	<th>Ora</th>
		@foreach($timbrs as $timbr)
		<td>{{ $timbr->wtorat->format('H:i') }}</td>
		@endforeach
	</tr>
	{{--
	<tr>
	@foreach($row->wstr01lx as $timbr)
		<td>{{ $timbr->t1codi }}</td>
	@endforeach
	</tr>
	<tr>
	@foreach($row->wstr01lx as $timbr)
		<td>{{ $timbr->orcodi }}</td>
	@endforeach
	</tr>
	--}}
	<tr>
		<th>Verso</th>
		@foreach($timbrs as $timbr)
		<td>
			@if($timbr->wtsens==1) E @endif
			@if($timbr->wtsens==2) U @endif
		</td>
		@endforeach
	</tr>
	<tr>
		<th>Edificio</th>
		@foreach($timbrs as $timbr)
		<td>{{$timbr->wtindi}}</td>
		@endforeach
	</tr>


</table>
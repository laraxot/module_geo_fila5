e class="table table-striped table-bordered">
	<tr>
		<th>Ora</th>
		@foreach($timbr as $row)
		<td>{{ $row->wtorat->format('H:i') }}</td>
		@endforeach
	</tr>
	<tr>
		<th>Verso</th>
		@foreach($timbr as $row)
		<td>
			@if($row->wtsens==1) E @endif
			@if($row->wtsens==2) U @endif
		</td>
		@endforeach
	</tr>
	<tr>
		<th>Edificio</th>
		@foreach($timbr as $row)
		<td>{{$row->wtindi}}</td>
		@endforeach
	</tr>
</table>



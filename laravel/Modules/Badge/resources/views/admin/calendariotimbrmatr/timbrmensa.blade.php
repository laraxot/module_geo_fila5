e class="table table-striped table-bordered">
	<tr>
		@foreach($timbr as $row)
		<th>Timbr Mensa</th><td>{{$row->mnorat->hour}}:{{$row->mnorat->minute}}</td>
		@if($row->mensa_start==null)
		<th colspan="2" style="color:red">Manca Timbratura prima della mensa !</th>
		@else
		<th>start :</th><td> {{ $row->mensa_start->format('H:i') }}</td>
		@endif
		@if($row->mensa_end==null)
		<th colspan="2" style="color:red">Manca Timbratura dopo della mensa !</th>
		@else
		<th>end :</th><td> {{ $row->mensa_end->format('H:i') }}</td>
		@endif
		<th>durata :</th><td>{{ $row->durata }}</td>
		@endforeach
	</tr>
</table>
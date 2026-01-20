nds('adm_theme::layouts.app')
@section('page_heading','Sindacati')
@section('content')
<x-filament::badge> flash-message </x-filament::badge>


<h1>Benvenuto nel programma Sindacati</h1>
@userLevel(3)
	livello >=3
@else
	livello <3
@endif
@endsection

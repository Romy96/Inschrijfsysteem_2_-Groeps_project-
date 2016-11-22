@extends('layout')

@section('content')

	<h1>Evenementen</h1>

	@foreach ( $events as $row ) 
	<div>
	    <div class='img' style='background-image:url({{$row['small_banner_url']}})'>
			<div class='img2'>
			    <p class='data_info'>{{$row['title']}}</p> 
			    <p class='data_info'>{{$row['start_date']}}</p>
			   	<p class='data_info'>{{$row['end_date']}}</p> 
		    </div>
	    </div>
    </div>	
	@endforeach
	

@endsection
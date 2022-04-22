@extends('layouts.frontTemplate')
@section('content')

<CENTER>
	    <div class="error-page">
	        <h2 class="headline text-info"> 500 </h2>
	        <div class="error-content">
	            <h3><i class="fa fa-warning text-yellow"></i> Oops!.</h3>
	            <p>
	                The server encountered an error and could not complete your request. <br>you may <a href="{{ url('/') }}">return to dashboard</a>
	            </p>
	        </div>
	    </div>
</CENTER>

@endsection 
@extends('layouts.frontTemplate')
@section('content')

<CENTER>
<div class="error-page">
    <h2 class="headline text-info"> 403</h2>
    <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> Oops! </h3>
        <p>
            We could not find the page you were looking for.
            Meanwhile, <br>you may <a href="{{ url('/') }}">return to dashboard</a> or try using the search form.
        </p>
    </div>
</div>	
</CENTER>
@endsection 
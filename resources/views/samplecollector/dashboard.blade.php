@extends('layouts.sampleCollectorTemplate')
@section('page-title','Dashboard')
@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <a href="{{url('admin/sample-collector-customers')}}">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="orange">
                            <i class="material-icons">weekend</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Users</p>
                            <h3 class="card-title">00</h3>
                        </div>
                    </div>
                </a>
            </div>
            <!-- <div class="col-lg-4 col-md-6 col-sm-6">
                <a href="{{url('admin/course')}}">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="rose">
                            <i class="material-icons">equalizer</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Courses</p>
                            <h3 class="card-title">{{$data['courses']}}</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <a href="#">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">store</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Groups</p>
                            <h3 class="card-title">00</h3>
                        </div>
                    </div>
                </a>
            </div> -->
        </div> 
		
		
    </div>
</div>
@endsection

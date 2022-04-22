@extends('layouts.frontTemplate')
@section('content') 
<!-- Main content Start -->
<div class="main-content">
        <!-- Breadcrumbs Section Start -->
        <div class="rs-breadcrumbs bg-6">
            <div class="container">
                <div class="content-part text-center pt-160 pb-160">
                    <h1 class="breadcrumbs-title white-color mb-0">Event Calendar</h1>
                </div>
            </div>
        </div>
        <!-- Breadcrumbs Section End -->

        <!-- Portfolio Section Start -->
        <div id="rs-portfolio" class="rs-portfolio inner3 pt-100 pb-70 md-pt-80 md-pb-50">
            <div class="container">
                <div class="row">
				
				@if(count($events)>0)
				@foreach($events as $evt)
                    <div class="col-lg-4 col-md-6 mb-30">
                        <div class="portfolio-item">
                            <div class="portfolio-img">
                                <img src="{{url('public/events/'.$evt->image)}}" alt="{{$evt->image}}">
                            </div>
                            <div class="portfolio-content">
                                <div class="portfolio-inner">
                                    <h4 class="title"><a href="{{url('event-details/'.base64_encode($evt->id))}}">{{$evt->title}}</a></h4>
                                    <a class="category" href="{{url('event-details/'.base64_encode($evt->id))}}"><i class="fa fa-calendar-check-o"></i> {{$evt->event_date}}</li></a>
                                </div>
                            </div>
                        </div>
                    </div>
					@endforeach
					@endif
					
                </div>
            </div>
        </div>
        <!-- Portfolio Section End -->
        </div> 
        <!-- Main content End -->
@endsection
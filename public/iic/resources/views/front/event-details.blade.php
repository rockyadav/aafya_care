@extends('layouts.frontTemplate')
@section('content') 
<!-- Main content Start -->
<div class="main-content">
    <!-- Breadcrumbs Section Start -->
    <div class="rs-breadcrumbs bg-6">
        <div class="container">
            <div class="content-part text-center pt-160 pb-160">
                <h1 class="breadcrumbs-title white-color mb-0">Event Details</h1>
            </div>
        </div>
    </div>
    <!-- Breadcrumbs Section End -->

    <!-- Portfolio Section Start -->
    <div id="rs-portfolio" class="rs-portfolio single pt-100 pb-70 md-pt-80 md-pb-50">
        <div class="container">
            <div class="row mb-39">
                <div class="col-lg-8 pr-55 md-pr-15">
                    <img class="mb-25" src="{{url('public/events/'.$events->image)}}" alt="">
                    <h2>{{$events->title}}</h2>
                    <p class="desc mb-29"><?php echo $events->description; ?></p>
                </div>
                <div class="col-lg-4 md-order-first md-mb-40">
                    <div class="project-sidebar">
                       <!-- <img class="hidden-md" src="{{url('public/events/'.$events->image)}}" alt="">-->
                        <div class="sb-project-detail mt-50 md-mt-0">
                            <h4 class="title">Event Details</h4>
                            <ul>
                                <li><span>Name:</span> {{$events->title}}</li>
                                <li><span>Date:</span> {{date("d-M-Y",strtotime($events->event_date))}}</li>
                                <!--<li><span>Location:</span>Usa</li> 
                                <li><span>Mananer:</span>Lorem Ipsum</li>-->

                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- Portfolio Section End -->
</div> 
<!-- Main content End -->
@endsection
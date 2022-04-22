@extends('layouts.adminTemplate')
@section('page-title', 'Contact Enquiry List')
@section('content') 

<style type="text/css">
.form-group input[type=file] {
    opacity: 1 !important;
    position: relative !important;
}
td {
    padding: 5px;
}
</style>
<div class="content">
<div class="container-fluid">

<div class="row">
 @include('layouts.error-sucess-messages')
<div class="col-md-12">
<div class="card">
    <div class="card-header card-header-icon" data-background-color="">
        <i class="material-icons">assignment</i>
    </div>    
    <div class="card-content">
        <h4 class="card-title">Contact Enquiry List</h4>
        <div class="row">
          <div class="col-md-12">
            <div class="material-datatables table-responsive">
             <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                      <th> S.No </th>
                      <th> Name </th>
                      <th> Number </th>
                      <th> Email Id </th>
                      <th> Category </th>
                      <th> Message </th>
                    </tr>
                </thead>
                
                <tbody>
                  @if(count($data['list'])>0)
                      @php
                      $i=0;
                      if(isset($_GET['page']))
                      {
                          if($_GET['page']>1)
                          {
                              $i = ($_GET['page']*25)-25;
                          }
                      }
                      @endphp
                    @foreach($data['list'] as $row)
                        <tr>
                            <td class="center">{{++$i}}</td>
                            <td class="center">{{$row->name}}</td>
                            <td class="center">{{$row->number}}</td>
                            <td class="center">
                            @if($row->email!='')
                              <a href="mailto:{{$row->email}}">{{$row->email}}</a>
                            @endif
                            </td>
                            <td class="center">{{$row->category}}</td>
                            <td class="center">{{$row->message}}</td>
                        </tr>
                    @endforeach
                @endif                
                </tbody>
            </table>
            <div class="text-center">
              {{$data['list']->links()}}
            </div>
        </div>
          </div>
        </div>
    </div>
    <!-- end content-->
</div>
<!--  end card  -->
</div>
<!-- end col-md-12 -->
</div>
<!-- end row -->
</div>
</div>
@endsection

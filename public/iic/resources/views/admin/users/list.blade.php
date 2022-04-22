@extends('layouts.adminTemplate')
@section('page-title', 'Users List')
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
        <h4 class="card-title">Users List</h4>
        <div class="row">
          <div class="col-md-12">
            <div class="material-datatables table-responsive">
             <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                      <th> S.No </th>
                      <th> Name </th>
                      <th> Mobile Number </th>
                      <th> Email Id </th>
                      <th> Login </th>
                      <th> Actions </th>
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
                            <td class="center">{{$row->mobile}}</td>
                            <td class="center">{{$row->email}}</td>
                            <td class="center">
                                @php 
                                  $login = '/vendors/login/'.$row->id;
                                @endphp
                                @if($row->isLogin==0)
                                 Disabled
                                 <br>
                                 <br>
                                 <a href="javascript:;" onclick="confirmPopup('You want to enabled login?','{{$login}}')" class="btn-sm btn-success">Enabled</a>
                                @else
                                 Enabled
                                 <br>
                                 <br>
                                 <a href="javascript:;" onclick="confirmPopup('You want to disabled login?','{{$login}}')" class="btn-sm btn-danger">Disabled</a>
                                @endif
                            </td>
                            <td class="center">
                                <a href="{{route('users.show',$row->id)}}" title="View Details"><span class="material-icons">remove_red_eye</span></a>
                                @php 
                                  $url = '/users/destroy/'.$row->id;
                                @endphp
                                <a href="javascript:;" onclick="confirmPopup('You want to delete this user?','{{$url}}')" class="remove"><span class="material-icons">delete</span></a>
                          </td>
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

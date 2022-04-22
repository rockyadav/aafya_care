@extends('layouts.adminTemplate')
@section('page-title', $data['title'])
@section('content')
<style type="text/css">
  input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
}

input[type=number] {
  -moz-appearance: textfield;
}
</style>
<div class="content">
  @if ($message = Session::get('success') || $message = Session::get('error'))
  @include('layouts.error-sucess-messages')
  @endif
  <div class="container-fluid"> 
    <div class="row">
      <div class="col-md-12">
        <div class="card"> 
          <div class="card-header card-header-icon" data-background-color="rose">
            <i class="material-icons">perm_identity</i> 
          </div>
          <div class="card-content">
        <h4 class="card-title">{{$data['title']}}</h4>
        <?php
          $fromdate = '';
          $todate   = '';
          if(isset($_GET['fromdate']))
          {
              $fromdate = $_GET['fromdate'];
          }

          if(isset($_GET['todate']))
          {
              $todate   = $_GET['todate'];
          }
        ?>
        <div class="row">
          <div class="col-md-offset-1 col-md-10">
            <form>
              <div class="col-md-4 form-group">
                <label class="control-label">From Date</label>
                <input type="date" name="fromdate" class="form-control" value="{{$fromdate}}">
              </div>
              <div class="col-md-4 form-group">
                <label class="control-label">To Date</label>
                <input type="date" name="todate" class="form-control" value="{{$todate}}">
              </div>
              <div class="col-md-4 form-group">
                <button type="submit" class="btn green btn-sm" style="margin-top: 30px;">Filter</button>
                <a href="{{url()->current()}}"><button type="button" class="btn green btn-sm" style=" margin-top: 30px;">Clear</button></a>
              </div>
            </form>
          </div>
        </div>
        @php
        $page = Request::segment(2);
        @endphp
        <div class="row">
          <div class="col-md-12">
            <div class="btn-group pull-right">
              <a href="{{url('report-download/'.$page.'?fromdate='.$fromdate.'&todate='.$todate)}}"><button data-toggle="modal" data-target="#add-modal" class="btn btn-sm sbold green"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Download
              </button></a>
            </div>
          </div>
          <div class="col-md-12">
            <div class="material-datatables table-responsive">
             <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>S.No</th>
                    @foreach($data['column'] as $c)
                      <th> {{$c}} </th>
                    @endforeach
                  </tr>
                </thead>
                
                <tbody>
                @if(count($data['list'])>0)
                @php
                 $i=0;
                @endphp
                @foreach($data['list'] as $l)
                  <tr>
                    <td> {{++$i}} </td>
                    @foreach($data['column'] as $key=>$c)
                      <td> 
                      @if($key=='created_at')
                        {{date('d-m-Y h:i A',strtotime($l->$key))}} 
                      @elseif($key=='image')
                      <img src="{{asset('images/'.$l->$key)}}" style="width: 150; height: 100px;">
                      @else
                        {{$l->$key}}
                      @endif
                      </td>
                    @endforeach
                  </tr>
                @endforeach  
                @endif      
                </tbody>
            </table>
        </div>
          </div>
        </div>
    </div>
        </div> 
      </div>
    </div>
  </div>
</div>
@endsection
@if (session()->has('success_message'))

	<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{ session()->get('success_message') }}
  </div>
@endif

@if (session()->has('error_message'))
	
	<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     {{ session()->get('error_message') }}
  </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if ($message = Session::get('success'))
<div class="col-lg-12 margin-tb">
<script type="text/javascript">
    $( document ).ready(function() {
        demo.showNotification('bottom','right','success', '<?php echo $message ?>');
    });
</script>
</div>
@endif

@if ($message = Session::get('error'))
<div class="col-lg-12 margin-tb">
<script type="text/javascript">
    $( document ).ready(function() {
        demo.showNotification('bottom','right','danger', '<?php echo $message ?>');
    });
</script>
</div>
@endif  



@if ($message = Session::get('front_success'))
<script type="text/javascript">
    $( document ).ready(function() {
        getMsg('<?php echo $message ?>','success');
    });
</script>
@endif

@if ($message = Session::get('front_error'))
<script type="text/javascript">
    $( document ).ready(function() {
        getMsg('<?php echo $message ?>','error');
    });
</script>
@endif  
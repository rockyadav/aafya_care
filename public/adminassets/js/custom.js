$(document).ready(function(){
	
	 jQuery('.numbersOnly').keyup(function () {
	this.value = this.value.replace(/[^0-9]/g,'');
	});

	
	jQuery('.txt_Space').keyup(function () {
	this.value = this.value.replace(/[^a-zA-Z ]/g,'');
	});

	jQuery('.txt_Space_number').keyup(function () {
	this.value = this.value.replace(/[^a-zA-Z0-9, ]/g,'');
	});

	jQuery('.alpha_numeric').keyup(function () {
	this.value = this.value.replace(/[^a-zA-Z0-9]/g,'');
	});

	jQuery('.emailOnly').keyup(function () { 
	this.value = this.value.replace(/[^\w\.+@a-zA-Z_+?\.a-zA-Z\.]/g,'');

	});
	
	
    $('#category_id').on('change',function(){
        var id = $(this).val();
        if(id){
            $.ajax({
                url: base_url+'/admin/get-product-name/'+id,
                method:"get",
                contentType: "application/json",
                dataType: "json",
                success:function(data)
                {
                    if(data.message=='success')
                    {
                        $('#pname_id').html(data.option);
                        $(".selectpicker").selectpicker('refresh');

                    }else{
                        var message = 'Please try again';
                        demo.showNotification('bottom','right','danger', message );
                    }                    
                },
                error:function(er){
                    console.log(er); 
                }
            }); 
        }
    });

    $('#pname_id').on('change',function(){
        var id = $(this).val();
        if(id){
            $.ajax({
                url: base_url+'/admin/get-size/'+id,
                method:"get",
                contentType: "application/json",
                dataType: "json",
                success:function(data)
                {
                    if(data.message=='success')
                    {
                        $('#pro_size').html(data.option);
                        $(".selectpicker").selectpicker('refresh');

                    }else{
                        var message = 'Please try again';
                        demo.showNotification('bottom','right','danger', message );
                    }                    
                },
                error:function(er){
                    console.log(er); 
                }
            }); 
        }
    });
});
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
	
	
	 $('#linkedin_link').on('change', function() {
	   var url = $( this ).val();
	   $(".error_linkedin_link").html('');
	   if(url!=""){
		 var re = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
			if (!re.test(url)) { 
				 $(".error_linkedin_link").html('Please enter valid link.');
				   $('#linkedin_link').val('');
			}else{
				 $(".error_linkedin_link").html(''); 
			  }
			  
		 }else{
		   $(".error_linkedin_link").html('');
	   } 
	  
	});

	
	$('#facebook_link').on( 'change', function() {
	   var url = $( this ).val();
	    $(".error_facebook_link").html('');
	   if(url!=""){
		 var re = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
			if (!re.test(url)) { 
				 $(".error_facebook_link").html('Please enter valid link.');
				   $('#facebook_link').val('');
			}else{
				 $(".error_facebook_link").html(''); 
			  }
			  
		 }else{
		   $(".error_facebook_link").html('');
	   } 
	  
	});
	
	
	$('#user_email').on( 'change', function() {
	   var email = $( this ).val();
	   if(email!=""){
		   var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			  if(!regex.test(email)) {
				  $(".error_email").html('Please enter valid email address.');
				   $('#user_email').val('');
			  }else{
				 $(".error_email").html(''); 
			  }
		 }else{
		   $(".error_email").html('');
	   }  
	   
	});
	
	$('#adhar_card_no').on( 'change', function() {
	   var adar = $( this ).val();
	   if(adar!=""){
		   if(adar.length!=12){
			   $(".adhar_card_no").html('Invalid adhar card no. only 12 digit are accepted.');
			   $('#adhar_card_no').val('');
		   }else{
			   $(".adhar_card_no").html('');
		   }
		  
	   } else{
		   $(".adhar_card_no").html('');
	   }
	});
	
	$('#pinNo').on( 'change', function() {
	   var adar = $( this ).val();
	   if(adar!=""){
		   if(adar.length !=6){
			   $(".pinNo").html('Invalid pin no. only 6 digit are accepted.');
			   $('#pinNo').val('');
		   }else{
			   $(".pinNo").html('');
		   }
		  
	   } else{
		   $(".pinNo").html('');
	   }
	});
	
	$('#present_pin').on( 'change', function() {
	   var adar = $( this ).val();
	   if(adar!=""){
		   if(adar.length !=6){
			   $(".present_pin").html('Invalid pin no. only 6 digit are accepted.');
			   $('#present_pin').val('');
		   }else{
			   $(".present_pin").html('');
		   }
		  
	   } else{
		   $(".present_pin").html('');
	   }
	});
	
	
	$('#agreement_of_divorcee').on( 'change', function() {
	   myfile = $( this ).val();
	   var ext = myfile.split('.').pop();
	   if(ext=="pdf" || ext=="doc" || ext=="jpg" || ext=="jpeg" || ext=="png" || ext=="docx"){
		   $(".agreement_of_divorcee").html('');
	   } else{
		   $(".agreement_of_divorcee").html('Only images,pdf and doc file are accepted.');
		   $( this ).val('');
	   }
	});
	
	
	$(".aphone").change(function() {
        var mobile = $(this).val();
        var filter = /^[7-9][0-9]{9}$/;
          var mob_length = mobile.length;
		 if (mobile!='')
		 {
			 if (mob_length!=10) 
			 {
			   $('.error_mobile').html('Invalid phone number accept 10 digit.'); 
			   $('.aphone').val('');
			 }else{
		        $(".error_mobile").html('');
			 }
       }else{
		   $(".error_mobile").html('');
	   }  
		 
    });
	
	$(".uphone").change(function() {
        var mobile = $(this).val();
        var filter = /^[7-9][0-9]{9}$/;
          var mob_length = mobile.length;
		 if (mobile!='')
		 {
			 if (mob_length!=10) 
			 {
			   $('.landline_phone_no').html('Invalid landline phone no accept 10 digit.');
			    $('.uphone').val('');
			 }else{
				$('.landline_phone_no').html(''); 
			 } 
		 }else{
		   $(".landline_phone_no").html('');
	   }
    });
	
	
    $('.checkname').keyup(function(){
		var yourInput = $(this).val();
		re = /[`~!@#$%^&*()_|+\-=?;:'",.0123456789<>\{\}\[\]\\\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.0123456789<>\{\}\[\]\\\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});

     $('.aditya').keyup(function(){
		var yourInput = $('.aditya').val();
		alert(yourInput);
	});

    $('.checktxtspl').keyup(function(){
		var yourInput = $(this).val();
		alert(yourInput);
		re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});
	
	 $('.checkdes').keyup(function(){
		var yourInput = $(this).val();
		re = /[`~!@#$%^&*_|+\;0123456789<>\{\}\[\]\\\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!@#$%^&*_|+\;0123456789<>\{\}\[\]\\\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});  
	
	$('.checknum').keyup(function(){
		var yourInput = $(this).val();
		re = /[!0123456789<>\{\}\[\]\\\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[!0123456789<>\{\}\[\]\\\/]/gi, '');
			$(this).val(no_spl_char);
		}
	}); 
	

});
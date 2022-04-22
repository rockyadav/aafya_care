
$(document).on('submit', '#save-form, #edit-form', function (e) {
    e.preventDefault();
    var image = $('input[name="image"]');
    var url = $(this).attr('action'),
    post = $(this).attr('method'),
    formData = new FormData(this);
    formData.append('file', image);
    $('button[type="submit"]').attr('disabled',true);
    $.ajax({
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    var percentComplete = ((evt.loaded / evt.total) * 100);
                    $(".progress-bar").width(percentComplete + '%');
                    $(".progress-bar").html(percentComplete+'%');
                }
            }, false);
            return xhr;
        },
        url: url,
        method: post,
        data: formData,
        beforeSend:function(){
            $('button[type="submit"]').attr('disabled',true);
            $('.progress').show();
            $(".progress-bar").width('0%');
            $('.uploadStatus').html('<img src="'+base_url+'/public/loading.gif" class="uploaderimg"/>');
          },        
        success:function(response)
        {
            $('button[type="submit"]').attr('disabled',false);
            if(response.status=='error')
            {
                $('.progress').hide();
                $('.uploadStatus').html('<p style="color:#EA4335;">Please select a valid file to upload.</p>');
                demo.showNotification('bottom','right','danger', response.msg); 
            }else{
                demo.showNotification('bottom','right','success', response.msg); 
                setTimeout(function(){ location.reload(); }, 1000);
            }  
        },
        error:function(response){
            $('.uploadStatus').html('<p style="color:#EA4335;">Upload failed, please try again.</p>');
            $('button[type="submit"]').attr('disabled',false);
            demo.showNotification('bottom','right','danger', response.msg);
        },
        processData: false,
        contentType: false
    });
});

$(document).on('submit', '#comman-form', function (e) {
    e.preventDefault();
    var url = $(this).attr('action'),
    post = $(this).attr('method'),
    formData = new FormData(this);
    $('button[type="submit"]').attr('disabled',true);
    $.ajax({
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    var percentComplete = ((evt.loaded / evt.total) * 100);
                    $(".progress-bar").width(percentComplete + '%');
                    $(".progress-bar").html(percentComplete+'%');
                }
            }, false);
            return xhr;
        },
        url: url,
        method: post,
        data: formData,
        beforeSend:function(){
            $('button[type="submit"]').attr('disabled',true);
            $('.progress').show();
            $(".progress-bar").width('0%');
            $('.uploadStatus').html('<img src="'+base_url+'/public/loading.gif" class="uploaderimg"/>');
          },        
        success:function(response)
        {
            $('button[type="submit"]').attr('disabled',false);
            if(response.status=='error')
            {
                $('.progress').hide();
                $('.uploadStatus').html('');
                demo.showNotification('bottom','right','danger', response.msg); 
            }else{
                demo.showNotification('bottom','right','success', response.msg); 
                setTimeout(function(){ location.reload(); }, 1000);
            }  
        },
        error:function(response){
            $('button[type="submit"]').attr('disabled',false);
            demo.showNotification('bottom','right','danger', response.msg);
        },
        processData: false,
        contentType: false
    });
});

$(document).on('submit', '#image-form', function (e) { 
    e.preventDefault();
    var image = $('input[name="image[]"]');
    var url = $(this).attr('action'),
    post = $(this).attr('method'),
    formData = new FormData(this);
    formData.append('file', image);
    $('button[type="submit"]').attr('disabled',true);
    $.ajax({
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    var percentComplete = ((evt.loaded / evt.total) * 100);
                    $(".progress-bar").width(percentComplete + '%');
                    $(".progress-bar").html(percentComplete+'%');
                }
            }, false);
            return xhr;
        },
        url: url,
        method: post,
        data: formData,
        beforeSend:function(){
            $('button[type="submit"]').attr('disabled',true);
            $('.progress').show();
            $(".progress-bar").width('0%');
            $('.uploadStatus').html('<img src="'+base_url+'/public/loading.gif" class="uploaderimg"/>');
          },        
        success:function(response)
        {
            $('button[type="submit"]').attr('disabled',false);
            if(response.status=='error')
            {
                $('.progress').hide();
                $('.uploadStatus').html('<p style="color:#EA4335;">Please select a valid file to upload.</p>');
                demo.showNotification('bottom','right','danger', response.msg); 
            }else{
                demo.showNotification('bottom','right','success', response.msg); 
                setTimeout(function(){ location.reload(); }, 1000);
            }  
        },
        error:function(response){
            $('.uploadStatus').html('<p style="color:#EA4335;">Upload failed, please try again.</p>');
            $('button[type="submit"]').attr('disabled',false);
            demo.showNotification('bottom','right','danger', response.msg);
        },
        processData: false,
        contentType: false
    });
});

$(document).on('change', '#category', function (e) { 
    e.preventDefault();
    var cat_id = $(this).val();
        if(cat_id != '')
        {
            $.ajax({
                url:base_url+'/get-sub-category/'+cat_id,
                method:"GET",
                success:function(response) {
                   $('#sub-category').html(response);
                   $('#sub-category').selectpicker('refresh');      
                },
                error:function(response){
                    console.log('error');
                },
                complete: function () {
                    //console.log('complete');
                }
            });
        }
});

 $(document).on('click', '.confirmbox', function(e) {
    e.preventDefault();
    var $this = $(this);
    bootbox.confirm("Are you sure?",function(o){
        if(o)
        {
            window.location.href = $this.attr('href');
        }
    });
});
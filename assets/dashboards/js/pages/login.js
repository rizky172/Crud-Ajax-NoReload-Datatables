$(function() {
	$("#form-login").validate({
        rules: {
            password: {
                required: true
            },
            email: {
                required: true
            }
        },
        messages: {
            email: {
                required: "Insert your email"
            },
            password: {
                required: "Insert your password"
            }
        },
        submitHandler: function () {
        	var post_data = new FormData($('#form-login')[0]);
        	$.ajax({ 
                url : $('#form-login').attr("action"),
                type: "POST",
                data : post_data,
                contentType: false,
                cache: false,
                processData:false,
                dataType:"JSON",
                success: function(data) {
                    if (data.code == 200){
                        eval(data.aksi);
                    }else if (data.code == 366){
                        swal(data.message, '', 'error');
                    }else if (data.code == 367){
                        swal(data.message, '', 'error');
                    }else{
                        swal(data.message, '', 'error');
                    }
                },
                error: function(data){
                    swal(data.message, '', 'error');
                }
            });
        }
    });

});

$(document).ready(function() {
    $("input[type=number]").on("focus", function() {
        $(this).on("keydown", function(event) {
            if (event.keyCode === 38 || event.keyCode === 40) {
                event.preventDefault();
            }
        });
        $(this).on('mousewheel.disableScroll', function (e) {
          e.preventDefault()
        })
    });

    $('input[type=number]').on('blur', function (e) {
      $(this).off('mousewheel.disableScroll')
    })

    $('.capitalize').on('input', function(evt) {
    	$(this).val(function(_, val) {
    		return val.toUpperCase();
    	});
    });

    $(".custom-file-input").on("change", function(e) {
      if(e.target.files[0])
      	var fileName = e.target.files[0].name;
      else
      	var fileName = "Choose file"
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
});

$("#login-form").submit(function(event) {
	event.preventDefault();
	var username = $("#username").val();
	var password = $("#password").val();
	$.ajax({
		headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: '/login',
		type: 'post',
		data: {
			username: username,
			password: password
		},
		beforeSend: function() {
			$("#login-btn").attr('disabled','disabled').text('Please Wait');
		},
		success: function(data) {
			if(data.status==1){
				$("#login-btn").text('Logging In..');
				window.location.href = '/';
			}
			else{
				$(".error-message").text(data.response);
				$("#login-btn").removeAttr('disabled').text('Login');
			}
		},
		error: function() {
			$(".error-message").text('Error. Try again');
			$("#login-btn").removeAttr('disabled').text('Login');
		},
		complete: function() {
			
		}
	});
});

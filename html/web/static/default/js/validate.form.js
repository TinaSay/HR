
function initSelect() {
	$('.chosen-select').chosen({
		width: "100%",
		disable_search: true,
		search_contains: true
	});
}

// Custom
(function() {

	//Input
	(function () {
		var inputs = $('.input__field');
		for (var i = 0; i < inputs.length; i++) {
			if( $(inputs[i]).val() !== '' ) {	
				$(inputs[i]).parent().addClass('input--filled');
			}
		}
	})();

	$('.input__field').on('focus', function(ev){
		if($(this).attr('readonly') == 'readonly') {
			return;
		}
		$(this).parent().addClass('input--filled');
	})

	$('.input__field').on('blur', function(ev){
		if( $(this).val() == '' ) {
	      $(this).parent().removeClass('input--filled');
	    }
	})



	// input mask
	$('.field-clientform-phone input.input__field').mask("7(999) 999-9999");


	//Select
	$('.chosen-select').chosen({
		width: "100%",
		disable_search: true,
		search_contains: true
	});



	//Show password 
	$('.faild-wrap .icon-show').on('click', function(){
		var $input = $(this).parent().find('input.input__field');
		if($(this).hasClass('shown')) {
			$(this).removeClass('shown');
			$input.attr('type', 'password');
		} else {
			$(this).addClass('shown');
			$input.attr('type', 'text');
		}
	});

	//Readonly
	$('.faild-wrap .icon-redact').on('click', function(){
		var $input = $(this).parent().find('input.input__field');
		if($(this).hasClass('active')) {
			$(this).removeClass('active');
			$input.attr('readonly', 'readonly');
		} else {
			$(this).addClass('active');
			$input.removeAttr('readonly');
			$input.focus();
		}
	});


	// Filereader
	if (window.File && window.FileReader && window.FileList && window.Blob) {
		
		function humanFileSize(bytes, si) {
		  var thresh = si ? 1000 : 1024;
		  if(bytes < thresh) return bytes + ' B';
		  var units = si ? ['kB','MB','GB','TB','PB','EB','ZB','YB'] : ['KiB','MiB','GiB','TiB','PiB','EiB','ZiB','YiB'];
		  var u = -1;
		  do {
		    bytes /= thresh;
		    ++u;
		  } while(bytes >= thresh);
		  return bytes.toFixed(1)+' '+units[u];
		}

		var fileExtension = ['jpg', 'png', 'gif'];

		function renderImage(inputFile){
			var file = inputFile.files[0],
					conteiner = $(inputFile).parent();

			var reader = new FileReader();
			reader.onload = function(event){
				the_url = event.target.result;

				if ($.inArray(name.split('.').pop().toLowerCase(), fileExtension) == -1) {
					//$('.file-debug').text('файл должен соответствовать допустимым форматам и размеру');
					//return;
				}

				$(conteiner).addClass('active');
				$(conteiner).find('.preview').css('background-image', 'url('+the_url+')');
				$(conteiner).find('.file-name').html(file.name)
				$(conteiner).find('.file-size').html(humanFileSize(file.size, "kB"))
			}
			reader.readAsDataURL(file);
		}

		$('.upload-img').change(function() {
			renderImage(this);
		});

		$('.input-file-block .btn-change').on('click', function(){
	    $(this).parent().parent().find('input[type="file"]').trigger('click');
	  });

	  $('.input-file-block .clear-file').on('click', function(){
	    $(this).parent().parent().parent().find('input[type="file"]').val('');
	    $(this).parent().parent().parent().removeClass('active');
	  });

	} else {
	  $('.file-debug').text('The File APIs are not fully supported in this browser.');
	}





	//User data
	$('.block-user-data input.input__field, .block-user-data input.checkbox__field').on('change', function(){
		$('.block-user-data .form-send').removeAttr('disabled');
	});

	function profileProgress() {
		var $inputs = $('.block-user-data input.input__field'),
			  $progressBar = $('.prgress-bar');

		function setProgress(){
			var count = 0,
					persent = 0;

			for (var i = 0; i < $inputs.length; i++) {
				if($($inputs[i]).val() !== '') {
					count ++;
				}
			}
			var persent =	count / ($inputs.length * 0.01);
			$progressBar.find('.prgress-status').text(persent.toFixed() + '%');
			$progressBar.find('.progress-bg').css('width', persent.toFixed() + '%');
		}	

		setProgress();  

		 $inputs.on('change', function(){
			setProgress();
		});
	}

	profileProgress();




	// registration
	$('#registration form').submit(function(e) {
		e.preventDefault();
		var data = $(this).serialize(),
        method = $(this).attr('method'),
        action = $(this).attr('action');

		$.ajax({
      type: method,
      url: action,
      data: data,
      complete: function(jqXHR,status) {
        if (status == 'success') {
          var height = $('#reg-step-4').outerHeight();

			  	$('#modalLogIn #registration').css('height', height + 46 +'px');	  
			  	$('.reg-step-wrap .reg-step-card').removeClass('active');
			  	$('#reg-step-4').addClass('active');

			  	$('.reg-step-wrap .reg-step-card:not(.active)').fadeOut(200, function(){
			  		setTimeout(function() { 			
			  			$('#reg-step-4').fadeIn(200);
			  		},200);
			  	});

        } else {
          console.log(status);
        }   
      }
    });
	});


})();
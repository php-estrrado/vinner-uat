$(document).ready(function() {
	$('.demo-chosen-select').chosen();
	$('.demo-cs-multiselect').chosen({
		width: '100%'
	});
});

function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			$('#wrap').hide('fast');
			$('#blah').attr('src', e.target.result);
			$('#wrap').show('fast');
		}
		reader.readAsDataURL(input.files[0]);
	}
}

$("#imgInp").change(function() {
	readURL(this);
});



/*brand banner*/


function readURL1(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			$('#wrap1').hide('fast');
			$('#blah1').attr('src', e.target.result);
			$('#wrap1').show('fast');
		}
		reader.readAsDataURL(input.files[0]);
	}
}


$("#imgInp1").change(function() {
   // alert("hai....");
	readURL1(this);
});


/*//brand banner*/



$(document).ready(function() {
	$("form").submit(function(e) {
		return false;
	});
});
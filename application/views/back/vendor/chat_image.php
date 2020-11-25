


<div>
	<?php
        echo form_open(base_url() . 'vendor/ChatImage/do_add/'.$chat_id, array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'image_add',
            'enctype' => 'multipart/form-data'
        ));
        ?>

        <div class="panel-body">
            
			<div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('');?></label>
                <div class="col-sm-6">
                    
                </div>
            </div>

            <div class="form-group">
                <!--<label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('Image');?></label> -->
                <div class="col-sm-12 nopad">
					<div id='wrap' class="file-thump" >
                        
                    </div>
                    <span class=" btn btn-default btn-file">
                        <?php echo translate('select_file');?>
                        <input type="file" name="img" id='imgInp' accept="image" class='required'>
                    </span>
                    <span id='file-valid' style="color:red">
					</span>
                    
                </div>
            </div>
			<div class="form-group img-upload" >
				<button id='btn-flieup' type='submit' class="btn btn-info" >Upload </button>
			</div>
        </div>
	       <?php 
        echo form_close();
    ?>
</div>

<style>
	.modal-footer
	{
		display:none;
	}
</style>
	   
<script type="text/javascript">

    $(document).ready(function() 
	{
		$("#image_add").submit(function(e)
		{
			var validf='ok';
			var here = $(this);
       		var form = here.closest('form');
			var formdata = false;
        	if (window.FormData)
			{
            	formdata = new FormData(form[0]);
       		}
			//alert(formdata);
			if($("#imgInp").val())
			{
				//alert(form.attr('action'));
				$.ajax(
				{
					url: form.attr('action'), 
					type: 'POST', 
					dataType: 'html',
					data: formdata ? formdata : form.serialize(), 
					cache       : false,
					contentType : false,
					processData : false,
					beforeSend: function() 
					{
						//here.html(ing); 
						$("#btn-flieup").html('<i class="fa fa-spinner fa-spin"></i>');
					},
					success: function(data) 
					{
						console.log(data);
						getChatMessages();
						 $(".modal").modal('hide');
					},
					error: function(e) {
						console.log(e)
					}
            	});

			}
			else
			{
				$('#file-valid').html("Please select any file.");
			}
			return false;
		});
	});

	$("#imgInp").change(function() 
	{
		$('#file-valid').html("");
		//readURL(this);
	   if (this.files && this.files[0]) 
	   {
			var fileExtension = ['jpeg','png','jpg','pdf','docx'];
			var entx=$(this).val().split('.').pop().toLowerCase();
			if ($.inArray(entx, fileExtension) == -1)
      		{
				$('#wrap').html('');
                $('#file-valid').html("Formats allowed :"+fileExtension.join(','));
                $(this).val("");
      		}
     		else
      		{
				$('#file-valid').html("");
				$('#wrap').html('');
				var fileExte2 =['pdf','docx'];
				if($.inArray(entx,fileExte2)==-1)
      			{
					var reader = new FileReader();
					reader.onload = function(e) 
					{
						//$('#wrap').hide('fast');
						$('#wrap').html('<img src="" width="50%" id="img-prev" > ');
						$('#img-prev').attr('src', e.target.result);
						//$('#wrap').show('fast');
					}
					reader.readAsDataURL(this.files[0]);
				}
				else if(entx=='pdf')
				{
					$('#wrap').html('<span id="file-prev"><i class="fa fa-file-pdf-o fa-5x" aria-hidden="true"></i></span><span id="file-prev-name">'+this.files[0].name+'</span>');
				}
				else
				{
					$('#wrap').html('<span id="file-prev"><i class="fa fa-file-word-o fa-5x" aria-hidden="true"></i></span><span id="file-prev-name">'+this.files[0].name+'</span>');
				}
        		
      		}
	   }
	});
	
</script>


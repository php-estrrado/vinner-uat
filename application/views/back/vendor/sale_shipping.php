<div>
	<?php
		$hidefrm='';
		$hidedta='';
		if($shipping_data)
		{
			$hidefrm=' shide-data';
		}
		else
		{
			$hidedta=' shide-data';
		}
        echo form_open(base_url() . 'vendor/sales/add_shipping/'.$sale_id, array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'image_add',
            'enctype' => 'multipart/form-data'
        ));
        ?>

        <div class="panel-body">
           <div id='ship-form' class=' <?php echo $hidefrm;?>'> 
				<div class="form-group">
					<div class="col-sm-12 nopad">
						<div id='wrap' class="file-thump" >

						</div>
						<span class=" btn btn-default btn-file">
							<?php echo translate('select_receipt');?>
							<input type="file" name="img" id='imgInp' accept=".jpg, .png, .doc,.pdf,.docx" class='required'>
						</span>
						<span id='file-valid' style="color:red">
						</span>

					</div>
				</div>
				<div class="form-group img-upload" >
					<button id='btn-flieup' type='submit' class="btn btn-info" >Upload</button>
				</div>
		  </div>
		  <div id='ship-data' class='<?php echo $hidedta;?>'>
				<div class="form-group">
					<div class="col-sm-12 nopad">
						<div id='spip-wrap' class="file-thump" >
							<?php
								if($shipping_data)
								{
									//print_r($shipping_data);
									$ext = pathinfo($shipping_data->receipt, PATHINFO_EXTENSION);
									if($ext=='pdf')
									{
										?>
										<span id="file-prev">
											<i class="fa fa-file-pdf-o fa-5x" aria-hidden="true"></i>
											<br/><br/>
											<a class='img-down btn btn-mint btn-xs' href="<?php echo base_url('uploads/
shipping_receipt').'/shipping_receipt_'.$shipping_data->sale_shipping_id.'.'.$ext; ?>" download="<?php echo 'shipping_'.$sale_data->sale_code.'.'.$ext; ?>">Download</a>
										</span>
										<?php
										
									}
									else if($ext=='doc' || $ext=='docx')
									{
										?>
										<span id="file-prev">
											<i class="fa fa-file-word-o fa-5x" aria-hidden="true"></i>
											<br/><br/>
											<a class='img-down btn btn-mint btn-xs' href="<?php echo base_url('uploads/
shipping_receipt').'/shipping_receipt_'.$shipping_data->sale_shipping_id.'.'.$ext; ?>" download="<?php echo 'shipping_'.$sale_data->sale_code.'.'.$ext; ?>">Download</a>
										</span>
										<?php
									}
									else
									{
										?>
											<img src="<?php echo base_url('uploads/
shipping_receipt').'/shipping_receipt_'.$shipping_data->sale_shipping_id.'.'.$ext; ?>" width="50%" id="img-prev" style="height: 180px;" >
											<br/><br/>
											<a class='img-down btn btn-mint btn-xs' href="<?php echo base_url('uploads/
shipping_receipt').'/shipping_receipt_'.$shipping_data->sale_shipping_id.'.'.$ext; ?>" download="<?php echo 'shipping_'.$sale_data->sale_code.'.'.$ext; ?>">Download</a>
										<?php
									}
								}
							?>
						</div>
					</div>
				</div>
				<!--<div class="form-group img-upload" >
					<button id='' type='' class="btn btn-info" >Change</button>
				</div>	-->
		  </div>
        </div>
	     <?php 
       echo form_close();
    ?>
</div>



<style>
	.modal-footer,.shide-data 
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
			var fileExtension = ['jpeg','png','jpg','pdf','docx','doc'];
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
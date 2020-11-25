<div>
    <?php
		echo form_open(base_url() . 'index.php/admin/category/do_add/', array(
			'class' => 'form-horizontal',
			'method' => 'post',
			'id' => 'category_add',
			'enctype' => 'multipart/form-data'
		));
	?>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1">
                	<?php echo translate('category_name');?>
                    	</label>
                <div class="col-sm-6">
                    <input type="text" name="category_name" id="demo-hor-1" 
                    	class="form-control required" placeholder="<?php echo translate('category_name');?>" >
                    	<div id='email_note' style="color:red;"></div>
                </div>
            </div>

            <div class="form-group btm_border">
                <label class="col-sm-4 control-label" for="demo-hor-13"><?php echo translate('description'); ?>
                </label>
                <div class="col-sm-6">
                    <textarea rows="4" class="form-control" name="description" data-height="100" id="short_descrt" data-name="description" placeholder="Category Description"></textarea>
                </div>
            </div>            
            
            <div class="form-group btm_border">
                <label class="col-sm-4 control-label" for="image"><?php echo translate('image');?></label>
                <div class="col-sm-6">
                    <span class="pull-left btn btn-default btn-file">
                        <?php echo translate('select_category_image');?>
                        <input type="file" name="image" id='image' accept="image/*">
                    </span>
                    <br><br>
                    <span id='wrap' class="pull-left" >
                        <img src="<?php echo base_url('uploads/others/photo_default.png'); ?>" width="48.5%" id='image_img' > 
                    </span>
                </div>
            </div>

        </div>
	<?php echo form_close(); ?>
</div>

<script>
	$(document).ready(function() {
		$("form").submit(function(e){
			return false;
		});

		//$(".btn-purple").prop('disabled',true);
	});

	$("#demo-hor-1").blur(function(){

		var email = $("#demo-hor-1").val();

		$.post("<?php echo base_url(); ?>index.php/admin/existscat",

		{

			<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',

			email: email

		},

		function(data, status){

			if(data == 'yes'){

				$("#email_note").html('*<?php echo translate('category_already_created'); ?>');

				 $(".btn-purple").attr("disabled", "disabled");

			} else if(data == 'no'){

				$("#email_note").html('');

				$(".btn-purple").removeAttr("disabled");

			}

		});

	});

</script>
<div>
    <?php
		echo form_open(base_url() . 'index.php/admin/equipment/do_add/', array(
			'class' => 'form-horizontal',
			'method' => 'post',
			'id' => 'equipment_add',
			'enctype' => 'multipart/form-data'
		));
	?>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1">
                	<?php echo translate('equipment_name');?>
                    	</label>
                <div class="col-sm-6">
                    <input type="text" name="equipment_name" id="demo-hor-1" 
                    	class="form-control required" placeholder="<?php echo translate('equipment_name');?>" >
                    	<div id='email_note' style="color:red;"></div>
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

		$.post("<?php echo base_url(); ?>index.php/admin/existsequip",
		{
			<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',
			email: email
		},

		function(data, status){

			if(data == 'yes'){

				$("#email_note").html('*<?php echo translate('equipment_already_created'); ?>');

				 $(".btn-purple").attr("disabled", "disabled");

			} else if(data == 'no'){

				$("#email_note").html('');

				$(".btn-purple").removeAttr("disabled");

			}

		});

	});

</script>
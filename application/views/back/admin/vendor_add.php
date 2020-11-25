<div>

    <?php

		echo form_open(base_url() . 'index.php/admin/vendor/do_add/', array(

			'class' => 'form-horizontal',

			'method' => 'post',

			'id' => 'vendor_add',

			'enctype' => 'multipart/form-data'

		));

	?>

        <div class="panel-body">

            <div class="form-group">

                <label class="col-sm-4 control-label" for="demo-hor-1">

                	<?php echo translate('display_name');?>

                    	</label>

                <div class="col-sm-6">

                    <input type="text" id="" name="display_name" placeholder="<?php echo translate('display_name'); ?>" class="form-control required">

                </div>

            </div>
            <div class="form-group">

                <label class="col-sm-4 control-label" for="demo-hor-1">

                	<?php echo translate('name');?>

                    	</label>

                <div class="col-sm-6">

                    <input type="text" id="" name="name" placeholder="<?php echo translate('name'); ?>" class="form-control required">

                </div>

            </div>
            <div class="form-group">

                <label class="col-sm-4 control-label"><?php echo translate('Country');?></label>

                <div class="col-sm-6">

                    <?php echo $this->crud_model->select_html_data('countries','country','name','add','demo-chosen-select required'); ?>

                    <div  id='email_note' style="color:red;"> </div>

                </div>

            </div>

            <div class="form-group">

                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('address');?></label>

                <div class="col-sm-6">
                    <textarea id="" name="address" class="form-control required" rows="4" cols="40">
                    </textarea>

                </div>

            </div>
             <div class="form-group">

                <label class="col-sm-4 control-label" for="demo-hor-1">

                	<?php echo translate('phone');?>

                    	</label>

                <div class="col-sm-6">

                    <input type="text" id="" name="phone" placeholder="<?php echo translate('phone'); ?>" class="form-control required">

                </div>

            </div>
             <div class="form-group">

                <label class="col-sm-4 control-label" for="demo-hor-1">

                	<?php echo translate('email');?>

                    	</label>

                <div class="col-sm-6">

                    <input type="text" id="" name="email" placeholder="<?php echo translate('email'); ?>" class="form-control required">

                </div>

            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('password');?></label>
                <div class="col-sm-6">
                    <input type="password" id="password" name="password" placeholder="<?php echo translate('password'); ?>" class="form-control required">
                </div>
            </div>
        </div>

	</form>

</div>



<script>

	$(document).ready(function() {

		$('.demo-chosen-select').chosen();

		$('.demo-cs-multiselect').chosen({width:'100%'});

	});

	

	$(document).ready(function() {

		$("form").submit(function(e){

			return false;

		});

	});



	$("#subcat").blur(function()
{
	subcatexi();

});

$("select[name='category']" ).change(function(){

subcatexi();

});
		
	
function subcatexi()
{
	var email = $("#subcat").val();
		var email2= $("select[name='category']" ).val();
//alert(email+":"+email2);

		$.post("<?php echo base_url(); ?>index.php/admin/existssubcat",

		{

			<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',

			email: email ,
			email2: email2

		},

		function(data, status){

			if(data == 'yes'){

				$("#email_note").html('*<?php echo translate('This_subcategory_already_created_for_this_category..'); ?>');

				 $(".btn-purple").attr("disabled", "disabled");
				 $("#subcat").focus();

			} else if(data == 'no'){

				$("#email_note").html('');

				$(".btn-purple").removeAttr("disabled");

			}

		});
}

</script>



<!--Bootstrap Tags Input [ OPTIONAL ]-->

<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>


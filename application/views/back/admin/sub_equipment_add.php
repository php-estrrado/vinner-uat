<div>

    <?php

		echo form_open(base_url() . 'index.php/admin/sub_equipment/do_add/', array(

			'class' => 'form-horizontal',

			'method' => 'post',

			'id' => 'sub_equipment_add',

			'enctype' => 'multipart/form-data'

		));

	?>

        <div class="panel-body">

            <div class="form-group">

                <label class="col-sm-4 control-label" for="demo-hor-1">

                	<?php echo translate('sub-equipment_name');?>

                    	</label>

                <div class="col-sm-6">

                    <input type="text" id="subcat" name="sub_equipment_name" placeholder="<?php echo translate('sub-equipment_name'); ?>" class="form-control required">

                </div>

            </div>

            <div class="form-group">

                <label class="col-sm-4 control-label"><?php echo translate('equipment');?></label>

                <div class="col-sm-6">

                    <?php echo $this->crud_model->select_html('equipment','equipment','equipment_name','add','demo-chosen-select required'); ?>
                    <?php 
                    //echo $this->crud_model->select_html('category','category','category_name','add','demo-cs-multiselect'); ?>

                    <div  id='email_note' style="color:red;"> </div>

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
	//alert("hai");
	subeqexi();

});

$("select[name='equipment']" ).change(function(){

subeqexi();

});
	
function subeqexi()
{
	var email = $("#subcat").val();
	var email2= $("select[name='equipment']" ).val();
//alert(email+":"+email2);

		$.post("<?php echo base_url(); ?>index.php/admin/existssubequi",

		{

			<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',

			email: email ,
			email2: email2

		},

		function(data, status){

			if(data == 'yes'){

$("#email_note").html('*<?php echo translate('This_Sub_Equipment_already_created_for_this_Equipment..'); ?>');

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


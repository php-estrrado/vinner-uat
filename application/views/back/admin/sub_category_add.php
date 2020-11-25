<div>

    <?php

		echo form_open(base_url() . 'index.php/admin/sub_category/do_add/', array(

			'class' => 'form-horizontal',

			'method' => 'post',

			'id' => 'sub_category_add',

			'enctype' => 'multipart/form-data'

		));

	?>

        <div class="panel-body">

            <div class="form-group">

                <label class="col-sm-4 control-label" for="demo-hor-1">

                	<?php echo translate('sub-category_name');?>

                    	</label>

                <div class="col-sm-6">

                    <input type="text" id="subcat" name="sub_category_name" placeholder="<?php echo translate('sub-category_name'); ?>" class="form-control required">

                </div>

            </div>

            <div class="form-group">

                <label class="col-sm-4 control-label"><?php echo translate('category');?></label>

                <div class="col-sm-6">

                    <?php echo $this->crud_model->select_html('category','category','category_name','add','demo-chosen-select required'); ?>

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


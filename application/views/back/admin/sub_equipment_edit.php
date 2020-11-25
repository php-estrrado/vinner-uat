<?php

	foreach($sub_equipment_data as $row){

?>

 

<div>

	<?php

        echo form_open(base_url() . 'index.php/admin/sub_equipment/update/' . $row['sub_equipment_id'], array(

            'class' => 'form-horizontal',

            'method' => 'post',

            'id' => 'sub_equipment_edit',

            'enctype' => 'multipart/form-data'

        ));

    ?>

        <div class="panel-body">

            <div class="form-group">

                <label class="col-sm-4 control-label" for="demo-hor-inputemail">

                	<?php echo translate('sub-equipment_name');?>

                    	</label>
<input type="text" id="d_prod_code" value="<?php echo $row['sub_equipment_name'];?>"  hidden>
<input type="text" id="d_prod_code2" value="<?php echo $row['equipment'];?>" hidden >

                <div class="col-sm-6">

                    <input type="text" id="subcat" name="sub_equipment_name" value="<?php echo $row['sub_equipment_name'];?>" class="form-control required" placeholder="<?php echo translate('sub-equipment_name'); ?>" >

                </div>

            </div>

            <div class="form-group">

                <label class="col-sm-4 control-label"><?php echo translate('equipment');?></label>

                <div class="col-sm-6">

                    <?php echo $this->crud_model->select_html('equipment','equipment','equipment_name','edit','demo-chosen-select required',$row['equipment']); ?>

                    <div  id='email_note' style="color:red;"> </div>

                </div>

            </div>

        </div>

    </form>

</div>



<script type="text/javascript">

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
    var email = $("#subcat").val();
    var email2= $("select[name='equipment']" ).val();
    subeqexi();
  
});

$("select[name='equipment']" ).change(function(){

subeqexi();


});
        
    
function subeqexi()
{
    //alert($("#subcat").val());
    
    var email = $("#subcat").val();
    var email2= $("select[name='equipment']" ).val();


var defprdcode2= $("#d_prod_code2").val();    
var defprdcode= $("#d_prod_code").val();
//alert(defprdcode);
//alert(defprdcode2);
if(defprdcode2 == email2 && defprdcode == email )
{
    $("#email_note").html('');
    $(".btn-purple").removeAttr("disabled");
}

else if (defprdcode2 != email2 || defprdcode != email )
{

    //alert(defprdcode2 +":"+ email2);

        $.post("<?php echo base_url(); ?>index.php/admin/existssubequi",

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




}




</script>



<?php

	}

?>

	


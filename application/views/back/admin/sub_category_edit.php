<?php

	foreach($sub_category_data as $row){

?>

 

<div>

	<?php

        echo form_open(base_url() . 'index.php/admin/sub_category/update/' . $row['sub_category_id'], array(

            'class' => 'form-horizontal',

            'method' => 'post',

            'id' => 'sub_category_edit',

            'enctype' => 'multipart/form-data'

        ));

    ?>

        <div class="panel-body">

            <div class="form-group">

                <label class="col-sm-4 control-label" for="demo-hor-inputemail">

                	<?php echo translate('sub-category_name');?>

                    	</label>

<input type="text" id="d_prod_code" value="<?php echo $row['sub_category_name'];?>"  hidden>
<input type="text" id="d_prod_code2" value="<?php echo $row['category'];?>" hidden >

                <div class="col-sm-6">

                    <input type="text" id="subcat" name="sub_category_name" value="<?php echo $row['sub_category_name'];?>" class="form-control required" placeholder="<?php echo translate('sub-category_name'); ?>" >

                </div>

            </div>

            <div class="form-group">

                <label class="col-sm-4 control-label"><?php echo translate('category');?></label>

                <div class="col-sm-6">

                    <?php echo $this->crud_model->select_html('category','category','category_name','edit','demo-chosen-select required',$row['category']); ?>

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
var defprdcode2= $("#d_prod_code2").val();    
var defprdcode= $("#d_prod_code").val();

if(defprdcode2 == email2 && defprdcode == email )
{
    $("#email_note").html('');
    $(".btn-purple").removeAttr("disabled");
}

else if (defprdcode2 != email2 || defprdcode != email )
{
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

}


</script>



<?php

	}

?>

	


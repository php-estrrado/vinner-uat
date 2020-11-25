<?php

	foreach($brand_data as $row){

?>

    <div>

        <?php

			echo form_open(base_url() . 'index.php/admin/brand/update/' . $row['brand_id'], array(

				'class' => 'form-horizontal',

				'method' => 'post',

				'id' => 'brand_edit',

				'enctype' => 'multipart/form-data'

			));

		?>

            <div class="panel-body">

                <input type="text" id="d_prod_code" value="<?php echo $row['name'];?>" hidden>

                <div class="form-group">

                    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('brand_name');?></label>

                    <div class="col-sm-6">

                        <input type="text" name="name" id="demo-hor-1" class="form-control required" value="<?php echo $row['name'];?>">
                        <div id='email_note' style="color:red;"></div>
                    </div>

                </div>

             <?php /*  <div class="form-group">

                    <label class="col-sm-4 control-label"> --> <?php //echo translate('category');?>

                  <!--  </label>

                    <div class="col-sm-6"> -->

                          echo $this->crud_model->select_html('category','category','category_name','edit','demo-chosen-select required',$row['category']); */?>

                   <!--   </div>

                </div> -->

                

            <div class="form-group">

                    <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('brand_logo');?></label>

                    <div class="col-sm-6">

                        <span class="pull-left btn btn-default btn-file">

                            <?php echo translate('select_brand_logo');?>

                            <input type="file" name="img" id='imgInp' accept="image">

                        </span>


                        <br><br>
                        <em>(image size 130 X 100)</em>

                        <span id='wrap' class="pull-left" >

                            <img src="<?php echo $this->crud_model->file_view('brand',$row['brand_id'],'','','no','src','','','.png') ?>" width="60%" id='blah' > 

                        </span>

                    </div>

            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="logo_alt"><?php echo translate('logo_alt_text');?></label>
                <div class="col-sm-6">
                <input type="text" name="logo_alt" id="logo_alt" class="form-control totals" placeholder="Alt Text" value="<?php echo $row['logo_alt'];?>" >
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('brand_banner');?></label>
                <div class="col-sm-6">
                    <span class="pull-left btn btn-default btn-file">
                        <?php echo translate('select_brand_banner');?>
                        <input type="file" name="img1" id='imgInp1' accept="image">
                    </span>
                    <br><br>
                  <em>    (image size 920 X 244)</em>
                    <span id='wrap1' class="pull-left" >
                        <img  src="<?php echo $this->crud_model->file_view('brand_banner',$row['brand_id'],'','','no','src','','','.png') ?>" width="48.5%" id='blah1' > 
                    </span>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-4 control-label" for="banner_alt"><?php echo translate('banner_alt_text');?></label>
                <div class="col-sm-6">
                <input type="text" name="banner_alt" id="banner_alt" class="form-control totals" placeholder="Alt Text" value="<?php echo $row['banner_alt'];?>">
                </div>
            </div>


        </div>

        <?php echo form_close(); ?>

    </div>

<?php

	}

?>



<script src="<?php echo base_url(); ?>template/back/js/custom/brand_form.js"></script>


<script type="text/javascript">

 $("#demo-hor-1").blur(function()
    {

        var defprdcode=$("#d_prod_code").val();
        var email = $("#demo-hor-1").val();

if (defprdcode != email) 
    {
        $.post("<?php echo base_url(); ?>index.php/admin/existsbrand",
        {
            <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',
            email: email
        },
        function(data, status){
            if(data == 'yes'){
                $("#email_note").html('*<?php echo translate('brand_already_added'); ?>');
                 $(".btn-purple").attr("disabled", "disabled");
            } else if(data == 'no'){
                $("#email_note").html('');
                $(".btn-purple").removeAttr("disabled");
            }
        });
    }
    else
    {
    $("#email_note").html('');
   $(".btn-purple").removeAttr("disabled");
    }

    });   

</script>



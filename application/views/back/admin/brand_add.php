<div>

	<?php

        echo form_open(base_url() . 'index.php/admin/brand/do_add/', array(

            'class' => 'form-horizontal',

            'method' => 'post',

            'id' => 'brand_add',

            'enctype' => 'multipart/form-data'

        ));

    ?>

        <div class="panel-body">



            <div class="form-group">

                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('brand_name');?></label>

                <div class="col-sm-6">

                    <input type="text" name="name" id="demo-hor-1" 

                    	placeholder="<?php echo translate('brand_name'); ?>" class="form-control required">

                        <div id='email_note' style="color:red;"></div>
                </div>

            </div>

            

           <!-- <div class="form-group">

                <label class="col-sm-4 control-label"><?php //echo translate('category');?></label>

                <div class="col-sm-6">

                    <?php //echo $this->crud_model->select_html('category','category','category_name','add','demo-chosen-select required'); ?>

                </div>

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

                        <img src="<?php echo base_url(); ?>uploads/others/photo_default.png" 

                        	width="48.5%" id='blah' > 

                    </span>

                </div>

            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="logo_alt"><?php echo translate('logo_alt_text');?></label>
                <div class="col-sm-6">
                <input type="text" name="logo_alt" id="logo_alt" class="form-control totals" placeholder="Alt Text">
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
                        <img src="<?php echo base_url(); ?>uploads/others/photo_default.png" 
                            width="48.5%" id='blah1' > 
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="banner_alt"><?php echo translate('banner_alt_text');?></label>
                <div class="col-sm-6">
                <input type="text" name="banner_alt" id="banner_alt" class="form-control totals" placeholder="Alt Text">
                </div>
            </div>




        </div>

	<?php echo form_close(); ?>

</div>

<script src="<?php echo base_url(); ?>template/back/js/custom/brand_form.js"></script>



<script type="text/javascript">
    
 $("#demo-hor-1").blur(function()
    {
        var email = $("#demo-hor-1").val();
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
    });   

</script>

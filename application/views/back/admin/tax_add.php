<div>
	<?php
        echo form_open(base_url() . 'index.php/admin/tax/do_add/', array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'tax_add',
            'enctype' => 'multipart/form-data'
        ));
    ?>
        <div class="panel-body">

            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('tax_type');?></label>
                <div class="col-sm-6">
                    <input type="text" name="title" id="demo-hor-1" 
                        placeholder="<?php echo translate('give a tax name'); ?>" class="form-control required">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('tax_description');?></label>
                <div class="col-sm-6">
                    <input type="text" placeholder="<?php echo translate('description if any'); ?>" name="till" id="demo-hor-1" class="form-control">
                </div>
            </div>
            
 
        </div>
	</form>
</div>

<script src="<?php echo base_url(); ?>template/back/js/custom/brand_form.js"></script>
<!--<script type="text/javascript">
    $('.chos').on('change',function(){
        var a = $(this).val();
        $('.product').hide('slow');
        $('.category').hide('slow');
        $('.sub_category').hide('slow');
        $('.'+a).show('slow');
    });
</script>
-->

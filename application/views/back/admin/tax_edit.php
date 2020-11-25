<?php
	foreach($tax_data as $row){
        //echo "tax_data";
?>
    <div>
        <?php
			echo form_open(base_url() . 'index.php/admin/tax/update/' . $row['tax_id'], array(
				'class' => 'form-horizontal',
				'method' => 'post',
				'id' => 'tax_edit',
				'enctype' => 'multipart/form-data'
			));
		?>
            <div class="panel-body">

                <div class="form-group">
                    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('tax_type');?></label>
                    <div class="col-sm-6">
                        <input type="text" name="title" id="demo-hor-1" value="<?php echo $row['tax_type']; ?>" 
                            placeholder="<?php echo translate('tax_type'); ?>" class="form-control required">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('description');?></label>
                    <div class="col-sm-6">
                        <input type="text" name="till" id="demo-hor-1" value="<?php echo $row['tax_status']; ?>" class="form-control">
                    </div>
                </div>
        
            </div>
        </form>
    </div>

<?php
	}
?>

<script src="<?php echo base_url(); ?>template/back/js/custom/brand_form.js"></script>



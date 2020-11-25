<div>
    <?php
		echo form_open(base_url() . 'index.php/admin/language_settings/do_add_lang/', array(
			'class' => 'form-horizontal',
			'method' => 'post',
			'id' => 'language_add'
		));
	?>
        <div class="panel-body">
            
                <div class="col-lg-2 col-md-2 col-sm-12 col-12 control-label" for="demo-hor-1"><?php echo translate('language_name'); ?></div>
                <div class="col-lg-10 col-md-10 col-sm-12 col-12">
                    <input type="text" name="language" id="demo-hor-1" class="form-control required" placeholder="<?php echo translate('new_language'); ?>" >
                </div>
            
        </div>
	</form>
</div>

<script>
	$(document).ready(function() {
	    $("form").submit(function(e) {
	        return false;
	    });
	});
</script>
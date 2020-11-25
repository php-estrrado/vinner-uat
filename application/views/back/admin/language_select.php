<form id="lang_select">
    <div class="col-sm-12 form-horizontal" style="margin-top:10px !important;">
    	
        
            <label class="col-lg-2 col-md-2 col-sm-12 col-12 control-label" for="demo-hor-inputemail">
				<?php echo translate('select_language'); ?>
            </label>
            <div class="col-lg-10 col-md-10 col-sm-12 col-12">
                <select name="language" class="demo-cs-multiselect" onchange="ajax_set_list(this.value);">
                <?php
                    $set_lang = $this->db->get_where('general_settings',array('type'=>'language'))->row()->value;
                    $fields = $this->db->list_fields('language');
                    foreach ($fields as $field)
                    {
                        if($field !== 'word' && $field !== 'word_id'){
                ?>
                    <option value="<?php echo $field; ?>" 
                        <?php if($set_lang == $field){ echo 'selected'; } ?> >
                            <?php echo ucfirst($field); ?>
                    </option>
                <?php
                        }
                    }
                ?>
                </select>
            </div>
        
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function() {
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
    });
</script>
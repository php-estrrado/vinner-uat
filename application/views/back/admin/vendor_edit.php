<?php

	foreach($vendor_data as $row){

?>

    <div>

        <?php
			echo form_open(base_url() . 'index.php/admin/vendor/update/' . $row['vendor_id'], array(
				'class' => 'form-horizontal',
				'method' => 'post',
				'id' => 'vendor_edit',
				'enctype' => 'multipart/form-data', 'autocomplete'=>"off"
			));

		?>

            <div class="panel-body">

                <div class="form-group">
                    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('display_name');?></label>
                    <div class="col-sm-6">
                        <input type="text" name="disname" id="demo-hor-1" value="<?php echo $row['display_name']; ?>" placeholder="<?php echo translate('display_name'); ?>" class="form-control required">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label" for=""><?php echo translate('name');?></label>
                    <div class="col-sm-6">
                        <input type="text" name="name" id="" value="<?php echo $row['name']; ?>" placeholder="<?php echo translate('name'); ?>" class="form-control required">
                    </div>
                </div>
                <div class="form-group">

                <label class="col-sm-4 control-label"><?php echo translate('country');?></label>

                <div class="col-sm-6"> 

                    <?php echo $this->crud_model->select_html_data('countries','country','name','edit','demo-chosen-select required',$row['country_code']); ?>

                    <div  id='email_note' style="color:red;"> </div>

                </div>

            </div>
                 <div class="form-group">

                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('address');?></label>

                <div class="col-sm-6">
                    <textarea id="" name="address" class="form-control required" rows="4" cols="40">
                        <?php echo $row['address1']; ?>
                    </textarea>

                </div>

            </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label" for=""><?php echo translate('phone');?></label>
                    <div class="col-sm-6">
                        <input type="text" name="phone" id="" value="<?php echo $row['mobile']; ?>" placeholder="<?php echo translate('phone'); ?>" class="form-control required">
                    </div>
                </div>    
                <div class="form-group">
                    <label class="col-sm-4 control-label" for=""><?php echo translate('email');?></label>
                    <div class="col-sm-6">
                        <input type="text" name="email" id="" value="<?php echo $row['email']; ?>" placeholder="<?php echo translate('email'); ?>" class="form-control required">
                    </div>
                </div>            
                <div class="form-group">
                    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('password');?></label>
                    <div class="col-sm-6">
                        <input type="password" id="password" name="password" placeholder="<?php echo translate('password'); ?>" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="form-group" id="deventype" style="display: none">
                    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('Current Vendorship Type');?></label>
                    <div class="col-sm-6">
                    <?php $membershipname = $this->db->get_where('membership', array('membership_id' => $row['membership']))->row()->title; 
                    if($row['membership']==0){$membershipname=translate('default');}
                    ?>
                        <input type="text" name="" id="" value="<?php echo $membershipname; ?>" placeholder="<?php echo translate(''); ?>" class="form-control " readonly>
                    </div>
                </div>
                <div class="form-group" style="display: none">
                    <label class="col-sm-4 control-label" for="">
                        <?php echo translate('Change Vendorship Type');?>
                    </label>
                    <div class="col-sm-6">
                        <input id="member_change" type="checkbox" name="member_change" value="change" class="form-horizontal">
                    </div>
                </div>

            <div class="form-group" id='membership_up' hidden>
                 <label class="col-sm-4 control-label"><?php echo translate('New Vendorship Type');?>
                 </label>
                <div class="col-sm-6">
                   <select name="membership" id="type" class="demo-chosen-select" >
                    <option value="0" <?php $e_match = $row['membership']; 
                                  if ($e_match == 0) {  $e_match = 'free'; }
                                  if ($e_match == 0) { echo 'selected="selected"'; } 
                                 ?> ><?php echo translate('default');?>
                    </option> 
                    <?php
                        $memberships = $this->db->get('membership')->result_array();
                         foreach ($memberships as $row1) {
                                    ?>
                    <option value="<?php echo $row1['membership_id']; ?>"  <?php if ($row1['membership_id'] == $e_match) { echo 'selected="selected"'; } ?> >
                        <?php echo $row1['title']; ?>
                    </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

                <div class="form-group" hidden>
                    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('expire_date');?></label>
                    <div class="col-sm-6">
                        <input type="text" name="exp" id="exp" value="<?php  echo date('d/m/Y', $row['member_expire_timestamp']); ?>" class="form-control" readonly>
                    </div>
                </div>

               <div class="form-group" hidden>
                    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('expire_date');?></label>
                    <div class="col-sm-6">
                        <input type="text" name="" id="" value="<?php  echo date('d/m/Y', $row['member_expire_timestamp']); ?>" class="form-control" readonly>
                    </div>
                </div>

            </div>
        </form>
    </div>

<?php

	}

?>



<script src="<?php echo base_url(); ?>template/back/js/custom/brand_form.js"></script>
<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>

<script type="text/javascript">
    
/*$('#till').datepicker({
dayOfWeekStart : 1,
lang:'en',
timepicker:false,
format:'yyyy-mm-dd',
startDate:  '2017/01/05'
});*/




    $('#member_change').on('change', function() 
    { 
    if (this.checked) 
    {
    $("#membership_up").show();

    }
    else
    {
      $("#membership_up").hide();
    }
    });
</script>





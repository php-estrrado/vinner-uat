<?php

	foreach($demo_req_data as $row){ 

?>

    <div>

        <?php

			echo form_open(base_url() . 'index.php/admin/demo_request/update/' . $row['id'], array(

				'class' => 'form-horizontal',

				'method' => 'post',

				'id' => 'request_demo_edit',

				'enctype' => 'multipart/form-data'

			));

		?>

            <div class="panel-body">



                <div class="form-group">

                    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('name');?></label>

                    <div class="col-sm-6">

                        <input type="text" name="name" id="demo-hor-1" value="<?php echo $row['name']; ?>" 

                            placeholder="<?php echo translate('name'); ?>" class="form-control required">

                    </div>

                </div>
                <div class="form-group">

                    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('email');?></label>

                    <div class="col-sm-6">

                        <input type="text" name="email" id="demo-hor-1" value="<?php echo $row['email']; ?>" 

                            placeholder="<?php echo translate('email'); ?>" class="form-control required">

                    </div>

                </div>
                <div class="form-group">

                    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('phone');?></label>

                    <div class="col-sm-6">

                        <input type="text" name="phone" id="demo-hor-1" value="<?php echo $row['mobile']; ?>" 

                            placeholder="<?php echo translate('phone'); ?>" class="form-control required">

                    </div>

                </div>

                <div class="form-group">

                    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('city');?></label>

                    <div class="col-sm-6">

                        <input type="text" name="city" id="demo-hor-1" value="<?php echo $row['city']; ?>" 

                            placeholder="<?php echo translate('city'); ?>" class="form-control required">

                    </div>

                </div>


            <div class="form-group">

                <label class="col-sm-4 control-label"><?php echo translate('country');?></label>

                <div class="col-sm-6"> 

                    <?php echo $this->crud_model->select_html_data('countries','country','name','edit','demo-chosen-select required',$row['country']); ?>

                    <div  id='email_note' style="color:red;"> </div>

                </div>

            </div>


            <div class="form-group">

                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('date');?></label>

                <div class="col-sm-6">

                    <input type="text" name="date" id="till" value="<?php echo date('d-m-Y', strtotime($row['date'])); ?>" class="form-control required">

                </div>

            </div>

             <div class="form-group">

                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('time');?></label>

                <div class="col-sm-6">

                    <input type="time" name="time"  id="" value="<?php echo date('H:i', strtotime($row['time'])); ?>" class="form-control">

                </div>
            </div>

            <div class="form-group">

                <label class="col-sm-4 control-label"><?php echo translate('product');?></label>

                <div class="col-sm-6"> 

                    <?php echo $this->crud_model->select_html('product','product','title','edit','demo-chosen-select required',$row['product_id'],'request_demo',1); ?>

                    <div  id='email_note' style="color:red;"> </div>

                </div>

            </div>
            <div class="form-group">

                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('remarks');?></label>

                <div class="col-sm-6">
                    <textarea id="" name="remarks" class="form-control required" rows="4" cols="40"><?php echo $row['remarks']; ?></textarea>

                </div>

            </div>

            </div>

        </form>

    </div>



<?php

	}

?>



<script src="<?php echo base_url(); ?>template/back/js/custom/brand_form.js"></script>
<!-- <script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-timepicker/bootstrap-timepicker.js"></script> -->
<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>



<script type="text/javascript">
    
$('.timepicker').timepicker({
          use24hours: true
        });

$('#till').datepicker({
dayOfWeekStart : 1,
lang:'en',
timepicker:false,
format:'dd-mm-yyyy',
startDate:  '05/01/2017'
});

 // $('#rangetime').timepicker({
 //    showInputs: false
 //  });

  // $('#timepicker').timepicker();



// $('#petalert').delay(2500).fadeOut('slow');

 //$("#timepicker").timepicker({format: 'HH:mm:ss'});
</script>





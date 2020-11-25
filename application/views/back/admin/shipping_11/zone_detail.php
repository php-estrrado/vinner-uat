<div><?php
    $id             =   ($operator)? $operator->id : 0;
    $name           =   ($operator)? $operator->operator : ''; 
    $phone          =   ($operator)? $operator->phone : ''; 
    $email          =   ($operator)? $operator->email : ''; 
    $address        =   ($operator)? $operator->address : ''; 
    $country        =   ($operator)? $operator->country_id : ''; 
    $state          =   ($operator)? $operator->state_id : ''; 
    $city           =   ($operator)? $operator->city_id : ''; 
    $haveTrackLink  =   ($operator)? $operator->have_track_link : 0;
    $trackLink      =   ($operator)? $operator->track_link : ''; 
    if($operator    &&  $operator->logo != NULL){ $logo = 'uploads/shipping_operators/'.$operator->logo; }else{ $logo = 'uploads/others/photo_default.png'; }
    echo form_open(base_url() . 'admins/shipping/operators/save/', array( 'class' => 'form-horizontal', 'method' => 'post', 'id' => 'operator_form', 'enctype' => 'multipart/form-data' ));  ?>
        <div class="panel-body">
            <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $id?>" />
                <label class="col-sm-4 control-label" for="operator"><?php echo translate('operator_name');?></label>
                <div class="col-sm-6">
                    <input type="text" name="operator" id="operator" placeholder="<?php echo translate('operator_name'); ?>" class="form-control required" value="<?php echo $name?>" />
                   <span id='error_operator' class="error_msg" style="color:red;"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="logo"><?php echo translate('operator_logo');?></label>
                <div class="col-sm-6">
                    <span class="pull-left btn btn-default btn-file">
                        <?php echo translate('select_operator_logo');?>
                        <input type="file" name="logo" id='logo' accept="image/*">
                    </span>
                    <br><br>
<!--                    <em>(image size 130 X 100)</em>-->
                    <span id='wrap' class="pull-left" >
                        <img src="<?php echo base_url($logo); ?>" width="48.5%" id='logo_img' > 
                    </span>
                </div>
            </div>

<!--            <div class="form-group">
                <label class="col-sm-4 control-label" for="logo_alt"><?php echo translate('logo_alt_text');?></label>
                <div class="col-sm-6">
                <input type="text" name="logo_alt" id="logo_alt" class="form-control totals" placeholder="Alt Text">
                </div>
            </div>-->

            <div class="form-group">
                <label class="col-sm-4 control-label" for="phone"><?php echo translate('phone');?></label>
                <div class="col-sm-6">
                    <input type="text" name="phone" id="demo-hor-1" placeholder="<?php echo translate('phone'); ?>" class="form-control number required" value="<?php echo $phone?>">
                    <span id='error_phone' class="error_msg"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="email"><?php echo translate('email');?></label>
                <div class="col-sm-6">
                   <input type="text" name="email" id="email" placeholder="<?php echo translate('email'); ?>" class="form-control required" value="<?php echo $email?>">
                   <span id='error_email' class="error_msg"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="address"><?php echo translate('address');?></label>
                <div class="col-sm-6">
                    <textarea name="address" id="address" placeholder="<?php echo translate('address'); ?>" class="form-control required"><?php echo $address?></textarea>
                   <span id='error_address' class="error_msg"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="country_id"><?php echo translate('country');?></label>
                <div class="col-sm-6">
                    <select id="country_id" name="country_id" class="form-control demo-chosen-select get-data required" data-type='states' data-label="state"><?php
                        if($countries){ foreach($countries as $k=>$row){ ?>
                            <option value="<?php echo $k?>" <?php if($k == $country){ echo 'selected="selected"'; } ?>><?php echo $row?></option><?php
                        } } ?>
                    </select>
                   <span id='error_country_id' class="error_msg"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="state_id"><?php echo translate('state');?></label>
                <div class="col-sm-6">
                    <select id="state_id" name="state_id" class="form-control demo-chosen-select get-data required" data-type="cities" data-label="city"><?php
                        if($states){ foreach($states as $k=>$row){ ?>
                            <option value="<?php echo $k?>" <?php if($k == $state){ echo 'selected="selected"'; } ?>><?php echo $row?></option><?php
                        } } ?>
                    </select>
                   <span id='error_state_id' class="error_msg"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="city_id"><?php echo translate('city');?></label>
                <div class="col-sm-6">
                    <select id="city_id" name="city_id" class="form-control demo-chosen-select required" data-type=""><?php
                        if($cities){ foreach($cities as $k=>$row){ ?>
                            <option value="<?php echo $k?>" <?php if($k == $city){ echo 'selected="selected"'; } ?>><?php echo $row?></option><?php
                        } } ?>
                    </select>
                   <span id='error_city_id' class="error_msg"></span>
                </div>
            </div>

            <div class="form-group btm_border">
                <label class="col-sm-4 control-label" for="have_track_link"><?php echo "Have Tracking link?";?></label>
                <div class="col-sm-6">
                <div class="radio" id="have_track" >
                <label><input type="radio" id="tlYes" name="have_track_link" value="1" <?php if($haveTrackLink==1){ echo 'checked="checked"';}?>" >Yes</label>
                <label><input type="radio" id="tlNo" name="have_track_link"  value="0" <?php if($haveTrackLink==0){ echo 'checked="checked"'; }?>">No</label>
                </div>
                </div>
            </div>

            <div id="tlDiv" class="form-group" <?php if($haveTrackLink == 0){ echo 'style="display: none;"'; }?>>
                <label class="col-sm-4 control-label" for="track_link"><?php echo translate('tracking_link');?></label>
                <div class="col-sm-6">
                    <input type="text" name="track_link" id="track_link" class="form-control" placeholder="<?php echo translate('tracking_link');?>" value="<?php echo $trackLink?>">
                    <span id='error_track_link' class="error_msg"></span>
                </div>
            </div>


        </div>
    <div id="btn-area" style="">
                <button id="saveOperator" data-bb-handler="success" type="button" class="btn btn-purple">Submit</button>
        </div>
	<?php echo form_close(); ?>

</div>



<script type="text/javascript">
    
    $(document).ready(function(){
        
    });

</script>

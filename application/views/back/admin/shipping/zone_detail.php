<div><?php
    $id             =   ($zone)? $zone->id : 0;
    $title          =   ($zone)? $zone->title : ''; 
    $country        =   ($zone)? $zone->country_id : ''; 
    $poerator       =   ($zone)? $zone->operator_id : ''; 
    $created        =   ($zone)? $zone->created : ''; 
    $modified       =   ($zone)? $zone->modified : '';
    $minWeight      =   ($zone)? $zone->min_weight : '';
    $maxWeight      =   ($zone)? $zone->max_weight : '';
    $minDays        =   ($zone)? $zone->min_days : '';
    $maxDays        =   ($zone)? $zone->max_days : '';
    $cost           =   ($zone)? $zone->cost : '';
    $deliDate       =   ($zone)? $zone->day_of_delivery : '';
    $status         =   ($zone)? $zone->status : 1;
    echo form_open(base_url() . 'admins/shipping/zones/save/', array( 'class' => 'form-horizontal', 'method' => 'post', 'id' => 'zone_form', 'enctype' => 'multipart/form-data' ));  ?>
        <div class="panel-body">
            <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $id?>" /><input type="hidden" id="optId" name="optId" value="<?php echo $poerator?>" />
                <label class="col-sm-4 control-label" for="title"><?php echo translate('title');?></label>
                <div class="col-sm-6">
                    <input type="text" name="title" id="title" placeholder="<?php echo translate('title'); ?>" class="form-control required" value="<?php echo $title?>" />
                   <span id='error_title' class="error_msg"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="country_id"><?php echo translate('country');?></label>
                <div class="col-sm-6"> 
                    <select id="country_id" name="country_id" class="form-control demo-chosen-select get-data required">
                        <option value="" data-currency="AED">Select Country</option><?php
                        if($countries){ foreach($countries as $row){ ?>
                            <option value="<?php echo $row->id?>" <?php if($row->id == $country){ echo 'selected="selected"'; } ?> data-currency="<?php echo $row->currency?>"><?php echo $row->name?></option><?php
                        } } ?>
                    </select>
                   <span id='error_country_id' class="error_msg"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="operator_id"><?php echo translate('operator');?></label>
                <div class="col-sm-6">
                    <select id="operator_id" name="operator_id" class="form-control demo-chosen-select required" data-type="cities" data-label="city"><?php
                        if($operators){ foreach($operators as $k=>$row){ ?>
                            <option value="<?php echo $k?>" <?php if($k == $poerator){ echo 'selected="selected"'; } ?>><?php echo $row?></option><?php
                        } } ?>
                    </select>
                   <span id='error_operator_id' class="error_msg"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="min_weight"><?php echo translate('min._weight');?></label>
                <div class="col-sm-6">
                    <div class="col-sm-9"> <div class="row">
                        <input type="text" name="min_weight" id="min_weight" placeholder="<?php echo translate('minimum_weight'); ?>" class="form-control number required" value="<?php echo $minWeight?>" />
                   </div></div>
                    <div class="col-sm-3"> <div class="row">
                        <input type="text" class="form-control"  value="Kg" disabled="" />
                    </div></div>
                    <span id='error_min_weight' class="error_msg"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="max_weight"><?php echo translate('max._weight');?></label>
                <div class="col-sm-6">
                    <div class="col-sm-9"> <div class="row">
                        <input type="text" name="max_weight" id="max_weight" placeholder="<?php echo translate('maximum_weight'); ?>" class="form-control number required" value="<?php echo $maxWeight?>" />
                    </div></div>
                    <div class="col-sm-3"> <div class="row">
                        <input type="text" class="form-control"  value="Kg" disabled="" />
                    </div></div>
                    <span id='error_max_weight' class="error_msg"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="cost"><?php echo translate('cost');?></label>
                <div class="col-sm-6">
                    <div class="col-sm-9"> <div class="row">
                        <input type="text" name="cost" id="cost" placeholder="<?php echo translate('cost'); ?>" class="form-control number required" value="<?php echo $cost?>" />
                    </div></div>
                    <div class="col-sm-3"> <div class="row">
                            <input type="text" id="z-currency" class="form-control"  value="<?php echo currency()?>" disabled="" />
                    </div></div>
                    <span id='error_cost' class="error_msg"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="title"><?php echo translate('delivery_duration');?></label>
                <div class="col-sm-6">
                    <div class="col-sm-4 col-8"><div class="row">
                            <input type="text" id="min_days" name="min_days" step="1" min="1" max="15" value="<?php echo $minDays?>" class="form-control numberonly" />
                    </div></div>
                    <div class="col-sm-2 col-4" style="line-height: 40px">To</div>
                    <div class="col-sm-4 col-8"><div class="row">
                            <input type="text" id="max_days" name="max_days" step="1" min="1" max="15" value="<?php echo $maxDays?>" class="form-control numberonly" />
                    </div></div>
                    <div class="col-sm-2 col-4" style="line-height: 40px">Day(s)</div>
                    <div class="clr"></div>
                   <span id='error_min_days' class="error_msg"></span>
                   <div class="clr"></div>
                </div>
            </div>
<!--            <div class="form-group">
                <label class="col-sm-4 control-label" for="title"><?php echo translate('day_of_delivery');?></label>
                <div class="col-sm-6">
                    <input type="text" name="day_of_delivery" id="day_of_delivery" placeholder="<?php echo translate('day_of_delivery'); ?>" class="form-control required" value="<?php echo $deliDate?>" />
                   <span id='error_day_of_delivery' class="error_msg"></span>
                </div>
            </div>-->
            <div class="form-group">
                <label class="col-sm-4 control-label" for="status"><?php echo translate('status');?></label>
                <div class="col-sm-6">
                    <select id="status" name="status" class="form-control demo-chosen-select required" data-type="">
                        <option value="1" <?php if($status == 1){ echo 'selected="selected"'; }?>><?php echo translate('active');?></option>
                        <option value="0" <?php if($status == 0){ echo 'selected="selected"'; }?>><?php echo translate('inactive');?></option>
                    </select>
                   <span id='error_status' class="error_msg"></span>
                </div>
            </div>
        </div>
        <div id="btn-area" style="">
                <button id="saveZone" data-bb-handler="success" type="button" class="btn btn-purple">Submit</button>
        </div>
	<?php echo form_close(); ?>

</div>



<script type="text/javascript">
    
    $(document).ready(function(){ 

    });

</script>

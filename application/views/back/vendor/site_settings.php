
<div id="content-container"> 
    <div id="page-title">
        <h1 class="page-header text-overflow"><?php echo translate('manage_site');?></h1>
    </div>
    <div class="tab-base">
        <div class="panel">
            <div class="tab-base tab-stacked-left">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#demo-stk-lft-tab-2"><?php echo translate('warehouse_images');?></a>
                    </li>
					
                    <li>
                        <a data-toggle="tab" href="#address-stk-lft-tab-4"><?php echo translate('address');?></a>
                    </li> <?php /*
                    <li>
                        <a data-toggle="tab" href="#demo-stk-lft-tab-5"><?php echo translate('SEO');?></a>
                    </li>
					*/ ?>
                </ul>

                <div class="tab-content bg_grey">
                    <span id="genset"></span>
                    <div id="demo-stk-lft-tab-2" class="tab-pane fade active in">
                        <div class="col-md-12 nopad">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo translate('warehouse_images');?></h3>
                                </div>
                            <?php
                                echo form_open(base_url() . 'index.php/vendor/vendor_images/', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post',
                                    'id' => '',
                                    'enctype' => 'multipart/form-data'
                                ));
                            ?>
                                <div class="form-group margin-top-10">
                                    <label class="col-sm-3 control-label margin-top-10" for="demo-hor-inputemail"><h5>Logo</h5> <br><i>(suggested width:height - 300px:300px*)</i></label>
                                    <div class="col-sm-9">
                                        <div class="col-sm-2">
											<?php
												if(!file_exists('uploads/vendor/logo_'.$this->session->userdata('vendor_id').'.png'))
												{
													$vimage=base_url('uploads/vendor/logo_0.png'); 
												}
												else
												{
													$vimage=base_url('uploads/vendor/logo_'.$this->session->userdata('vendor_id').'.png'); 
												}

                							 ?>
                                            <img class="img-responsive img-md img-border" src="<?php echo $vimage; ?>" id="blah" style="width:auto !important;" >
                                        </div>
                                        <div class="col-sm-2">
                                        <span class="pull-left btn btn-default btn-file margin-top-10">
                                            <?php echo translate('select_logo');?>
                                            <input type="file" name="logo" class="form-control" id="imgInp">
                                        </span>
                                        </div>
                                        <div class="col-sm-5"></div>
                                    </div>
                                </div><hr>
                                <div class="form-group margin-top-10">
                                    <label class="col-sm-3 control-label margin-top-10" for="demo-hor-inputemail"><h5>Banner</h5> <br><i>(suggested width:height - 1000px:500px*)</i></label>
                                    <div class="col-sm-9">
                                        <div class="col-sm-12">
											<?php
												if(!file_exists('uploads/vendor/banner_'.$this->session->userdata('vendor_id').'.jpg'))
												{
													$vbaner=base_url('uploads/vendor/banner_0.jpg'); 
												}
												else
												{
													$vbaner=base_url('uploads/vendor/banner_'.$this->session->userdata('vendor_id').'.jpg'); 
												}

                							 ?>
                                            <img class="img-responsive img-lg img-border" src="<?php echo $vbaner; ?>" id="blahn" style="width:auto !important;">
											
                                        </div>
                                        <div class="col-sm-6">
                                        <span class="pull-left btn btn-default btn-file margin-top-10">
                                            <?php echo translate('select_banner');?>
                                            <input type="file" name="banner" class="form-control" id="imgInpn">
                                        </span>
                                        </div>
                                        <div class="col-sm-5"></div>
                                    </div>
                                </div>
                                <br />
                                <div class="panel-footer text-right">
                                    <span class="btn btn-success btn-labeled fa fa-check submitter"  data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>'>
                                        <?php echo translate('save');?>
                                    </span>
                                </div>
                            </form> 
                            </div>              
                        </div>
                    </div>
                
                    <!--UPLOAD : SOCIAL LINKS---------->
                    <div id="address-stk-lft-tab-4" class="tab-pane fade <?php if($tab_name=="social_links") {?>active in<?php } ?>">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo translate('invoice_address');?></h3>
                            </div>
							<?php
                                echo form_open(base_url() . 'vendor/social_links/set/', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post',
                                    'id' => '',
                                    'enctype' => 'multipart/form-data'
                                ));
                            ?>
                                <div class="panel-body">
                                    <div class="form-group mar-btm">
                                        <label class="col-sm-3 control-label">Display Name</label>
                                        <div class="col-sm-6">
                                            <input type="text" id="display_name" name="display_name" value="<?php echo $vendor->display_name?>" class="form-control required">
                                        </div>
                                    </div>
                                    <div class="form-group mar-btm">
                                        <label class="col-sm-3 control-label">Email</label>
                                        <div class="col-sm-6">
                                            <input type="text" id="email" name="email" value="<?php echo $vendor->email?>" class="form-control required">
                                        </div>
                                    </div>
                                    <div class="form-group mar-btm">
                                        <label class="col-sm-3 control-label">Address Line1</label>
                                        <div class="col-sm-6">
                                            <input type="text" id="address1" name="address1" value="<?php echo $vendor->address1?>" class="form-control required">
                                        </div>
                                    </div>
                                    <div class="form-group mar-btm">
                                        <label class="col-sm-3 control-label">Address Line2</label>
                                        <div class="col-sm-6">
                                            <input type="text" id="address2" name="address2" value="<?php echo $vendor->address2?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group mar-btm">
                                        <label class="col-sm-3 control-label">Country</label>
                                        <div class="col-sm-6">
                                            <?php echo form_dropdown('country_code', $countries, $vendor->country_code,['id'=>'country_id','class'=>'form-control get-data required','data-type'=>'states','data-label'=>'state']); ?>
                                        </div>
                                    </div>
                                    <div class="form-group mar-btm">
                                        <label class="col-sm-3 control-label">State</label>
                                        <div class="col-sm-6">
                                            <?php echo form_dropdown('zone_id', $states, $vendor->zone_id,['id'=>'state_id','class'=>'form-control get-data required','data-type'=>'cities','data-label'=>'city']); ?>
                                        </div>
                                    </div>
                                    <div class="form-group mar-btm">
                                        <label class="col-sm-3 control-label">City</label>
                                        <div class="col-sm-6">
                                            <?php echo form_dropdown('city', $cities, $vendor->city,['id'=>'city_id','class'=>'form-control']); ?>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                   
                                <!--SAVE---------->
                                <div class="panel-footer text-right">
                                    <span class="btn btn-success btn-labeled fa fa-check submitter"  data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>'>
                                        <?php echo translate('save');?>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="display:none;" id="site"></div>
<!-- for logo settings -->
<script>
    function load_logos(){
        ajax_load('<?php echo base_url(); ?>index.php/vendor/logo_settings/show_all','list','');
    }
    function load_dropzone(){
        //$('#dropz').remove();
        //$('#drpzu').append('<div class="col-sm-10" id="dropz"></div>');
        //$('#dropz').load('<?php echo base_url(); ?>index.php/vendor/load_dropzone');
        // DROPZONE.JS
        // =================================================================
        // Require Dropzone
        // http://www.dropzonejs.com/
        // =================================================================
        Dropzone.options.demoDropzone = { // The camelized version of the ID of the form element
            // The configuration we've talked about above
            autoProcessQueue: true,
            uploadMultiple: true,
            parallelUploads: 25,
            maxFiles: 25,
    
            // The setting up of the dropzone
            init: function() {
                var myDropzone = this;
                this.on("queuecomplete", function (file) {
                    load_logos();
                });
            }
        }
        load_logos();
    }

	$(document).ready(function() {
		
        $('.summernotes').each(function() {
            var now = $(this);
            var h = now.data('height');
            var n = now.data('name');
            now.closest('div').append('<input type="hidden" class="val" name="'+n+'">');
            now.summernote({
                height: h,
                onChange: function() {
                    now.closest('div').find('.val').val(now.code());
                }
            });
			now.closest('div').find('.val').val(now.code());
			now.focus();
        });
        load_dropzone();
        load_logos();
		
	});

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#wrap').hide('fast');
                $('#blah').attr('src', e.target.result);
                $('#wrap').show('fast');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp").change(function(){
        readURL(this);
    });

    function readURLn(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blahn').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInpn").change(function(){
        readURLn(this);
    });


    var base_url = '<?php echo base_url(); ?>'
    var user_type = 'vendor';
    var module = 'logo_settings';
    var list_cont_func = 'show_all';
    var dlt_cont_func = 'delete_logo';
</script>
<!-- for logo settings -->



<script type="text/javascript">

    $(document).ready(function() {
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
        
        $('body').on('change','.get-data',function(){
            var id          =   this.id;
            var type        =   $(this).attr('data-type');
            var label       =   $(this).attr('data-label');
            var csrfName    =   '<?php echo $this->security->get_csrf_token_name(); ?>',
                csrfHash    =   '<?php echo $this->security->get_csrf_hash(); #?>';
            $.ajax({
                type: "POST",
                url: '<?php echo base_url('warehouse/product/getData/')?>'+type+'/'+this.value ,
                data: {[csrfName]: csrfHash, id: this.id, label: label},
                success: function (data) { 
                    $('#'+label+'_id').html(data);
                    if(label == 'state'){ $('#city_id').html('<option value="">Select City</option>'); }
                //    $('.demo-chosen-select').chosen();
                    
                }
            }); 
        });
    });



    $(".range-def").on('slide', function(){
        var vals    = $("#nowslide").val();
        $(this).closest(".form-group").find(".range-def-val").html(vals);
        $(this).closest(".form-group").find("input").val(vals);
    });

    function sets(now){
        $(".range-def").each(function(){
            var min = $(this).data('min');
            var max = $(this).data('max');
            var start = $(this).data('start');
            $(this).noUiSlider({
                start: Number(start) ,
                range: {
                    'min': Number(min),
                    'max': Number(max)
                }
            }, true);
            if(now == 'first'){
                $(this).noUiSlider({
                    start: 500 ,
                    connect : 'lower',
                    range: {
                        'min': 0 ,
                        'max': 10
                    }
                },true).Link('lower').to($("#nowslide"));
                $(this).closest(".form-group").find(".range-def-val").html(start);
                $(this).closest(".form-group").find("input").val(start);
            } else if(now == 'later'){
                var than = $(this).closest(".form-group").find(".range-def-val").html();
                
                if(than !== 'undefined'){
                    $(this).noUiSlider({
                        start: than,
                        connect : 'lower',
                        range: {
                            'min': min ,
                            'max': max
                        }
                    },true).Link('lower').to($("#nowslide"));
                } 
                $(this).closest(".form-group").find(".range-def-val").html(than);
                $(this).closest(".form-group").find("input").val(than);
            }
        });
    }
	$(document).ready(function() {
        sets('later');
		$("form").submit(function(e){
			return false;
		});

	});
</script>
<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js">
</script>
<style>
.img-fixed{
	width: 100px;	
}
.tr-bg{
background-image: url(http://www.mikechambers.com/files/html5/canvas/exportWithBackgroundColor/images/transparent_graphic.png)	
}

.cc-selector input{
    margin:0;padding:0;
    -webkit-appearance:none;
       -moz-appearance:none;
            appearance:none;
}
 
.cc-selector input:active +.drinkcard-cc
{
	opacity: 1;
	border:4px solid #169D4B;
}
.cc-selector input:checked +.drinkcard-cc{
	-webkit-filter: none;
	-moz-filter: none;
	filter: none;
	border:4px solid black;
}
.drinkcard-cc{
	cursor:pointer;
	background-size:contain;
	background-repeat:no-repeat;
	display:inline-block;
	-webkit-transition: all 100ms ease-in;
	-moz-transition: all 100ms ease-in;
	transition: all 100ms ease-in;
	-webkit-filter:opacity(.3);
	-moz-filter:opacity(.3);
	filter:opacity(.3);
	transition: all .6s ease-in-out;
	border:4px solid transparent;
	border-radius:5px !important;
}
.drinkcard-cc:hover{
	-webkit-filter:opacity(1);
	-moz-filter: opacity(1);
	filter:opacity(1);
	transition: all .6s ease-in-out;
	border:4px solid #8400C5;
			
}

</style>


<div id="content-container">
	<div id="page-title">
		<h1 class="page-header text-overflow"><?php echo translate('shipping_zones');?></h1>
	</div>
	<div class="tab-base">
		<div class="panel">
			<div class="panel-body">
				<div class="tab-content">
                                    <div class="col-md-12">
                            <button class="btn btn-info btn-labeled fa fa-step-backward pull-right pro_list_btn" 
                                style="display:none;"  onclick="ajax_set_list();  proceed('edit');"><?php echo translate('back_to_zone_list');?>
                            </button>
                            <a id="addBtn" class="btn btn-primary btn-labeled fa fa-plus-circle add_pro_btn pull-right addBtn" data-toggle="tooltip" 
                                    onclick="ajax_modal('edit','<?php echo translate('create_zone')?>','<?php echo translate('zone_created!')?>','zone_detail','0')" data-original-title="<?php echo translate('create_zone');?>" data-container="body">
                                        <?php echo translate('Create New')?>
                        </a>

                                    </div>
					<br>
                    <!-- LIST -->
                    <div class="tab-pane fade active in" id="list" style="border:1px solid #ebebeb; border-radius:4px;">
                        <?php  include 'zone_list.php' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
//    var base_url = '<?php echo base_url(); ?>';
//
//    var timer = '<?php $this->benchmark->mark_time(); ?>';
//
//    var user_type = 'admin';
//
//    var module = 'shippingOperator';
//
//    var list_cont_func = 'list';
//
//    var dlt_cont_func = 'delete';

    function proceed(type){
        if(type == 'to_list'){
                $(".pro_list_btn").show();  $(".add_pro_btn").hide();
        } else if(type == 'to_add'){
                $(".add_pro_btn").show(); $(".pro_list_btn").hide();
        }
    }
    
    $(document).ready(function(){
        $('#addBtn').on('click',function(){ 
           var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
               csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
               $('.modal-body').html('<div style="width: 32px; margin: 20px auto; text-align: center;"><img src="<?php echo base_url('uploads/others/loader.gif')?>" alt="Loading..." /></div>'); 
           $.ajax({
                    type: "POST",
                    url: '<?php echo base_url('admins/shipping/operators/details/0')?>' ,
                    data: {[csrfName]: csrfHash, id: 0},
                    success: function (data) {
                        $('.modal-body').html(data);
                    }
                });
       });
       
       $('body').on('click','#operators-table .editBtn',function(){
            $('#can_submit').val(0);
           var id       =   this.id.replace('edit_',''); 
           var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
               csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
               $('.modal-body').html('<div style="width: 32px; margin: 20px auto; text-align: center;"><img src="<?php echo base_url('uploads/others/loader.gif')?>" alt="Loading..." /></div>'); 
           $.ajax({
                    type: "POST",
                    url: '<?php echo base_url('admins/shipping/operators/details/')?>'+id ,
                    data: {[csrfName]: csrfHash, id: id},
                    success: function (data) {
                        $('.modal-body').html(data);
                        var buttons     =   $('#btn-area').html();
                        $('.modal-footer button').css('visibility','hidden'); $('.modal-footer button.btn-black').css('visibility','visible');
                    }
                });
       });
       
       $('body').on('click','.modal-footer #saveOperator',function(){
            alert('ssss');
        });
       
       $('body .demo-chosen-select').chosen();
        
        $('body').on('change','.get-data',function(){
            var id          =   this.id;
            var type        =   $(this).attr('data-type');
            var label       =   $(this).attr('data-label');
            var csrfName    =   '<?php echo $this->security->get_csrf_token_name(); ?>',
                csrfHash    =   '<?php echo $this->security->get_csrf_hash(); #?>';
            $.ajax({
                type: "POST",
                url: '<?php echo base_url('admins/shipping/getData/')?>'+type+'/'+this.value ,
                data: {[csrfName]: csrfHash, id: this.id, label: label},
                success: function (data) { 
                    $('#'+label+'_id').html(data);
                    if(label == 'state'){ $('#city_id').html('<option value="">Select City</option>'); }
                }
            }); 
        });
        
        $('body').on('click','#have_track #tlYes',function(){ $('#tlDiv').show(); });
        $('body').on('click','#have_track #tlNo',function(){ $('#tlDiv').hide(); });
        $('body').on('change','#logo',function(){ readURL(this); });
        
        $('body').on('click','#saveOperator',function(){ 
                var form = $('#operator_form'); // alert($('#operator_form').serialize());
                $('.error_msg').html(''); $('#saveOperator').attr('disabled',true);
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url('admins/shipping/operators/validate/')?>',
                    data: form.serialize(),
                    dataType: "json",
                    success: function (data) { 
                        if(data['success'] == 'success'){ $('#operator_form').submit(); return false; }
                        else{ for (var key in data)  $("#error_"+key).html('<p>'+data[key]+'</p>'); }
                        $('#saveOperator').attr('disabled',false);
                        return false;
                    }
                });
          //  }
        });
    });
    
    function readURL(input) { 
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) { $('#'+input.id+'_img').attr('src', e.target.result); $('#'+input.id+'_img').show(); }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

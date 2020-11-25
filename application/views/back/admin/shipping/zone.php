<div id="content-container">
	<div id="page-title">
		<h1 class="page-header text-overflow"><?php echo translate('shipping_charge');?></h1>
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
                                    onclick="ajax_modal('edit','<?php echo translate('create_charge')?>','<?php echo translate('zone_created!')?>','zone_detail','0')" data-original-title="<?php echo translate('create_zone');?>" data-container="body">
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
                    url: '<?php echo base_url('admins/shipping/zones/details/0')?>' ,
                    data: {[csrfName]: csrfHash, id: 0},
                    success: function (data) {
                        $('.modal-body').html(data);
                    }
                });
       });
       
       $('body').on('click','#zones-table .editBtn',function(){
           var id       =   this.id.replace('edit_',''); 
           var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
               csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
               $('.modal-body').html('<div style="width: 32px; margin: 20px auto; text-align: center;"><img src="<?php echo base_url('uploads/others/loader.gif')?>" alt="Loading..." /></div>'); 
           $.ajax({
                    type: "POST",
                    url: '<?php echo base_url('admins/shipping/zones/details/')?>'+id ,
                    data: {[csrfName]: csrfHash, id: id},
                    success: function (data) {
                        $('.modal-body').html(data);
                        var buttons     =   $('#btn-area').html();
                        $('.modal-footer button').css('visibility','hidden'); $('.modal-footer button.btn-black').css('visibility','visible');
                        $('.modal-body #z-currency').val($('.modal-body #country_id').find(':selected').data('currency'));
                    }
                });
       });
       
       
       $('body .demo-chosen-select').chosen();
        
//        $('body').on('change','.get-data',function(){
//            var id          =   this.id;
//            var type        =   $(this).attr('data-type');
//            var label       =   $(this).attr('data-label');
//            var csrfName    =   '<?php echo $this->security->get_csrf_token_name(); ?>',
//                csrfHash    =   '<?php echo $this->security->get_csrf_hash(); #?>';
//            $.ajax({
//                type: "POST",
//                url: '<?php echo base_url('admins/shipping/operatorsData/')?>'+this.value ,
//                data: {[csrfName]: csrfHash, id: this.id, cId: this.value,execpt: $('#optId').val()},
//                success: function (data) { 
//                    $('#operator_id').html(data);
//                }
//            }); 
//        });
        
        $('body').on('change','#logo',function(){ readURL(this); });
        
        $('body').on('click','#saveZone',function(){ 
                var form = $('#zone_form'); // alert($('#zone_form').serialize());
                $('.error_msg').html(''); $('#saveZone').text('Validating...'); $('#saveZone').attr('disabled',true);
            //    $('#country_id').attr('disabled',false);
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url('admins/shipping/zones/validate/')?>',
                    data: form.serialize(),
                    dataType: "json",
                    success: function (data) { 
                        if(data['success'] == 'success'){ $('#saveZone').text('Saving...'); $('#zone_form').submit(); return false; }
                        else{ for (var key in data)  $("#error_"+key).html('<p>'+data[key]+'</p>'); }
                        $('#saveZone').attr('disabled',false);
                         $('#saveZone').text('Submit');
                        return false;
                    }
                });
          //  }
        });
        $('body').on('change','#country_id',function(){
            $('#z-currency').val($(this).find(':selected').data('currency'));
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

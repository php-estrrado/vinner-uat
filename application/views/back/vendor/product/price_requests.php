<div id="content-container">
    <div id="page-title">
            <<h1 class="page-header text-overflow"><?php echo translate('price_change_requests');?></h1>
    </div>
    <div class="tab-base">
        <div class="panel">
            <div class="panel-body">
                <div class="tab-content">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <button class="btn btn-info btn-labeled fa fa-step-backward pull-right pro_list_btn" 
                                style="display:none;"  onclick="ajax_set_list();  proceed('edit');"><?php echo translate('back_to_zone_list');?>
                            </button>
                            <a id="new_req" class="btn btn-primary btn-labeled fa fa-plus-circle add_pro_btn pull-right addBtn" data-toggle="tooltip" 
                                    onclick="ajax_modal('changePrice','<?php echo translate('price_change_request')?>','<?php echo translate('request_submitted_successfully!')?>','price_change_request','0')" data-original-title="<?php echo translate('create_request');?>" data-container="body">
                                        <?php echo translate('Create New')?>
                            </a>

                        </div>
                    </div>
					<br>
                    <!-- LIST -->
                    <?php // echo '<pre>'; print_r($products); echo '</pre>';  ?>
                    <div class="tab-pane fade active in" id="list" style="border:1px solid #ebebeb; border-radius:4px;">
                        <?php  include 'request_list.php' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var base_url = '<?php echo base_url(); ?>';
    var timer = '<?php $this->benchmark->mark_time(); ?>';

//
//    var user_type = 'admin';
//
//    var module = 'shippingOperator';
//
//    var list_cont_func = 'list';
//
//    var dlt_cont_func = 'delete';
    
    $(document).ready(function(){
       $('#new_req').on('click',function(){
           setTimeout(function(){
               $.ajax({
                    type: "GET",
                    url: '<?php echo base_url('vendor/product/changePrice/0')?>',
                    success: function (data) { 
                        $('.modal-body .bootbox-body').html(data);
                        return false;
                    }
                });
           },500);
       });
       
        $('body').on('change','#product',function(){
           $('#prd_id').val($(this).find(':selected').data('id'))
           $('#base_price').val($(this).find(':selected').data('sprice'));
           $('#current_price').val($(this).find(':selected').data('cprice'));
        });
        
        $('body').on('click','#saveRequest',function(){ 
            var form = $('#request_form'); // alert($('#zone_form').serialize());
            $('.error_msg').html(''); $('#saveRequest').text('Validating...'); $('#saveRequest').attr('disabled',true);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url('vendor/product/validateRequest/')?>',
                data: form.serialize(),
                dataType: "json",
                success: function (data) { 
                    if(data['success'] == 'success'){ $('#saveRequest').text('Submitting...'); $('#request_form').submit(); return false; }
                    else{ for (var key in data)  $("#error_"+key).html('<p>'+data[key]+'</p>'); }
                    $('#saveRequest').attr('disabled',false);
                     $('#saveRequest').text('Submit');
                    return false;
                }
            });
        });
    });
       
</script>

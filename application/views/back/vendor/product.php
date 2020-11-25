<div id="content-container">

	<div id="page-title">

		<h1 class="page-header text-overflow"><?php echo translate('manage_product');?></h1>

	</div>

        <div class="tab-base">

            <div class="panel">

                <div class="panel-body">

                    <div class="tab-content">

                        <div class="col-md-12" style="border-bottom: 1px solid #ebebeb;padding: 5px;">
							<!-- 
                            <a href="<?php echo base_url().'index.php/vendor/productimport';?>"> 
                             <button class="btn btn-primary btn-labeled fa fa-upload pull-right" > 
                             <?php echo translate('product CSV_upload');?>  
                             </button>
                            </a> -->

<!--                            <button class="btn btn-primary btn-labeled fa fa-plus-circle add_pro_btn pull-right" 

                                onclick="ajax_set_full('add','<?php echo translate('add_product'); ?>','<?php echo translate('successfully_added!'); ?>','product_add',''); proceed('to_list');"><?php echo translate('create_product');?>

                            </button>-->

                            <button class="btn btn-info btn-labeled fa fa-step-backward pull-right pro_list_btn" 

                                style="display:none;"  onclick="ajax_set_list();  proceed('to_add');"><?php echo translate('back_to_product_list');?>

                            </button>

                        </div>

                    <!-- LIST -->

                    <div class="tab-pane fade active in" id="list" style="border:1px solid #ebebeb; border-radius:4px;">

                        

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<span id="prod"></span>

<script>

	var base_url = '<?php echo base_url(); ?>'

	var user_type = 'vendor';

	var module = 'product';

	var list_cont_func = 'list';

	var dlt_cont_func = 'delete';

    $(document).ready(function(){
        $('body').on('click','#saveRequest',function(){ 
                var form = $('#request_form'); // alert($('#zone_form').serialize());
                $('.error_msg').html(''); $('#saveRequest').text('Validating...'); $('#saveRequest').attr('disabled',true);
            //    $('#country_id').attr('disabled',false);
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
          //  }
        });
        
    });

	function proceed(type){

		if(type == 'to_list'){

			$(".pro_list_btn").show();

			$(".add_pro_btn").hide();

		} else if(type == 'to_add'){

			$(".add_pro_btn").show();

			$(".pro_list_btn").hide();

		}

	}

</script>




<div id="content-container">
	<div id="page-title">
		<h1 class="page-header text-overflow"><?php echo $title;?></h1>
	</div>
	<div class="tab-base">
		<div class="panel">
			<div class="panel-body">
				<div class="tab-content">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary btn-labeled fa fa-plus-circle pull-right" data-toggle="modal" data-target="#exampleModalLong">Add New Certificate</button>
                                    </div>
					<br>
                    <!-- LIST -->
                    <div class="tab-pane fade active in" id="list" style="border:1px solid #ebebeb; border-radius:4px;">
                        <?php  include 'certificate_list.php' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fl" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="clr"></div>
      </div><?php
        echo form_open(base_url() . 'admin/certificates/add/',['class' => 'form-horizontal', 'method' => 'post', 'id' => 'certi_form', 'enctype' => 'multipart/form-data']); ?>
          <div class="modal-body">
            <div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="title"><?php echo translate('title');?></label>
                        <div class="col-sm-8">
                            <input type="text" id="title" class="form-control required" required="" style="height: 32px;" name="title" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="file"><?php echo translate('certificate');?></label>
                        <div class="col-sm-8">
                            <input type="file" id="file" class="form-control required" required="" accept=".doc, .docx,.ppt, .pptx,.pdf,image/*" style="height: 32px;" name="file" />
                        </div>
                    </div>
                </div>
            </div> 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-black" data-dismiss="modal">Close</button>
            <button id="save_certi" type="submit" class="btn btn-purple">Save changes</button>

          </div><?php
        form_close() ?>
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

    function proceed(type){
        if(type == 'to_list'){
                $(".pro_list_btn").show();  $(".add_pro_btn").hide();
        } else if(type == 'to_add'){
                $(".add_pro_btn").show(); $(".pro_list_btn").hide();
        }
    }
    
    $(document).ready(function(){
//        $('#save_certi').on('click',function(){ 
//            $('#certi_form').submit();
//       });
       
        $('.delBtn').on('click',function(){
            var id      =   this.id;
            bootbox.confirm({
            message: "This is a confirm with custom button text and color! Do you like it?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn btn-purple'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) { 
                if(result == true){ window.location.href = '<?php echo base_url('admin/certificates/delete/')?>'+id; }
            }
        });
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

<div class="col-12 mt-4">
    <div class="row">
        <div class="col-12 tar"><button id="addr-modal" type="button" class="ps-btn" data-toggle="modal" data-target="#addrModal"><i class="fa fa-plus"></i> Add Address</button></div>
        <div class="col-12 mt-4"><div class="row"><?php
            if($addresses && count($addresses) >0){ 
                foreach($addresses as $adr){?>
                    <div class="col-md-6">
                        <i class="addr-edit fa fa-edit"></i>
                        <name><strong><?php echo $adr->fname?></strong></name>
                        <div>
                            <?php echo $adr->address1?>
                        </div>
                        <div><?php echo $adr->road_name?></div>
                        <div><?php echo $adr->city?></div>
                        <div><?php echo $adr->name?></div>
                    </div><?php
                }
            }else{ echo '<div class="col-12 tac">No records found,</div>'; } ?>
        </div></div>
    </div>
</div>
<!-- The Modal -->
<div class="modal" id="addrModal">
  <div class="modal-dialog">
    <div class="modal-content">
        <?php echo form_open(base_url('home/address/save'), ['id'=>'addr-form','method'=>'post']) ?>
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Add Address</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="col-12 mb-4">
                    <label for="name" class="">Name</label>
                    <input id="name" name="addr[fname]" class="form-control required" type="text" placeholder="Enter Name">
                    <span id="name_error" class="error"></span>
                </div>
                <div class="col-12 mb-4">
                    <label for="address" class="">Address</label>
                    <input id="address" name="addr[address1]" class="form-control required" type="text" placeholder="Enter Address">
                    <span id="address_error" class="error"></span>
                </div>
                <div class="col-12 mb-4">
                    <label for="road_name" class="">Road Name</label>
                    <input id="road_name" name="addr[road_name]" class="form-control required" type="text" placeholder="Enter Road Name">
                    <span id="road_name_error" class="error"></span>
                </div>
                <div class="col-12 mb-4">
                    <label for="city" class="">City</label>
                    <input id="city"  name="addr[city]" class="form-control required" type="text" placeholder="Enter City Name">
                    <span id="city_error" class="error"></span>
                </div>
                <div class="col-12 mb-4">
                    <label for="landmark" class="">Land Mark</label>
                    <input id="landmark"  name="addr[landmark]" class="form-control" type="text" placeholder="Enter Land Mark">
                    <span id="landmark_eror" class="error"></span>
                </div>
                <div class="col-12 mb-4">
                    <label for="country" class="">Country</label>
                    <select id="country" name="addr[country]" class="form-control" ><?php
                        foreach(countries() as $rw){
                            if($rw->sortname == wh_country()->code ){ $selected = 'selected="selected"'; }else{ $selected = ''; }
                            echo '<option value="'.$rw->id.'" '.$selected.' >'.$rw->name.'</option>';
                        } ?>
                    </select>
                    <span id="country_error" class="error"></span>
                </div>
                <div class="col-12 mb-4">
                    <label for="zip" class="">Zip</label>
                    <input id="zip"  name="addr[zip]" class="form-control required" type="number" placeholder="Enter Zip Code">
                    <span id="zip_error" class="error"></span>
                </div>
                <div class="col-12 mb-4">
                    <label for="address" class="">Address Type</label><div class="clr"></div>
                    <div class="col-6 pl-0 fl">
                        <input id="addr_type1"  name="addr[address_label]" class="required"  type="radio" value="Home" checked="checked">
                        <label for="addr_type1" class="">Home</label>
                    </div>
                    <div class="col-6 pr-0 fl">
                        <input id="addr_type2"  name="addr[address_label]" class="required"  type="radio" value="Work">
                        <label for="addr_type2" class="">Work</label>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <input id="default_addr"  name="addr[default_addr]" class="" type="checkbox" value="1">
                    <label for="default_addr" class="">Default Address</label>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <input type="hidden" id="valid" name="valid" value="0" /><input type="hidden" id="submit_label" name="submit_label" value="Save" />  
                <button type="submit" id="save-addr" class="btn-u btn-u-update">Save</button>
              <button type="button" class="btn-u btn-u-danger" data-dismiss="modal">Close</button>
            </div>
        <?php form_close()?>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#addr-modal').on('click', function(){
            var modal   =   $(this).data('target'); $(modal).modal('show');
        });
        
        $('#addr-form').on('submit',function(){
            $('#valid').val(1); $('#submit_label').val('Saving...');
            $('#addr-form .required').each(function(){
                if(this.value == ''){ $('#'+this.id).closest('div').find('#'+this.id+'_error').html('This field is required'); $('#valid').val(0); $('#submit_label').val('Validating...'); }
                else{ $('#'+this.id).closest('div').find('#'+this.id+'_error').html(''); }
            });
            var formData    =   $('#addr-form').serialize();
            var action      =   $(this).attr('action'); 
        //    if{$('#valid').val() == 0){ alert('false'); }
            $.ajax({
                url: action,
                method: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#save-addr').text($('#submit_label').val()); $('#save-addr').attr('disabled',true);
                },
                success: function(data) {
                    if(data == 'invalid'){
                        notify("Please fill all fields",'warning','bottom','right');
                        $('#save-addr').text('Save');  $('#save-addr').attr('disabled',false);
                    }else if(data == 'failed'){
                        notify("Address failed to save",'warning','bottom','right');
                        $('#save-addr').text('Save');  $('#save-addr').attr('disabled',false);
                    } else {
                        $('#addrModal').modal('hide'); $('#save-addr').attr('disabled',false); $('#save-addr').text('Save');
                        notify("Address added successfully!",'success','bottom','right');
                        $('#address').html(data);
                    }
                },
                error: function(e) {
                    console.log(e)
                }
            });
            return false;
        });
    });
</script>
                       
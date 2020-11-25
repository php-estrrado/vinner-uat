<div>
	<?php
        echo form_open(base_url() . 'index.php/admin/stax/do_add/', array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'stax_add',
            'enctype' => 'multipart/form-data'
        ));
    ?>
        <div class="panel-body">

            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('Country');?></label>
                <div class="col-sm-6">
                     <select id="stcountry" name="scountry" class="form-control required" required onChange="">
                        <option value="">Select Country..</option>
                        <?php
                         $cntry=$this->db->get_where('fed_country',array('status'=>'1'))->result_array();
                        foreach($cntry as $cntry_details)
                            {
                            echo "<option value='".$cntry_details[country_id]."'>".$cntry_details[name]."</option>";
                            }
                        ?>
                     </select>
                    <div id='email_note' style="color:red;"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('tax_type');?></label>
                <div class="col-sm-6">
                    <input type="text" name="title" id="demo-hor-1" 
                        placeholder="<?php echo translate('give a tax name'); ?>" class="form-control required" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('tax_amount(%)');?></label>
                <div class="col-sm-6">
                   <input type="number" name="stax" id="stax" min='1' step='1' placeholder="<?php echo translate('tax %');?>" class="form-control required" onchange="limtper(this.value,this.id)">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('tax_description');?></label>
                <div class="col-sm-6">
                    <input type="text" placeholder="<?php echo translate('description if any'); ?>" name="detail" id="demo-hor-1" class="form-control">
                </div>
            </div>
            
 
        </div>
	</form>
</div>

<script src="<?php echo base_url(); ?>template/back/js/custom/brand_form.js"></script>
<script type="text/javascript">
function limtper(x,idt)
{
  if(x >= 100) 
  {
  $("#"+idt).val("99");
  }
  else if(x <= 0)
  {
  $("#"+idt).val("0.1");
  }
}
</script>


<script>
  $(document).ready(function() {
    $("form").submit(function(e){
      return false;
    });

    $(".btn-purple").prop('disabled',true);
  });

  $("#stcountry").change(function()
  {
    var email = $("#stcountry").val();
    $.post("<?php echo base_url(); ?>index.php/admin/existstax",
    {
      <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',
      email: email
    },
    function(data, status){
      if(data == 'yes'){
        $("#email_note").html('*<?php echo translate('tax_already_added_for_this_region'); ?>');
         $(".btn-purple").attr("disabled", "disabled");
      } else if(data == 'no'){
        $("#email_note").html('');
        $(".btn-purple").removeAttr("disabled");
      }
    });
  });
</script>
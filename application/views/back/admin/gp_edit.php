<?php
  foreach($product_data as $row){
?>
<div>
   <?php
      echo form_open(base_url() . 'index.php/admin/gp_product/update/' . $row['product_id'], array(
        'class' => 'form-horizontal',
        'method' => 'post',
        'id' => 'gp_edit',
        'enctype' => 'multipart/form-data'
      ));
      $gp_id=$row['product_id'];
    ?>

  <div class="panel-body"> 
  
        <div class="form-group btm_border">
            <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('package_name');?></label>
            <div class="col-sm-6">
               <input type="text" name="gp_name" id="gp_name" class="form-control required" placeholder="<?php echo translate('package_name');?>" value="<?php echo $row['title']; ?>">
            </div>
        </div>
            
        <div class="form-group btm_border">
          <label class="col-sm-4 control-label" for="demo-hor-1">Packed Dimensions (L x W x H):
          </label>
          <div class="col-sm-6"> 
            <div class="col-sm-4"> 
                <input type="number" name="gp_l"  size="4" id="gp_l" class="form-control required"  value="<?php echo $row['length']; ?>" placeholder="<?php echo translate('l');?>"   >
            </div>
            <div class="col-sm-4"> 
                <input type="number" placeholder="<?php echo translate('w');?>" name="gp_w" size="4" id="gp_w" class="form-control required" value="<?php echo $row['width']; ?>">
            </div>
            <div class="col-sm-4"> 
                <input type="number" id="gp_h" placeholder="<?php echo translate('h');?>" name="gp_h" size="4" class="form-control required" value="<?php echo $row['height']; ?>">
            </div>
          </div>
        </div>  

        <div class="form-group btm_border">      
         <label class="col-sm-4 control-label" for="demo-hor-1">Length Class:</label>
         <div class="col-sm-6">         
          <select id="gpl_class" name="gp_lclass" class="form-control required">
          <option value="1" <?php if($row['length_class_id']==1){?>  selected="selected" <?php }?>> Centimeter
          </option>
          <option value="3" <?php if($row['length_class_id']==3){?>  selected="selected" <?php }?>>Inch</option>
          </select>
         </div>
        </div>

        <div class="form-group btm_border">      
         <label class="col-sm-4 control-label" for="demo-hor-1">Weight:</label>
          <div class="col-sm-6">
            <input type="number" id="gp_wei" name="gp_weight" value="<?php echo $row['weight']; ?>" class="form-control required" placeholder="Weight">
         </div>
        </div>  

        <div class="form-group btm_border">      
         <label class="col-sm-4 control-label" for="demo-hor-1">Weight Class:
         </label>
         <div class="col-sm-6">         
          <select id="gp_wei_class" name="gp_weclass" class="form-control required">
           <option value="1" <?php if($row['weight_class_id']==1){?>  selected="selected" <?php }?>>Kilogram</option>
           <option value="5"  <?php if($row['weight_class_id']==5){?>  selected="selected" <?php }?>>Pound </option>
          </select>
         </div>
        </div> 

        <?php /* <div class="form-group btm_border">      
         <label class="col-sm-4 control-label" for="demo-hor-1">Quantity:</label>
          <div class="col-sm-6">
            <input type="number" id="gp_quantity" name="gpquantity" class="form-control required" placeholder="Quantity" min="1"  value="<?php echo $grp_qunt;?>" >
         </div>
        </div>  */ ?>  
        <div class="form-group btm_border">
          <label class="col-sm-4 control-label" for="demo-hor-13"><?php echo translate('description'); ?></label>
          <div class="col-sm-6">
              <textarea rows="5" id="gpshort_descr" class="form-control" name="gpshort_descr" data-height="100" data-name="gpshort_descr" placeholder="Description"><?php echo $row['short_description'];?></textarea>
          </div>
        </div> 
  </div>


<?php echo form_close (); ?>
</div>
<?php } ?>
<script src="<?php echo base_url(); ?>template/back/js/custom/brand_form.js"></script>
<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>

<script type="text/javascript">
$(".modal-footer").html('<a type="button" class="btn btn-info cced" data-dismiss="modal">Close</a><a  type="button" class="btn btn-success" onclick="gp_predit(<?php echo $gp_id; ?>)" id="form_gpedit" >update</a>');

  
function gp_predit(gp_id)
{
  var gp_name   = $("#gp_name").val();
  var gp_l      = $("#gp_l").val();
  var gp_w      = $("#gp_w").val();
  var gp_h      = $("#gp_h").val();
  var gp_lclass = $("#gpl_class").val();
  var gp_weight = $("#gp_wei").val();
  var gp_weclass= $("#gp_wei_class").val();
  var gp_descr  = $("#gpshort_descr").val();
  //var gp_quant  = $("#gp_quantity").val();

    $.post("<?php echo base_url(); ?>index.php/admin/gp_product/update/"+gp_id,
    {
      <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',
      gp_name: gp_name ,
      gp_l: gp_l ,
      gp_w: gp_w ,
      gp_h: gp_h ,
      gp_lclass: gp_lclass ,
      gp_weight: gp_weight ,
      gp_weclass: gp_weclass ,
      gp_descr : gp_descr
    },
    function(data, status){
      if(data)
      {
        //$(".cced").click();
        gp_eproduct(data,gp_name,gp_l,gp_w,gp_h,gp_weight);
        $("#gp_edit").trigger("reset");
      } else 
      {
        alert("no");
      }
    });
}

function gp_eproduct(gpid,gname,gpl,gpw,gph,gpweight)
{
    var pid=gpid;
    var pname=gname;
    tbli= document.getElementById('group-list');
    var rc=tbli.rows.length;
    var ain=1;

if(pid !="" || pid != 0)
{    
    var trdata='<td><div id="sl'+pid+'" >'+'<input type="hidden" name="prd-id[]" value="'+pid+'" /></div></td><td><input readonly="readonly" class="form-control required" type="text" name="p[]" id="p'+pid+'" value="'+pname+'"></td>'
      +'<td><input type="number" name="quantity[]" id="quantity'+pid+'" class="form-control required" onchange="" value="1"  min="1" ></td>'
      +'<td><input readonly="readonly" class="form-control required" type="text" name="l[]" id="l'+pid+'" value="'+gpl+'"></td>'
      +'<td><input readonly="readonly" class="form-control required" type="text" name="w[]" id="w'+pid+'" value="'+gpw+'"></td>'
      +'<td><input readonly="readonly" class="form-control required" type="text" name="h[]" id="h'+pid+'" value="'+gph+'"></td>'
      +'<td><input readonly="readonly" class="form-control required" type="text" name="we[]" id="we'+pid+'" value="'+gpweight+'"></td>'
      + '<td><input type="text" name="pid[]" id="pid'+pid+'" hidden="hidden" value="'+pid+'"></td>'
      + '<td class="text-center"><div style="width: max-content;"> <button type="button" id="rmv'+pid+'" class="close" onclick="removeRowgp('+pid+')"><i class="fa fa-trash"></i></button>'
      +' <button type="button" id="" class="close" onclick=ajax_modal("gp_edit","Package_Edit","successfully_edited!","gp_edit","'+pid+'")><i class="fa fa-pencil"></i></button><div></td>';
    $("#"+pid).html(trdata);
    $(".cced").click();
    gpeddal("product edited");
}
else
{
}

}

function gpeddal(msg)
{ 
    $.activeitNoty({
            type: 'success',
            icon : 'fa fa-check',
            message : msg , 
            container : 'floating',
            timer : 3000
            });
}



$('#gpl_class').change(function()
  {
    if(this.value == 1){ 
      $('#gp_wei_class').find('option').each(function(i,e){
        if($(e).val() == 1){ $('#gp_wei_class').prop('selectedIndex',0); }
      });
    }else
    {
      $('#gp_wei_class').find('option').each(function(i,e){
        if($(e).val() == 5){ $('#gp_wei_class').prop('selectedIndex',1); }
      });
    }
  });
  $('#gp_wei_class').change(function()
  {
    if(this.value == 1){ 
      $('#gpl_class').find('option').each(function(i,e){
      if($(e).val() == 1){ $('#gpl_class').prop('selectedIndex',0); }
    });
    }else
    {
      $('#gpl_class').find('option').each(function(i,e){
      if($(e).val() == 3){ $('#gpl_class').prop('selectedIndex',1); }
      });
    }
  });


</script>
<div>
  <?php
        echo form_open(base_url() . 'index.php/admin/gp_product/do_add', array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'gp_add',
            'enctype' => 'multipart/form-data'
        ));
    ?>

  <div class="panel-body"> 
        <div class="form-group btm_border">
            <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('package_name');?></label>
            <div class="col-sm-6">
               <input type="text" name="gp_name" id="gp_name" placeholder="<?php echo translate('package_name');?>" class="form-control required">
               <span id="nameal" class="require_alert"></span>
            </div>
        </div>

        <div class="form-group btm_border">
          <label class="col-sm-4 control-label" for="demo-hor-1">Packed Dimensions (L x W x H):
          </label>
          <div class="col-sm-8"> 
            <div class="col-sm-4"> 
                <input type="number" placeholder="<?php echo translate('l');?>" name="gp_l" value="1" size="4" id="gp_l" class="form-control required" min='0.1' onchange="limtper(this.value,this.id)">
            </div>
            <div class="col-sm-4"> 
                <input type="number" placeholder="<?php echo translate('w');?>" name="gp_w" value="1" size="4" id="gp_w" class="form-control required" min='0.1' onchange="limtper(this.value,this.id)">
            </div>
            <div class="col-sm-4"> 
                <input type="number" id="gp_h" placeholder="<?php echo translate('h');?>" name="gp_h" value="1" size="4" class="form-control required" min='0.1' onchange="limtper(this.value,this.id)" >
            </div>
          </div>
        </div>  

        <div class="form-group btm_border">      
         <label class="col-sm-4 control-label" for="demo-hor-1">Length Class:</label>
         <div class="col-sm-6">         
          <select id="gpl_class" name="gp_lclass" class="form-control required">
          <option value="1" selected="selected" class="form-control required">Centimeter</option>
          <option value="3">Inch</option>
          </select>
         </div>
        </div>

        <div class="form-group btm_border">      
         <label class="col-sm-4 control-label" for="demo-hor-1">Weight:</label>
          <div class="col-sm-6">
           <input type="number" id="gp_wei" value="1" id="gp_wei" min='0.1' name="gp_weight" value="1" class="form-control required" placeholder="Weight" onchange="limtper(this.value,this.id)">
         </div>
        </div>  

        <div class="form-group btm_border">      
         <label class="col-sm-4 control-label" for="demo-hor-1">Weight Class:
         </label>
         <div class="col-sm-6">         
          <select id="gp_wei_class" name="gp_weclass" class="form-control required">
          <option value="1" selected="selected">Kilogram</option>
          <option value="5">Pound </option>
          <!-- <option value="2">Gram</option> -->
          <!-- <option value="6">Ounce</option> -->
          </select>
         </div>
        </div> 

        <div class="form-group btm_border">      
         <label class="col-sm-4 control-label" for="demo-hor-1">Quantity:</label>
          <div class="col-sm-6">
            <input type="number" id="gp_quantity" name="gpquantity" class="form-control required" placeholder="Quantity" min="1" value="1">
          </div>
        </div> 

        <div class="form-group btm_border">
          <label class="col-sm-4 control-label" for="demo-hor-13"><?php echo translate('description'); ?></label>
          <div class="col-sm-6">
              <textarea rows="5" id="gpshort_descr" class="form-control" name="gpshort_descr" data-height="100" data-name="gpshort_descr" placeholder="Description"></textarea>
          </div>
        </div> 

  </div>

<?php echo form_close (); ?>
</div>

<script src="<?php echo base_url(); ?>template/back/js/custom/brand_form.js"></script>
<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>

<script type="text/javascript">

/*$(".modal-footer").html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button type="button" class="btn btn-success" onclick="gp_pradd()" id="form_gpadd" data-dismiss="modal">Add</button>');*/

$(".modal-footer").html('<a type="button" class="btn btn-info ccmm" data-dismiss="modal">Close</a><a  type="button" class="btn btn-success" onclick="gp_prvalidate()" id="form_gpadd" >Add</a>');


function gp_prvalidate()
{
  var valid=0;
  var re="<font color='red'>*Required</font>";
  if($("#gp_name").val()=='')
  {
    $("#nameal").html(re);
    valid=1;
  }
  else
  {
    $("#nameal").html("");
    if($("#gp_quantity").val()=='' || $("#gp_quantity").val()=='0')
      {
        valid=1;
      }
    else
      {
        valid=0;
      }
  }

  if (valid==0) 
  {
    gp_pradd()
  }

}




function gp_pradd()
{
  var gp_name   = $("#gp_name").val();
  var gp_l      = $("#gp_l").val();
  var gp_w      = $("#gp_w").val();
  var gp_h      = $("#gp_h").val();
  var gp_lclass = $("#gpl_class").val();
  var gp_weight = $("#gp_wei").val();
  var gp_weclass= $("#gp_wei_class").val();
  var gp_quant  = $("#gp_quantity").val();
  var gp_descr  = $("#gpshort_descr").val();

    $.post("<?php echo base_url(); ?>index.php/admin/gp_product/do_add",
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
         gp_product(data,gp_name,gp_quant,gp_l,gp_w,gp_h,gp_weight);
          $("#gp_add").trigger("reset");
      } else 
      {
        alert("no");
      }
    });
}

function gp_product(gpid,gname,gquant,gpl,gpw,gph,gpweight)
{
    var pid=gpid;
    var pname=gname;
    var quantity=gquant;
    tbli= document.getElementById('group-list');
    var rc=tbli.rows.length;
    var ain=1;
    for (var i =1 ; i<rc; i++) 
    {
        if(pid == $('#pid'+i).val())
        {
           var ain=0;
        }
    }
if(pid !="" || pid != 0)
{    
    $("#aler3").hide();
    
    if(quantity>0 && ain==1)
    {
    tbl = document.getElementById('group-list');
    var counter=tbl.rows.length;
    pc=counter-1;
    $("#rowCnt").val(counter);
    var newRow = jQuery('<tr id="'+pid+'"><td><div id="sl'+counter+'" >'+'<input type="hidden" name="prd-id[]" value="'+pid+'" /></div></td><td><input readonly="readonly" class="form-control required" type="text" name="p[]" id="p'+counter+'" value="'+pname+'"></td><td><input type="number" name="quantity[]" id="quantity'+counter+'" class="form-control required" onchange="totala('+counter+')" value="'+quantity+'"  min="1" ></td>'
    + '<td><input readonly="readonly" class="form-control required" type="text" name="l[]" id="l'+counter+'" value="'+gpl+'"></td>'
    + '<td><input readonly="readonly" class="form-control required" type="text" name="w[]" id="w'+counter+'" value="'+gpw+'"></td>'
    + '<td><input readonly="readonly" class="form-control required" type="text" name="h[]" id="h'+counter+'" value="'+gph+'"></td>'
    + '<td><input readonly="readonly" class="form-control required" type="text" name="we[]" id="we'+counter+'" value="'+gpweight+'"></td>'  
    + '<td><input type="text" name="pid[]" id="pid'+counter+'" hidden="hidden" value="'+pid+'"></td>'
    + '<td class="text-center"><div style="width: max-content;"><button type="button" id="rmv'+counter+'" class="close" onclick="removeRowgp('+pid+')"><i class="fa fa-trash"></i></button>'
      +' <button type="button" id="" class="close" data-toggle="tooltip" onclick=ajax_modal("gp_edit","Package_Edit","successfully_edited!","gp_edit","'+pid+'")><i class="fa fa-pencil"></i></button><div></td></tr>');
        
    jQuery('table#group-list').append(newRow);
    $(".ccmm").click();
    gpaddal("product add to group");
    $("#quantity").val(0);
    }
    else if(ain==0)
    {
    }
    else if(quantity==0)
    {
 
    }
}
else
{
}

}



function gpaddal(msg)
{ 
    $.activeitNoty({
            type: 'success',
            icon : 'fa fa-check',
            message : msg , 
            container : 'floating',
            timer : 3000
            });
}


function limtper(x,idt)
{
  if(x < 0.1)
  {
  $("#"+idt).val("0.1");
  }
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
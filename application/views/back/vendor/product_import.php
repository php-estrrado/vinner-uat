<div id="content-container">

    <div id="page-title">
<center>
        <h1 class="page-header text-overflow"><?php echo translate('Bulk_item_upload');?></h1>
        <center>

    </div>


    <div class="tab-base">

        <div class="panel">

             <div class="panel-body">

             <div class="col-md-12" style="border-bottom: 1px solid #ebebeb;padding: 5px;">
               <a href="<?php echo base_url().'index.php/vendor/product'; ?>"> <button class="btn btn-info btn-labeled fa fa-step-backward pull-right ">
                        <?php echo translate('back_to_product_list');?>
                </button> </a>
             </div>
                <div class="tab-content" >

<?php if( $cond=="11") 
{
?>
 <?php
        echo form_open(base_url() . 'index.php/vendor/import_product/', array(

                        'class' => 'log-reg-v3 sky-form',

                        'method' => 'post',

                        'style' => 'padding:30px 10px !important;',

                        'id' => 'upload_excel' ,

                        'enctype' =>'multipart/form-data'

                    ));
    ?>
                <!-- LIST -->
<center> 
<div class="" >
<div class=" btn-group " >
Select a CSV file:
<input type="file" name="file" id="file" class="form-control " required="required"> </input>
</div> <span id="errmsg"></span>
</div>
<div class="">
<br/>
 <button type="submit" id="submit" name="import" class="btn btn-info active btn-lg btn-labeled fa fa-upload">
    Upload  </button>
</div>
</center>
</form> 

<?php if($this->session->flashdata('message'))
{ ?>
          <div align="center"  class="">   

        <?php if ($message==1) 
        { ?>
            <span style="color:blue;">   
           <?php 
           if($insertcount>0)
            {
            echo $insertcount." products added successfully .<br/>"; 
            }
            if($updatecount>0)
            {
              echo $updatecount." products updated successfully .<br/>"; 
            } ?>  
           </span>
          <?php     
           if($dtinsertcount >0)
                 {
                        $i=0;
                        foreach ($dtinsertpc as $key ) 
                        {
                           echo $key;
                           $i++;
                           if($i>0 && $i<$dtinsertcount)
                           {
                             echo ",";
                           }
                        }
                  echo  " these product codes are already added.."."<br/>";
                }
                
        } else { ?>
          <span style="color:red;">   
            <?php echo $this->session->flashdata('message')."<br/>"; ?> </span>
            <?php //print_r($dtinsertpc);
                if($dtinsertcount >0)
                 {
                        $i=0;
                        foreach ($dtinsertpc as $key ) 
                        {
                           echo $key;
                           $i++;
                           if($i>0 && $i<$dtinsertcount)
                           {
                             echo ",";
                           }
                        }
                  echo  " these product codes are already added.."."<br/>";
                }
                else
                {
                     echo "Please check the CSV format and data "."<br/>";
                }
            }
            ?>
          </div><br/>
<?php } ?>
<br/>
<div class=""> 

<div class="" >
<p >CSV Format :
<b><?php echo translate("Product_name,Product_Code,Product_Type,Product Condition,Category_code,Sub_Category_code,Equipment_code,Sub_equipment_code,Brand_code,Sale_Price,Unit,Model,Location,Current_Stock,Length,Width,Height,Weight,Description,HS_code,Short_Description");?> </b></p>
</div>
<b><a style="color:blue;" href="<?php echo base_url().'uploads/product_brochure/product_csv.csv'?>">Sample CSV</a> <b/>
    <div class="col-sm-10"> 
  <b>CSV Conditions</b> 
  <ul class="list-group">
    <li class="list-group-item"><b>Product name </b>:Name of the product | <b>Product Code</b>:Product code <font color="red" >*must be unique</font></li>
    <li class="list-group-item"><b>Product Type</b>:Product Type | <b>Product Condition</b>: New(0) / Refurbished(1) </li>

    <li class="list-group-item">
     <b>Category Code</b>: Category code of product - <a style="color:red" data-toggle="collapse" href="#collapse1">View Category Codes</a>
    <br/>
    <div id="collapse1" class="panel-collapse collapse">
      <div class="panel-body table-responsive" style="height: 500px;">
     <table id="demo-table" class="table table-striped" >
          <tr><th>Category Name</th><th>Code</th></tr>
           <?php foreach($all_categories as $row) { ?>
          <tr><td><?php echo $row['category_name']; ?></td><td><?php echo $row['category_id']; ?></td></tr>
          <?php } ?>
      </table>
      </div>
    </div>
    </li>

    <li class="list-group-item">
     <b>Sub Category Code</b>:Sub Category code of product - <a style="color:red" data-toggle="collapse" href="#collapse2">View Sub Category Codes</a>
    <br/>
    <div id="collapse2" class="panel-collapse collapse">
      <div class="panel-body table-responsive" style="height: 500px;">
     <table id="demo-table" class="table table-striped" >
        <thead>  <tr><th>Sub Category Name</th><th>Code</th> <th>Category</th> </tr> </thead>
          <?php foreach($all_sub_category as $row) { ?>
          <tr>
          <td><?php echo $row['sub_category_name']; ?></td><td><?php echo $row['sub_category_id']; ?></td>
          <td><?php echo $this->crud_model->get_type_name_by_id('category',$row['category'],'category_name')."(".$row['category'].")"; ?></td>
          </tr>
          <?php } ?>
     </table>
      </div>
    </div>
    </li>

     <li class="list-group-item">
     <b>Equipment Code</b>: Equipment code of product - <a style="color:red" data-toggle="collapse" href="#collapse3">View Equipment Codes</a>
    <br/>
    <div id="collapse3" class="panel-collapse collapse">
      <div class="panel-body table-responsive" style="height: 500px;" >
      <table id="demo-table" class="table table-striped" >
        <thead>  <tr><th>Equipment Name</th><th>Code</th></tr> </thead>
         <?php foreach($all_equipments as $row) { ?>
          <tr><td><?php echo $row['equipment_name']; ?></td><td><?php echo $row['equipment_id']; ?></td></tr>
          <?php } ?>
      </table>
      </div>
    </div>
    </li>

    <li class="list-group-item">
     <b>Sub Equipment Code</b>:Sub Equipment code of product - <a style="color:red" data-toggle="collapse" href="#collapse4">View Sub Equipment Codes</a>
    <br/>
    <div id="collapse4" class="panel-collapse collapse">
      <div class="panel-body table-responsive" style="height: 500px;">
     <table id="demo-table" class="table table-striped" >
         <thead> <tr><th>Sub Equipment Name</th><th>Code</th><th>Equipment</th></tr> </thead>
          <?php foreach($all_sub_equipment as $row){ ?>
          <tr><td><?php echo $row['sub_equipment_name']; ?></td><td><?php echo $row['sub_equipment_id']; ?></td><td><?php echo $this->crud_model->get_type_name_by_id('equipment',$row['equipment'],'equipment_name')."(".$row['equipment'].")"; ?></td></tr>
          <?php } ?>
     </table>
      </div>
    </div>
    </li>

    <li class="list-group-item">
     <b>Brand Code</b>:Brand code of product - <a style="color:red" data-toggle="collapse" href="#collapse5">View Brand Codes</a>
    <br/>
    <div id="collapse5" class="panel-collapse collapse">
      <div class="panel-body table-responsive" style="width: 75%;height: 500px;">
     <!--  <table border="1" class="table"> -->
     <table id="demo-table" class="table table-striped" >
     <thead><tr><th>Brand Name</th><th align="">Code</th></tr></thead>
      
          <?php foreach($all_brands as $row){ ?>
          <tr><td><?php echo $row['name']; ?></td><td ><?php echo $row['brand_id']; ?></td></tr>
          <?php } ?>
      </table>
      </div>
       <a style="float:right" data-toggle="collapse" href="#collapse5"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
    </div>
    </li>
         
     <li class="list-group-item"><b>Sale Price</b>:Product Price | <b>Unit</b>: pc/no | <b>Model</b>: Product Model | <b>Location</b>: Product Location | <b>Current Stock</b>:Product Stock in number</li>

<!-- Length,Width,Height,Length_class,Weight,Weight_class-->     
    <li class="list-group-item"><b>Length</b>:Product Length in cm | <b>Width</b>:Product Width in cm | <b>Height</b>: Product Height in cm |<b>Weight</b>:Product Weight in kg | Description| HS code:HS code of product| Short Description</li>

  </ul>
    </div>


</div>  <!-- first -->

<?php  }

else if($cond=="22")
    { ?>


          <div align="center"  class="">      
            <?php echo $message."-".$insertcount."-".$dtinsertcount."<br/>"; 

            $i=0;
                        foreach ($dtinsertpc as $key ) 
                        {
                           echo $key;
                           $i++;
                           if($i>0 && $i< $dtinsertcount)
                           {
                             echo ",";
                           }
                        }

                  echo  " these product codes are already in added .."."<br/>".$dtinsertcount ;
            ?>
          </div>


<?php } ?>

  </div>
     </div>
        </div>

            <!--Panel body-->

        </div>

    </div>



<script>

    var base_url = '<?php echo base_url(); ?>'

    var user_type = 'vendor';

    var module = 'product_import';

    //var list_cont_func = 'list';

    var dlt_cont_func = 'delete';

    var loading = '<div>loading...<div>';


    </script>



<style>
    .highlight
    {
        background-color: #E7F4FA;
    }
</style>


<script type="text/javascript">

$("#file").change(function () 
{
        $("#errmsg").html("");
        var fileExtension = ['csv'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) 
        {
            $("#errmsg").html("<font color='red'>Only formats are allowed : "+fileExtension.join(', ')+"</font>");
            $("#file").val("");
        }
        else
        {
            $("#errmsg").html("<i class='fa fa-check' color='green' aria-hidden='true'></i>");
        }
});


</script>



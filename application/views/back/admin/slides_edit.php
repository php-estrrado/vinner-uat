<?php foreach($slides_data as $row) { ?>    
  <div>        
  <?php     
  echo form_open(base_url() . 'index.php/admin/slides/update/' . $row['slides_id'], array(        'class' => 'form-horizontal',       'method' => 'post',       'id' => 'slides_edit',        'enctype' => 'multipart/form-data'      ));   ?>           
  <div class="panel-body">               
    <div class="form-group" style="">                   
     <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('Slider_caption');?>
     </label>                    
      <div class="col-sm-6">                       
      <input type="text" class="form-control required" name="name" id="demo-hor-1" value="<?php echo $row['name'];?>"  >                    
      </div>               
    </div> 

    <div class="form-group" style="">
        <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('Slider_type');?>
        </label>
        <div class="col-sm-6">
        <input type="text" class="form-control required" name="sl_type" id="sl_type" readonly value="<?php echo $row['type'];?>"  > 
        </div>
    </div>

    <?php if($row['type']=='Video') {  ?>

      <div id="banner_video" class="form-group" >
            <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('video_link')."(embed youtube url)";?></label>
            <div class="col-sm-8">
             <input type="text" name="video_link" id="video_link" class="form-control totals required" placeholder="Link" value="<?php echo $row['vl_link']; ?>">
            </div>
      </div> 
    <?php } else { ?>
      <div class="form-group">                   
        <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('slides_logo');?>
        </label>       
        <div class="col-sm-6">                      
        <span class="pull-left btn btn-default btn-file">                         
          <?php echo translate('select_slide_banner');?>                        
          <input type="file" name="img" id='imgInp' accept="image">
        </span>                        
       <br><br>                       
           <span id='wrap' class="pull-left" >                          
             <img src="<?php echo $this->crud_model->file_view('slides',$row['slides_id'],'','','no','src','','','.jpg') ?>" width="60%" id='blah' >                     
          </span>          
        </div> 
      </div> 

      <div class="form-group">
          <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('alt_text');?></label>
          <div class="col-sm-6">
            <input type="text" name="alt_text" id="alt_text" class="form-control totals" placeholder="Alt Text" value="<?php echo $row['alt_text']; ?>">
          </div>
      </div>

      <div class="form-group">
          <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('hyperlink');?></label>
          <div class="col-sm-8">
            <input type="text" name="hr_link" id="hr_link" class="form-control totals" placeholder="Link" value="<?php echo $row['sl_link']; ?>" >
          </div>
      </div> 
      <?php } ?>
    

                
  </div>        
<?php echo '</form>'; ?>    
    </div>
<?php }?>

    <script src="<?php echo base_url(); ?>template/back/js/custom/brand_form.js"></script>
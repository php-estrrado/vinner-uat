<div>
    <?php
        echo form_open(base_url() . 'index.php/admin/slides/do_add/', array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'slides_add',
            'enctype' => 'multipart/form-data'
        ));
    ?>

        <div class="panel-body">
            <div class="form-group" style="">
                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('Slider_caption');?></label>
                <div class="col-sm-6">
                    <input type="text" name="name" id="demo-hor-1" placeholder="<?php echo translate('slides_name'); ?>" class="form-control required">
                </div>
            </div>
            <div class="form-group" style="">
                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('Slider_type');?></label>
                <div class="col-sm-6">
                    <select name="sl_type" id="sl_type" class="col-sm-6 form-control" >
                     <option vlaue="image">Image</option>
                     <option vlaue="video">Video</option>  
                    </select>
                </div>
            </div>
        <div id="banner_img" >
            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('slider_banner');?></label>
                <div class="col-sm-6">
                    <span class="pull-left btn btn-default btn-file">
                     <?php echo translate('select_slide_banner');?>
                     <input type="file" name="img" id='imgInp' accept="image" class="required">
                    </span>
                    <br/>
                    <span id='wrap' class="pull-left" >
                     <img src="<?php echo base_url(); ?>uploads/others/photo_default.png" width="48.5%" id='blah' > 
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('alt_text');?></label>
                <div class="col-sm-6">
                <input type="text" name="alt_text" id="alt_text" class="form-control totals" placeholder="Alt Text">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('hyperlink');?></label>
                <div class="col-sm-6">
                <input type="text" name="hr_link" id="hr_link" class="form-control totals" placeholder="Link">
                </div>
            </div>
        </div>   
        <div id="banner_video" class="form-group" hidden>
            <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('video_link')."(embed youtube url)";?></label>
            <div class="col-sm-8">
             <input type="text" name="video_link" id="video_link" class="form-control totals" placeholder="Link">
            </div>
        </div> 

        </div>
    </form>
</div>

<script src="<?php echo base_url(); ?>template/back/js/custom/brand_form.js"></script>

<script type="text/javascript">

$("#sl_type").on('change', function() {
    var selectedValue = $(this).val();
    if(selectedValue=='Video')
    {
        $("#banner_img").hide();
        $("#banner_video").show();
        $("#imgInp").val('');
        $("#imgInp").removeClass('required');
        $("#video_link").addClass('required');
        $("#wrap").html('<img src="<?php echo base_url(); ?>uploads/others/photo_default.png" width="48.5%" id="blah" >');
    }
    else
    {
        $("#banner_img").show();
        $("#banner_video").hide();
        $("#video_link").val('');
        $("#video_link").removeClass('required');
        $("#imgInp").addClass('required');
    }
})


</script>


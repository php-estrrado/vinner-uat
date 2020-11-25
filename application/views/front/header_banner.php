
<!-- <div class="container">
<div class="col-md-4 col-sm-12 col-xs-12   h-banner f-pad">
    <a href="#" >
        <img src="<?php echo base_url(); ?>template/front/assets/img/h-banner-1.png"/>
    </a>
</div>
<div class="col-md-4 col-sm-12 col-xs-12 h-banner" style="padding-top: 15px; padding-bottom: 15px;padding-right: 15px;padding-left: 15px;">
    <a href="#" >
        <img src="<?php echo base_url(); ?>template/front/assets/img/h-banner-2.png" style="margin-left: 5px;"/>
    </a>
</div>
<div class="col-md-4 col-sm-12 col-xs-12 h-banner l-pad">
    <a href="#" >
        <img src="<?php echo base_url(); ?>template/front/assets/img/h-banner-3.png" class="pull-right" />
    </a>
</div>
</div> -->

<div class="container-fluid mar-2ed">

	<?php
        $place = 'before_slider';
        $query = $this->db->get_where('banner',array('page'=>'home', 'place'=>$place, 'status' => 'ok'));
        $banners = $query->result_array();
        if($query->num_rows() > 0){
            $r = 12/$query->num_rows();
        }
        foreach($banners as $row)
        	{ ?>
    <div class="col-md-4 col-sm-12 col-xs-12   h-banner f-pad">
    <a href="<?php echo $row['link']; ?>" >
       <img title="<?php echo $row['title'];?>" alt="<?php echo $row['alt_text'];?>" src="<?php echo $this->crud_model->file_view('banner',$row['banner_id'],'','','no','src') ?>"/>
    </a>
	</div>
  <?php
} ?>

</div>


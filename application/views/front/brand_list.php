<?php 
$css_development = TRUE;
$rebuild		 =	FALSE;
$vendor_system	 =  $this->db->get_where('general_settings',array('type' => 'vendor_system'))->row()->value;
$description	 =  $this->db->get_where('general_settings',array('type' => 'meta_description'))->row()->value;
$keywords		 =  $this->db->get_where('general_settings',array('type' => 'meta_keywords'))->row()->value;
$author			 =  $this->db->get_where('general_settings',array('type' => 'meta_author'))->row()->value;
$system_name	 =  $this->db->get_where('general_settings',array('type' => 'system_name'))->row()->value;
$system_title	 =  $this->db->get_where('general_settings',array('type' => 'system_title'))->row()->value;
$revisit_after	 =  $this->db->get_where('general_settings',array('type' => 'revisit_after'))->row()->value;
$slider	 =  $this->db->get_where('general_settings',array('type' => 'slider'))->row()->value;
$slides	 =  $this->db->get_where('general_settings',array('type' => 'slides'))->row()->value;
$page_title      =  ucfirst(str_replace('_',' ','Brand Stores'));
$this->crud_model->check_vendor_mambership();
if($css_development == TRUE){
		include 'includes_top.php';
	} else {
		include 'includes_top_n.php';
	}
	include 'preloader.php';
	include 'header.php';

	if($page_name=="home" && $slider == 'ok')
	{
		include 'slider.php';
	}
	if($page_name=="home" && $slides == 'ok')
	{
		include 'category_menu.php';
	}
 $this->db->order_by('brand_id', 'desc');
 $page_data= $this->db->get('brand')->result_array();
?>
<div class="container">

<div class="box_margin">
 <center>
<h3 class="bs_sub_head">Brand Stores</h3> </center><br/>

<div>
<?php
$category = $this->db->query("SELECT DISTINCT(c.category_name),c.category_id FROM product p ,category c WHERE p.category =c.category_id ORDER BY p.category DESC")->result_array();
 //print_r($category);
 foreach($category as $cat)
{
	echo "<div class='row bs_sub_head2'><center>".$cat['category_name']."</center></div><div class='clearfix'></div>";
	$cbrand=$this->db->query("SELECT DISTINCT(b.name) as brand ,p.brand as brand_id FROM product p ,brand b WHERE p.brand=b.brand_id and p.category=".$cat['category_id'])->result_array();
	echo '<div class="row">';

		$countbrand=count($cbrand); 
		$perc=$countbrand/3;
		//echo $countbrand;
	?>
	 <?php $i=0;
	 	for ($j=0; $j < $perc; $j++) { 
	 	for ($i; $i < $countbrand ; $i++) {
	 		echo '<div class="col-md-4 col-xs-12 bs_sub_list">';
	 ?>
<a href="<?php echo base_url(); ?>index.php/home/brand/<?php echo $cbrand[$i]['brand_id'];?>"> 
	   <?php echo $cbrand[$i]['brand']; ?>
</a>
<?php echo "</div>";  } ?>
<?php }  
echo " </div>";
 } ?>
</div>
</div>
</div>

<?php
	include 'footer.php';
	include 'script_texts.php';
	
	if($css_development == TRUE){
		include 'includes_bottom.php';
	} else {
		include 'includes_bottom_n.php';
	}

?>
<style type="text/css">
.box_margin { width: 100%;}
	.bs_sub_head{background: #f7921e;padding: 10px;text-align: center;color: #fff;font-weight: 700;margin-top: -30px;}
	.bs_sub_head2 {
    background: #2c75e9;
    padding: 10px;
    text-align: center;
    color: #fff;
    font-weight: 700;
    margin: 20px 0px;
}
.bs_sub_list {
    font-size: 16px;
    font-weight: 500;
    margin: 10px auto;
}
.bs_sub_list a{
	color: #333;
	text-indent: 10px;
}
.bs_sub_head2 center {
    font-size: 16px;
}
</style>

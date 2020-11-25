<!DOCTYPE html>
<html lang="en">  
<head>
    <title><?php echo $page_title; ?> | <?php echo $system_title; ?></title>
    <!-- Meta -->
    <meta charset="UTF-8">

    <?php 
        if($page_name == 'product_view')
        {
            $description=$ddescription;
            if($product_tags){ $keywords=$product_tags;}
        }
//        if($meta_category!='')
//        {
//            $description=$meta_category;
//        }

    ?>

    <meta name="description" content="<?php echo $description; if($page_name == 'vendor_home'){ echo ', '.$this->db->get_where('vendor',array('vendor_id'=>$vendor))->row()->description; }  ?>">
    <meta name="keywords" content="<?php echo $keywords; if($page_name == 'vendor_home'){ echo ', '.$this->db->get_where('vendor',array('vendor_id'=>$vendor))->row()->keywords; } ?>">
    <meta name="author" content="<?php echo $author; ?>">
    <meta name="revisit-after" content="<?php echo $revisit_after; ?> days">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="expires" content="Mon, 10 Dec 2001 00:00:00 GMT" />
    <?php 
		if($page_name == 'product_view')
        {
			foreach($product_data as $row)
			{
	           ?>
                <!-- Schema.org markup for Google+ -->
                <meta itemprop="name" content="<?php echo $row['title']; ?>">
                <meta itemprop="description" content="<?php echo substr(trim(strip_tags($row['short_description'])),0,320); ?>">
                <meta itemprop="image" content="<?php echo $this->crud_model->file_view('product',$row['product_id'],'','','no','src','multi','one'); ?>">
                
                <!-- Twitter Card data -->
                <meta name="twitter:card" content="summary_large_image">
                <meta name="twitter:site" content="@publisher_handle">
                <meta name="twitter:title" content="<?php echo $row['title']; ?>">
                <meta name="twitter:description" content="<?php echo substr(trim(strip_tags($row['short_description'])),0,320); ?>">
                <!-- Twitter summary card with large image must be at least 280x150px -->
                <meta name="twitter:image:src" content="<?php echo $this->crud_model->file_view('product',$row['product_id'],'','','no','src','multi','one'); ?>">
                
                <!-- Open Graph data -->
                <meta property="og:title" content="<?php echo $row['title']; ?>" />
                <meta property="og:type" content="article" />
                <meta property="og:url" content="<?php  echo base_url(); ?>index.php/home/product_view/<?php echo $row['product_id']; ?>" />
                <meta property="og:image" content="<?php echo $this->crud_model->file_view('product',$row['product_id'],'','','no','src','multi','one'); ?>" />
                <meta property="og:description" content="<?php echo substr(trim(strip_tags($row['short_description'])),0,320); ?>" />
                <meta property="og:site_name" content="<?php echo $row['title']; ?>" />
                <?php
			}
		} 
        if($page_name == 'vendor_home')
        {
            $vendor_data = $this->db->get_where('vendor',array('vendor_id'=>$vendor))->result_array();
            foreach($vendor_data as $row)
            {
	           ?>
                    <!-- Schema.org markup for Google+ -->
                    <meta itemprop="name" content="<?php echo $row['display_name']; ?>">
                    <meta itemprop="description" content="<?php echo strip_tags($row['description']); ?>">
                    <meta itemprop="image" content="<?php echo base_url(); ?>uploads/vendor/logo_<?php echo $vendor; ?>.png">
                    
                    <!-- Twitter Card data -->
                    <meta name="twitter:card" content="summary_large_image">
                    <meta name="twitter:site" content="@publisher_handle">
                    <meta name="twitter:title" content="<?php echo $row['display_name']; ?>">
                    <meta name="twitter:description" content="<?php echo strip_tags($row['description']); ?>">
                    <!-- Twitter summary card with large image must be at least 280x150px -->
                    <meta name="twitter:image:src" content="<?php echo base_url(); ?>uploads/vendor/logo_<?php echo $vendor; ?>.png">
                    
                    <!-- Open Graph data -->
                    <meta property="og:title" content="<?php echo $row['display_name']; ?>" />
                    <meta property="og:type" content="article" />
                    <meta property="og:url" content="<?php  echo base_url(); ?>index.php/home/vendor/<?php echo $row['vendor_id']; ?>" />
                    <meta property="og:image" content="<?php echo base_url(); ?>uploads/vendor/logo_<?php echo $vendor; ?>.png" />
                    <meta property="og:description" content="<?php echo strip_tags($row['description']); ?>" />
                    <meta property="og:site_name" content="<?php echo $system_title; ?>" />
                <?php
            }
        }
    ?>
    
    <!-- Favicon -->
    <?php $ext =  $this->db->get_where('ui_settings',array('type' => 'fav_ext'))->row()->value;?>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>uploads/others/favicon.<?php echo $ext; ?>">

        <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700&amp;subset=latin-ext" rel="stylesheet">
        
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/drsnew/plugins/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/drsnew/fonts/Linearicons/Linearicons/Font/demo-files/demo.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>template/drsnew/plugins/bootstrap4/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/drsnew/plugins/owl-carousel/assets/owl.carousel.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/drsnew/plugins/slick/slick/slick.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/drsnew/plugins/lightGallery-master/dist/css/lightgallery.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/drsnew/plugins/jquery-bar-rating/dist/themes/fontawesome-stars.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/drsnew/plugins/jquery-ui/jquery-ui.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/drsnew/plugins/select2/dist/css/select2.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/js/share/jquery.share.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/drsnew/css/style.css">
		
        <script src="<?php echo base_url(); ?>template/drsnew/plugins/jquery-1.12.4.min.js"></script>
	
</head>

<?php
    $theme_color =  $this->db->get_where('ui_settings',array('type' => 'header_color'))->row()->value;
?>
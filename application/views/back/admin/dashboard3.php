<link rel="stylesheet" href="<?php echo base_url(); ?>template/back//amcharts/style.css" type="text/css">
<script src="<?php echo base_url(); ?>template/back/amcharts/amcharts.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/back/amcharts/serial.js" type="text/javascript"></script>
<script src="http://www.google.com/jsapi"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/tags/markerclusterer/1.0/src/markerclusterer.js"></script>
<script src="<?php echo base_url(); ?>template/back/plugins/gauge-js/gauge.min.js"></script>

<div id="content-container">	
    <div id="page-title">
        <h1 class="page-header text-overflow"><?php echo translate('dashboard');?></h1>
    </div>
    <div id="page-content">
  <!--      <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="col-md-4 col-lg-4">
                    <div class="panel panel-bordered panel-purple">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php //echo translate('24_hours_stock');?></h3>
                        </div>
                        <div class="panel-body">
                            <div class="text-center">
                                <canvas id="gauge1" height="70" class="canvas-responsive"></canvas>
                                <p class="h4">
                                    <span class="label label-purple"><?php// echo currency();?></span>
                                    <span id="gauge1-txt" class="label label-purple">0</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 col-lg-4">
                    <div class="panel panel-bordered panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php //echo translate('24_hours_sale');?></h3>
                        </div>
                        <div class="panel-body">
                            <div class="text-center">
                                <canvas id="gauge2" height="70" class="canvas-responsive"></canvas>
                                <p class="h4">
                                    <span class="label label-success"><?php//echo currency();?></span>
                                    <span id="gauge2-txt" class="label label-success">0</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 col-lg-4">
                    <div class="panel panel-bordered panel-black">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php// echo translate('24_hours_destroy');?></h3>
                        </div>
                        <div class="panel-body">
                            <div class="text-center">
                                <canvas id="gauge3" height="70" class="canvas-responsive"></canvas>
                                <p class="h4">
                                    <span class="label label-black"><?php //echo currency();?></span>
                                    <span id="gauge3-txt" class="label label-black">0</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
        
        <div class="row">
            <div class="col-md-12 col-lg-12">

            	<div class="col-md-8 col-lg-8">
                    <div class="panel panel-bordered panel-grad">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo translate('vendor_statistics');?></h3>
                        </div>
                        <div class="panel-body">
                            <div class="text-center">
                                <div class="col-md-12 col-lg-12">
                                    <div class="panel-body">
                                        <div id="chartdiv5" style="width: 100%; height: 250px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="panel panel-bordered panel-dark" style="height:128px;">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo translate('total_vendors');?></h3>
                        </div>
                        <div class="panel-body">
                            <div class="text-center">
                                <h1>
                                    <?php echo $this->db->get('vendor')->num_rows();?>
                                </h1>
                            </div>
                        </div>
                    </div>
                <div class="panel panel-bordered panel-dark" style="height:128px;">
                    <div class="panel-heading">
                       <h3 class="panel-title"><?php echo translate('pending_vendors');?></h3>
                      </div>
                        <div class="panel-body">
                            <div class="text-center">
                                <h1>
                                    <?php echo $this->db->get_where('vendor',array('status != '=>'approved'))->num_rows();?>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
     <!--   <div class="row">
            <div class="col-md-12 col-lg-12">
            	<div class="col-md-6 col-lg-6">
                    <div class="panel panel-bordered panel-grad">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php //echo translate('pending_order_map');?></h3>
                        </div>
                        <div class="map-container">
                            <div id="map" class="mapping"></div>
                        </div>
                    </div>
                </div>
            	<div class="col-md-6 col-lg-6">
                    <div class="panel panel-bordered panel-grad2">
                        <div class="panel-heading">
                            <h3 class="panel-title">
								<?php //echo translate('present_customer_live_on_your_store');?>
                            </h3>
                        </div>
                        <div class="map-container">
                            <div id="map1" class="mapping"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->

       <!--<div class="row">
			<div class="col-md-12 col-lg-12">
                <div class="col-md-6 col-lg-6">
                    <div class="panel panel-bordered panel-purple">
                        <h3 class="panel-title" style="border-bottom:1px #9365b8 solid; !important;">
							<?php //echo translate('category_wise_monthly_stock');?>
                        </h3>
                        <div class="panel-body">
                            <div id="chartdiv" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                	<div class="panel panel-bordered panel-success">
                        <h3 class="panel-title" style="border-bottom:1px #00a65a solid; !important;">
                            <?php //echo translate('category_wise_monthly_sale');?>
                        </h3>
                        <div class="panel-body">
                            <div id="chartdiv2" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
        
        <!--<div class="row">
			<div class="col-md-12 col-lg-12">
                <div class="col-md-6 col-lg-6">
                    <div class="panel panel-bordered panel-black">
                        <h3 class="panel-title" style="border-bottom:1px #303641 solid; !important;">
							<?php //echo translate('category_wise_monthly_destroy');?>
                        </h3>
                        <div class="panel-body">
                            <div id="chartdiv3" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                	<div class="panel panel-bordered panel-primary">
                        <h3 class="panel-title" style="border-bottom:1px #458fd2 solid; !important;">
                            <?php //echo translate('category_wise_monthly_grand_profit');?>
                        </h3>
                        <div class="panel-body">
                            <div id="chartdiv4" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
    </div>
    

    <div class="panel-body" id="demo_s">
  <div class="panel-heading">
     <h3 class="panel-title"><?php echo translate('last_10_orders');?></h3>
    </div>
    <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true"  data-show-toggle="true" data-show-columns="true" data-search="true" >

       
        <thead>
            <tr>
                <th style="width:4ex"><?php echo translate('ID');?></th>
                <th><?php echo translate('order_id');?></th>
                <th><?php echo translate('customer');?></th>
                <th><?php echo translate('delivery_status');?></th>
                <th><?php echo translate('payment_status');?></th>
                 <th><?php echo translate('total');?></th>
                <th><?php echo translate('date_added');?></th>
                <th class="text-center"><?php echo translate('Action');?></th>
            </tr>
        </thead>
            
        <tbody>
        <?php
            
            $this->db->order_by('sale_id', 'desc');
            $all_sales= $this->db->get('sale',10)->result_array();
            $i = 0;
            foreach($all_sales as $row1){
                $i++; 
        ?>
        <tr class="<?php if($row1['viewed'] !== 'ok'){ echo 'pending'; } ?>" >
            <td><?php echo $i; ?></td>
            <td>#<?php echo $row1['sale_code']; ?></td>
            <td><?php
                if($row1['buyer']==0)
                {
                echo  translate('guest');
                }
                else
                {
                echo $this->crud_model->get_type_name_by_id('user',$row1['buyer'],'username'); 
                }
                ?>
                </td>
             <td>
				<?php 
					$this->benchmark->mark_time();
                    $delivery_status = json_decode($row1['delivery_status'],true); 
                    foreach ($delivery_status as $dev) {
                ?>

                <div class="label label-<?php if($dev['status'] == 'delivered'){ ?>purple<?php } else { ?>danger<?php } ?>">
                <?php
                        if(isset($dev['vendor'])){
                            echo $this->crud_model->get_type_name_by_id('vendor', $dev['vendor'], 'display_name').' ('.translate('vendor').') : '.$dev['status'].'<br>';
                        } else if(isset($dev['admin'])) {
                            echo translate('admin').' : '.$dev['status'];
                        }
                ?>
                </div>
                <?php
                    }
                ?>
            </td>
             <td>

                <?php 
                    $payment_status = json_decode($row1['payment_status'],true); 
                    foreach ($payment_status as $dev) {
                ?>

                <div class="label label-<?php if($dev['status'] == 'paid'){ ?>purple<?php } else { ?>danger<?php } ?>">
                <?php
                        if(isset($dev['vendor'])){
                            echo $this->crud_model->get_type_name_by_id('vendor', $dev['vendor'], 'display_name').' ('.translate('vendor').') : '.$dev['status'].'<br>';
                        } else if(isset($dev['admin'])) {
                            echo translate('admin').' : '.$dev['status'];
                        }
                ?>
                </div>
                <?php
                    }
                ?>
            </td>
             <td class="pull-left"><?php echo currency().$this->cart->format_number($row1['grand_total']); ?></td>
            <td><?php echo date('d-m-Y',$row1['sale_datetime']); ?></td>
           
           
           
            <td class="text-right">
            
               <a href="sales/<?php echo $row1['sale_id']; ?>" class="btn btn-info btn-xs btn-labeled fa fa-file-text" data-toggle="tooltip" 
                    onclick="ajax_set_full('order_home','<?php echo translate('title'); ?>','<?php echo translate('successfully_edited!'); ?>','sales_view','<?php echo $row1['sale_id']; ?>')" 
                        data-original-title="Edit" data-container="body"><?php echo translate('view'); ?>
                </a>

              </td>
        </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
</div>
    

</div>


<?php
	$ago = time()-86400;
	$result = $this->db->get_where('stock',array('datetime >= '=>$ago,'datetime <= '=>time()))->result_array();

	$result2 = $this->db->get_where('sale',array('sale_datetime >= '=>$ago,'sale_datetime <= '=>time()))->result_array();
	$stock = 0;
	foreach($result as $row){
		if($row['type'] == 'add'){
			$stock += $row['total'];
		}
	}
	$destroy = 0;
	foreach($result as $row){
		if($row['type'] == 'destroy'){
            if($row['reason_note'] !== 'sale'){
    			$destroy += $row['total'];
            }
		}
	}
	$sale = 0;
	foreach($result2 as $row){
		$sale += $row['grand_total'];
	}
?>


<script>
	var base_url = '<?php echo base_url(); ?>';
	var stock = <?php if($stock == 0){echo .1;} else {echo $stock;} ?>;
	var stock_max = <?php echo ($stock*3.5/3+100); ?>;
	var destroy = <?php if($destroy == 0){echo .1;} else {echo $destroy;} ?>;
	var destroy_max = <?php echo ($destroy*3.5/3+100); ?>;
	var sale = <?php if($sale == 0){echo .1;} else {echo $sale;} ?>;
	var sale_max = <?php echo ($sale*3.5/3+100); ?>;
	var currency = '<?php echo currency(); ?>';
	var cost_txt = '<?php echo translate('cost'); ?>(<?php echo currency(); ?>)';
	var value_txt = '<?php echo translate('value'); ?>(<?php echo currency(); ?>)';
	var loss_txt = '<?php echo translate('loss'); ?>(<?php echo currency(); ?>)';
	var pl_txt = '<?php echo translate('profit'); ?>/<?php echo translate('loss'); ?>(<?php echo currency(); ?>)';

	var sale_details = [
	<?php
		$this->db->where('delivery_status','pending');
		$sales = $this->db->get('sale')->result_array();
		foreach($sales as $row){
		$orders 	= json_decode($row['shipping_address'],true);
		$address 	= str_replace("'","",$orders['address1']).' '.str_replace("'","",$orders['address2']);
		$langlat 	= explode(',',str_replace('(','',str_replace(')','',$orders['langlat'])));
		$grand_total = $row['grand_total'];
	?>
		['<?php echo $address; ?>', <?php echo $langlat[0]; ?>, <?php echo $langlat[1]; ?>, '<?php echo currency().$this->cart->format_number($grand_total); ?>'],
	<?php } ?>
	];
	
	var sale_details1 = [
	<?php
		$current_surfers = $this->db->get('ci_sessions')->result_array();
		foreach ($current_surfers as $row) {
			if($row['data'] !== ''){
				$udata = $row['data'];
				if (strpos($udata,'{') !== false) {
					$udata = explode('"{', $udata);
					$udata = explode('}'."\n".'"', $udata[1]);
					$surfer_info = json_decode('{'.$udata[0].'}',true);
					if($surfer_info['status'] == 'success'){
						$lat = $surfer_info['lat'];
						$lon = $surfer_info['lon'];
						$city = $surfer_info['city'];
						$con = $surfer_info['country'];
						if(@$udata['user_login']){
							$user_name = $this->crud_model->get_type_name_by_id('user',$udata['user_id'],'username');
						} else {
							$user_name = translate('unknown_user');
						}
	?>
		['<?php echo $user_name; ?>', <?php echo $lat; ?>, <?php echo $lon; ?>, '<?php echo str_replace("'","",$city).' '.str_replace("'","",$con); ?>'],
	<?php
					}
				}
			}
		}
	?>
	];
		
	var chartData1 = [ 
		<?php
			$categories = $this->db->get('category')->result_array();
			foreach($categories as $row) {
				$this->crud_model->month_total('stock', 'category', $row['category_id'], 'type', 'add'); 
		?> 
		{
			 "country": "<?php echo $row['category_name']; ?>",
			 "visits": <?php echo $this->crud_model->month_total('stock', 'category', $row['category_id'], 'type', 'add'); ?> ,
			 "color": "#9365b8"
		 }, 
		 <?php
			} 
		 ?>
	];

	var chartData2 = [
		<?php
			$categories = $this->db->get('category')->result_array();
			foreach($categories as $row) {
				$this->crud_model->month_total('sale', 'category', $row['category_id']);
		 ?>
		 {
			 "country": "<?php echo $row['category_name']; ?>",
			 "visits": <?php echo $this->crud_model->month_total('sale', 'category', $row['category_id']); ?>,
			 "color": "#00a65a"
		 }, 
		 <?php
			}
		?>
	];

	var chartData3 = [
		<?php
			$categories = $this->db->get('category')->result_array();
			foreach($categories as $row) {
				$this->crud_model->month_total('stock', 'category', $row['category_id'], 'type', 'destroy'); 
		 ?>
		 {
			 "country": "<?php echo $row['category_name']; ?>",
			 "visits": <?php echo $this->crud_model->month_total('stock', 'category', $row['category_id'], 'type', 'destroy', 'reason_note', "sale"); ?> ,
			 "color": "#303641"
		 }, 
		 <?php
			} 
		 ?>
	];

	var chartData4 = [
		<?php
			$categories = $this->db->get('category')->result_array();
			foreach($categories as $row) {
				$fin = ($this->crud_model->month_total('sale', 'category', $row['category_id'])) - ($this->crud_model->month_total('stock', 'category', $row['category_id'], 'type', 'add'));
		?>
		{
			"country": "<?php echo $row['category_name']; ?>",
			"visits": <?php echo $fin; ?> ,
			"color": "#458fd2"
		},
		<?php
		}
		?>
	];

	var chartData5 = [
		{
			"country": "Default",
			"visits": <?php echo $this->db->get_where('vendor',array('membership'=>'0'))->num_rows(); ?> ,
			"color": "#458fd2"
		},
		<?php
			$membership_type = $this->db->get('membership')->result_array();
			foreach($membership_type as $row) {
				$fin = $this->db->get_where('vendor',array('membership'=>$row['membership_id']))->num_rows();
		?>
		{
			"country": "<?php echo $row['title']; ?>",
			"visits": <?php echo $fin; ?> ,
			"color": "#458fd2"
		},
		<?php
		}
		?>
	];
</script>
<script src="<?php echo base_url(); ?>template/back/js/custom/dashboard.js"></script>
<style>
	  #map-container {
		padding: 6px;
		border-width: 1px;
		border-style: solid;
		border-color: #ccc #ccc #999 #ccc;
		-webkit-box-shadow: rgba(64, 64, 64, 0.5) 0 2px 5px;
		-moz-box-shadow: rgba(64, 64, 64, 0.5) 0 2px 5px;
		box-shadow: rgba(64, 64, 64, 0.1) 0 2px 5px;
		width: 100%;
	  }
	  #map {
		width: 100%;
		height: 400px;
	  }
	  #map1 {
		width: 100%;
		height: 400px;
	  }
	  #actions {
		list-style: none;
		padding: 0;
	  }
	  #inline-actions {
		padding-top: 10px;
	  }
	  .item {
		margin-left: 20px;
	  }
</style>
<div class="panel-body" id="demo_6">
    <?php
         //  foreach( $low_stocks as $row){ print_r($row); }
    ?>
    <div class="panel-heading">
       <h3 class="panel-title"><?php echo translate('low_stock_products');?></h3>
    </div>
    <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true"  data-show-toggle="true" data-show-columns="true" data-search="true" >
        <thead>
            <tr>
                <th style="width:4ex"><?php echo translate('ID');?></th>
                <th data-field="image" data-align="right" data-sortable="true">
                    <?php echo translate('image');?>
                </th>
                <th data-field="title" data-align="left" data-sortable="true" class="bck_end_title">
                    <?php echo translate('title');?>
                </th>
                <th data-field="title" data-align="left" data-sortable="true" class="bck_end_category">
                    <?php echo translate('category');?>
                </th>
              
                <th data-field="current_stock" data-sortable="true">
                    <?php echo translate('current_quantity');?>
                </th>
                <!--<th class="text-center"><?php echo translate('Action');?></th>-->
            </tr>
        </thead>
        <tbody><?php 
//            $query				=	$this->db->get_where('product',['view_front'=>1])->result();
//            $res				=	false;
//            if($query){ foreach(	$query	as $row){ if($row->min_alert >= $row->current_stock ){ $res[]	=	$row; } } }
            foreach( $low_stocks as $row){ ?>
                <tr>
                    <td><?php echo $row->product_id?></td>
                        <td><img class="img-sm" style="height:auto !important; border:1px solid #ddd;padding:2px; border-radius:2px !important;" src="<?php echo $this->crud_model->file_view('product',$row->product_id,'','','thumb','src','multi','one')?>"  /></td>
                        <td><?php echo $row->title?></td>
                        <td><?php echo $row->category_name?></td>
                        <td><?php echo (int)$row->current_stock.' '.$row->unit?></td>
                        <!--<td></td>-->
                </tr> 
                <?php 
                
            } ?>
        </tbody>
    </table>
</div>
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				

        <tbody>
    </table>
</div>
            
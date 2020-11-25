<div>
	<?php
        echo form_open(base_url() . 'vendor/sales', array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'image_add',
            'enctype' => 'multipart/form-data'
        ));
        ?>

        <div class="panel-body">
			<div class="form-group">
					<div class="col-sm-12 nopad">
						<div id='spip-wrap' class="file-thump" >
							<?php
								if($receipt)
								{
									//print_r($receipt);
									$ext = pathinfo($receipt->receipt, PATHINFO_EXTENSION);
									if($ext=='pdf')
									{
										?>
										<span id="file-prev">
											<i class="fa fa-file-pdf-o fa-5x" aria-hidden="true"></i>
											<br/><br/>
											<a class='img-down btn btn-mint btn-xs' href="<?php echo base_url('uploads/
sale_receipt').'/'.$receipt->receipt; ?>" download="<?php echo 'payment_'.$sale_data->sale_code.'.'.$ext; ?>">Download</a>
										</span>
										<?php
										
									}
									else if($ext=='doc' || $ext=='docx')
									{
										?>
										<span id="file-prev">
											<i class="fa fa-file-word-o fa-5x" aria-hidden="true"></i>
											<br/><br/>
											<a class='img-down btn btn-mint btn-xs' href="<?php echo base_url('uploads/
sale_receipt').'/'.$receipt->receipt; ?>" download="<?php echo 'payment_'.$sale_data->sale_code.'.'.$ext; ?>">Download</a>
										</span>
										<?php
									}
									else
									{
										?>
											<img src="<?php echo base_url('uploads/
sale_receipt').'/'.$receipt->receipt; ?>" width="50%" id="img-prev" style="height: 180px;">
											<br/><br/>
											<a class='img-down btn btn-mint btn-xs' href="<?php echo base_url('uploads/
sale_receipt').'/'.$receipt->receipt; ?>" download="<?php echo 'payment_'.$sale_data->sale_code.'.'.$ext; ?>">Download</a>
										<?php
									}
								}
							?>
						</div>
					
			 </div>
		   </div>
        </div>
	     <?php 
       echo form_close();
    ?>
</div>



<style>
	.modal-footer,.shide-data 
	{
		display:none;
	}
	
</style>


<div id="content-container">
	<div id="page-title">
		<center>
        	<h1 class="page-header text-overflow"><?php echo translate('Total Sales Invoice');?></h1>
        </center>
    </div>

    <div class="tab-base">
        <div class="panel">
            <div class="panel-body">
                <div class="tab-content row" >
					 <?php
						echo form_open(base_url() . 'vendor/report_sale/list', array(
								'class' => 'form-horizontal',
								'method' => 'post',
								'id' => 'total_sales',
								'enctype' => 'multipart/form-data'
							));
						?>

	 					<div class="col-md-10 " >
							<div class="btn-group col-md-offset-4" >
								<span class="btn btn-default btn-primary btn-labeled fa fa-calendar"  id="sda" onclick="dats()">
									Date 
								</span>
							</div>
							<div class=" btn-group ">
								<input type="text" class=" srtd  srt " id="dats" hidden="hidden" required="required"  name="dats" value="<?php echo date('m-d-y'); ?>" />
							</div>
							<br/>
							<br/>
							<div class=" btn-group col-md-offset-4" >
								<span class="btn btn-default btn-primary btn-labeled fa fa-calendar" id="smo" onclick="mnts()" >
									Month 
								</span>
							</div>
							<div class=" btn-group " >
								<input type="text" id="mnts" class="srtm srt " name="mnts" hidden="hidden" required="required" value="month,year">
								<input type="text" id="test3" name="dorms"  hidden="hidden" value="no" />
							</div>

							<div class=" col-md-offset-5">
								<br/>
							 	<button type="submit" class="btn  btn-info active btn-lg btn-labeled fa fa-file-text">
								Get Total Sales Invoice   </button>
							</div>
	 					</div>
						<?php 
					echo form_close();
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>

<script>

    var base_url = '<?php echo base_url(); ?>'
    var user_type = 'vendor';
    var module = 'report_sale';
    //var list_cont_func = 'list';
    var dlt_cont_func = 'delete';
    var loading = '<div>loading...<div>';


		var currentTime = new Date() ;
		var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), +1); 
		var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +2, +0);

		$('#dats').datepicker(
			{
				dayOfWeekStart : 1,
				lang:'en',
				timepicker:false,
				format:'yyyy-m-d',
				startDate:  '2017/01/05',
				endDate: currentTime,
				autoclose: true
			});

		$('#mnts').datepicker(
			{
				autoclose: true,
				minViewMode: 1,
				format: 'yyyy-mm',
				endDate: minDate
			});


</script>




<style>
    .highlight{
        background-color: #E7F4FA;
    }
</style>


<script type="text/javascript">

function dats()
{
	//$("#smo").show();
	$("#mnts").hide();
	$('#mnts').removeAttr('required');

	//$("#sda").hide();
	$("#dats").show();
	$("#yer").hide();
	$("#dats").attr('class','srtd  srt  form-control');
	$("#dats").attr('required','required');
	$("#test3").val("1");
}

function mnts()
{
	//$("#sda").show();
	//$("#smo").hide();
	$("#dats").hide();
	$("#mnts").show();
	$("#yer").show();
	$('#dats').removeAttr('required');
	$("#mnts").attr('class','srtm srt form-control');
	$("#mnts").attr('required','required');
	$("#test3").val("2");
}
</script>



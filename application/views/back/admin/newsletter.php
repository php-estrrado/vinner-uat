<div id="content-container">
	<div id="page-title">
		<h1 class="page-header text-overflow" ><?php echo translate('send_newsletter')?></h1>
	</div>
	<div class="tab-base">
		<!--Tabs Content-->
		<div class="panel">
		<!--Panel heading-->
			<div class="panel-body">
				<div class="tab-content">
					<div class="tab-pane fade active in" id="lista">
						<div class="panel-body news-letter-form" id="demo_s">
							<?php
                                echo form_open(base_url() . 'admin/newsletter/send/', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post',
									'id' => ''
                                ));
                            ?>
		                        <div class="row">
			                        <?php
				                        $user_list = array();
				                        $subscribers_list = array();
				                        foreach ($users as $row) {
				                        	$user_list[] = $row['email'];
				                        }
				                        foreach ($subscribers as $row) {
				                        	$subscribers_list[] = $row['email'];
				                        }
			                        	$user_list = join(',',$user_list);
			                        	$subscribers_list = join(',',$subscribers_list);
			                        ?>
									<?php /*
	                            	<h3 class="panel-title"><?php echo translate('e-mails_(users)')?></h3>
					                <div class="form-group btm_border">
					                    <div class="col-sm-12">
					                        <input type="text" name="users" data-role="tagsinput" 
					                        	placeholder="<?php echo translate('e-mails_(users)')?>" class="form-control"
					                        		value="<?php echo $user_list; ?>">
					                    </div>
					                </div>
									*/ ?>
	                            	<h3 class="panel-title"><?php echo translate('subscriber_e-mails')?></h3>
					                <div class="form-group btm_border">
					                    <div class="col-sm-12">
					                        <input type="text" name="subscribers" data-role="tagsinput" 
					                        	placeholder="<?php echo translate('e-mails_(subscribers)')?>" class="form-control required" value="<?php echo $subscribers_list; ?>">
					                    </div>
					                </div>
	                            	<h3 class="panel-title"><?php echo translate('from_:_email_address')?></h3>
					                <div class="form-group btm_border">
					                    <div class="col-sm-12">
					                        <input type="email" name="from" placeholder="<?php echo translate('from_:_email_address')?>" class="form-control required">
					                    </div>
					                </div>
	                            	<h3 class="panel-title"><?php echo translate('newsletter_subject')?></h3>
					                <div class="form-group btm_border">
					                    <div class="col-sm-12">
					                        <input type="text" name="title" 
                                            	placeholder="<?php echo translate('newsletter_subject')?>" class="form-control required">
					                    </div>
					                </div>
	                            	
	                            	<h3 class="panel-title"><?php echo translate('newsletter_content')?></h3>
	                                <textarea class="summernotes" data-height='700' data-name='text' class="required" ></textarea>

	                            </div>
	                            <div class="panel-footer text-right">
	                                <span class="btn btn-info newsubmitter"  data-ing='<?php echo translate('sending'); ?>' data-msg='<?php echo translate('sent!'); ?>'>
										<?php echo translate('send')?>
                                     </span>
	                            </div>
	                       		<?php
							echo form_close();
						  ?>
	                    </div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>


<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script>
	$(document).ready(function() 
	{
		$('.summernotes').each(function() {
			var now = $(this);
			var h = now.data('height');
			var n = now.data('name');
			now.closest('div').append('<input type="hidden" class="val" name="' + n + '">');
			now.summernote({
				height: h,
				onChange: function() {
					now.closest('div').find('.val').val(now.code());
				}
			});
			now.closest('div').find('.val').val(now.code());
		});
	});
	
	var base_url = '<?php echo base_url(); ?>';
	var user_type = 'admin';
	var module = 'newsletter';
	var list_cont_func = 'list';
	var dlt_cont_func = 'delete';
	
	  $('.news-letter-form').on('click','.newsubmitter', function()
	  {
        //alert('vdv');
        var here = $(this); // alert div for show alert message
        var form = here.closest('form');
        var can = '';
		var ing = here.data('ing');
		var msg = here.data('msg');
		var prv = here.html();
		form.find('.summernotes').each(function() 
		{
            var now = $(this);
            now.closest('div').find('.val').val(now.code());
        });
        //var form = $(this);
        var formdata = false;
        if (window.FormData)
		{
            formdata = new FormData(form[0]);
        }
        var a = 0;
        var take = '';
        form.find(".required").each(function()
		{
       		var txt = '*'+req;
            a++;
            if(a == 1){
                take = 'scroll';
            }

            var here = $(this);

            if(here.val() == ''){

                if(!here.is('select')){

                    here.css({borderColor: 'red'});

                    if(here.attr('type') == 'number'){

                        txt = '*'+mbn;

                    }

                    if(here.closest('div').find('.require_alert').length){

                    } else {
                        sound('form_submit_problem');
                        here.closest('div').append(''
                            +'  <span id="'+take+'" class="label label-danger require_alert" >'
                            +'      '+txt
                            +'  </span>'
                        );
                    }
                } 
				else if(here.is('select'))
				{
                    here.closest('div').find('.chosen-single').css({borderColor: 'red'});
                    if(here.closest('div').find('.require_alert').length){

                    } 
					else 
					{
                        sound('form_submit_problem');
                        here.closest('div').append(''
                            +'  <span id="'+take+'" class="label label-danger require_alert" >'
                            +'      *Required'
                            +'  </span>'
                        );
                    }
                }
                var topp = 100;
                $('html, body').animate({
                    scrollTop: $("#scroll").offset().top - topp
                }, 500);
                can = 'no';
            }

			if (here.attr('type') == 'email')
			{
				if(!isValidEmailAddress(here.val()))
				{
					here.css({borderColor: 'red'});
					if(here.closest('div').find('.require_alert').length){
					} 
					else 
					{
						sound('form_submit_problem');
						here.closest('div').append(''
							+'  <span id="'+take+'" class="label label-danger require_alert" >'
							+'      *'+mbe
							+'  </span>'
						);
					}
					can = 'no';
				}
			}
            take = '';
        });

        if(can !== 'no')
		{
            $.ajax({
                url: form.attr('action'), // form action url
                type: 'POST', // form submit method get/post
                dataType: 'html', // request type html/json/xml
                data: formdata ? formdata : form.serialize(), // serialize form data 
                cache       : false,
                contentType : false,
                processData : false,
                beforeSend: function() 
				{
                    here.html(ing); // change submit button text
                },
                success: function() 
				{
					//console.log(data);
                    here.fadeIn();
                    here.html(prv)
                    $.activeitNoty({
                        type: 'success',
                        icon : 'fa fa-check',
                        message : msg,
                        container : 'floating',
                        timer : 3000
                    });
                    if($('body .slider_preview').length)
					{
                    	ajax_set_list();
                    }
                },
                error: function(e) {
                    console.log(e)
                }
            });
        } 
		else 
		{
            sound('form_submit_problem');
            return false;
        }
    });
</script>
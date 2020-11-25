
	<?php
		$lists 	 	= $chatLists['list'];
		$details 	= $chatLists['details'];
		$cId 		= $chatId;//$chatLists['chatId'];
		$defchatid 	= 0;
		//print_r($chatLists);
	?>

	<div class="ps-page--single">
	    <div class="ps-breadcrumb">
	        <div class="container">
	          <ul class="breadcrumb">
	            <li><a href="<?php echo base_url(); ?>">Home</a></li>
	            <li><a href="<?php echo base_url('home/chat'); ?>">Chat</a></li>
	            <!-- <li><a href="<?php echo base_url(); ?>"></a></li> -->
	          </ul>
	        </div>
	    </div>
	    <div class="ps-vendor-store">
	        <div class="container">
		        <div class="ps-section__container">
		            <div class="ps-section__left">
		              	<div class="ps-block--vendor">
			                <div id="sidebxwrap" class="sidebx">
			                    <ul>
			                    	<?php
			                    		//print_r($lists);
			                    		if($lists) 
			                    		{
											$memberName=$mamberAvthar=$userAvthar='';
											$userAvthar = base_url('uploads/user_image/default.png');
											$mamberAvthar=base_url('uploads/vendor/logo_0.png');
											
			                    			foreach ($lists as $ckey) 
			                    			{
			                    				$active = '';
$vendor_data=$this->db->get_where('vendor',array('vendor_id'=>$ckey->vendor_id,'status'=>'approved'))->row();
											   if($vendor_data)
											   {
													if ($ckey->chat_id == $chatId) 
													{
														$active = 'active';
														if(file_exists('uploads/user_image/user_'.$user.'.jpg')) 
														{
															$userAvthar = base_url().'uploads/user_image/user_'.$user.'.jpg';
														}
														$memberName=ucfirst($vendor_data->display_name);
														if(file_exists('uploads/vendor/logo_'.$ckey->vendor_id.'.png')) 
														{
															$mamberAvthar=base_url('uploads/vendor/logo_'.$ckey->vendor_id.'.png');
														}
													} 

													?>
													<li class="<?php echo $active . ' -' . $chatId ?> chat-li">
														<a href="<?php echo base_url('home/chat/'. $ckey->chat_id);?>">
															<?php 
																echo ucfirst($vendor_data->display_name); 
																if($ckey->user_unread >0 && !$active)
																{
																	?>
																	<span class="msg_cnt"><i class="fa  fa-envelope"></i></span>
																	<?php
																}
															?>
														</a>
													</li>
			                        			<?php
											  }
			                    			}
			                    			
			                    		}
			                    		else 
	                        			{
	                            			echo '<li class="tac">No Chats</li>';
	                        			}
			                    	?>
			                    </ul>
			                </div>
		              	</div>
		            </div>

		            <div class="ps-section__right">
		                <div class="chat_window">
		                    <ul class="messages">
		                      	<?php
	                                $lastId = 0;
	                                if ($details) 
	                                {
	                                    foreach ($details as $detail) 
	                                    {
	                                    	//print_r($detail);
	                                        if ($detail->msg_from == $user) 
	                                        {
	                                            $side = 'right';
	                                            $ta = 'tar';
	                                            $name = 'You';
	                                            $avthar = $userAvthar;
	                                        } 
	                                        else 
	                                        {
	                                            $side = 'left';
	                                            $ta = 'tal';
	                                          $rvendor_data=$this->db->get_where('vendor',array('vendor_id'=>$detail->msg_from))->row();

			                          			$name = $memberName;//ucfirst($rvendor_data->display_name); 
	                                            $avthar =$mamberAvthar;
	                                        }
	                                        ?>
	                                        <li class="message appeared <?php echo $side ?>">
	                                            <div class="name <?php echo $ta ?>"><?php echo $name ?></div>
	                                            <img class=" avatar img-circle" src="<?php echo $avthar ?>" title="Avthar" />
	                                            <div class="text_wrapper">
	                                                <div class="text <?php echo $ta ?>">
														<?php 
															//echo $detail->msg_type.$detail->message; 
															if($detail->msg_type=='2')
															{
																$ext = pathinfo($detail->message, PATHINFO_EXTENSION);
																if($ext=='pdf')
																{
																	echo '<span id="msg-pdf"><i class="fa fa-file-pdf-o fa-5x" aria-hidden="true"></i><a class="msg-dwnl" download='.md5($detail->chat_messages_id.$ext).' href='.base_url().'uploads/chat_message/'.$detail->message.'><i class="fa fa-download" aria-hidden="true"></i> Download</a></span>';
																}
																else if($ext=='docx')
																{
																	echo '<span id="msg-word"><i class="fa fa-file-word-o fa-5x" aria-hidden="true"></i><a class="msg-dwnl" download='.md5($detail->chat_messages_id.$ext).'  href='.base_url().'uploads/chat_message/'.$detail->message.'><i class="fa fa-download" aria-hidden="true"></i> Download</a></span>';
																}
																else if($ext=='jpg' || $ext=='png' || $ext=='jpeg')
																{
																	echo '<span id="msg-imag"><img src='.base_url().'uploads/chat_message/'.$detail->message.' /><a class="msg-dwnl" download='.md5($detail->chat_messages_id.$ext).'  href='.base_url().'uploads/chat_message/'.$detail->message.'><i class="fa fa-download" aria-hidden="true"></i> Download</a></span>';
																}
															}
															else
															{
																echo '<span id="msg-text">'.$detail->message.'</span>';
															}
														?>
													</div>
	                                                <div class="time <?php echo $ta ?>"><?php echo $detail->time; ?></div>
	                                            </div>
	                                        </li>
	                                        <?php
	                                        $lastId = $detail->chat_messages_id;
	                                    }
	                                }
	                            ?>
		                    </ul>
		                    <?php 
	                        	if($chatId) 
	                            {	
	                            	?>
				                    <form id="chatForm" name="chatForm" class="bottom_wrapper clearfix">
				                        <div class="row">
		                                    <div class="message_input_wrapper col-md-9 nopad">
		                                        <div class="chattext">
		                                            <input id="msg" name="message" class="message_input" placeholder="Type your message here..." />
		                                        </div>
												<span id="frnt-up-chat-image" onclick="fileupjs('<?php echo $chatId;?>')">
					                                  <i class="fa fa-paperclip" aria-hidden="true"></i>
					                            </span>
		                                    </div>
		                                    <div class="col-md-3 pr_0">
		                                        <button class="send_message btn theme-blue btn-theme btn-default" type="submit">
		                                        	Send
		                                        </button>
		                                    </div>
	                                	</div>
	                                	<input type="hidden" id="lastId" name="lastId" value="<?php echo $lastId ?>" />
				                    </form>
				                     <?php 
	                            }
	                        ?>
		                </div>
						
						
						<div class="modal fade" id="file-up-modal" tabindex="-1" role="dialog"  aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
									   <span class="modal-title" >File Upload</span>
									   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										 <span aria-hidden="true">&times;</span>
									   </button>
									</div>
									<div class="modal-body" id="file-up-form-div">
										
									</div>
								</div>
							</div>
						</div>
						
		            </div>
		        </div>
	        </div>
	    </div>
    </div>



    <script type="text/javascript">

	    $(document).ready(function () 
	    {
	        getChatMessages();
	        $('.chat_window .messages').animate({scrollTop: $('.messages').prop('scrollHeight')}, 200);
	        $('#chatForm').on('submit', function () 
	        {
	            if ($('#msg').val() == '')
	                return false;
	            var message = $('#msg').val();
	            $('#msg').val('');
	            $.ajax({
	                type: "GET",
	                url: "<?php echo base_url('home/addChatMessage/') ?>",
	                cache: false,
	                dataType: 'html',
	                data: {chatId: '<?php echo $cId ?>', from: '<?php echo $user ?>', message: message},
	                success: function (data) 
	                {
	                	//console.log(data);
	                    getChatMessages();
	                }
	            });
	            return false;
	        });

	        
	    });

	    function getChatMessages() 
	    {
	    	//console.log('hi3');
	        var lastId = $('#lastId').val();
	        var name;
	        var side;
	        var ta;
	        var avthar;
	        //console.log(<?php echo $cId ?>+', lastId: '+lastId);
	        $.ajax({
	            type: "GET",
	            url: "<?php echo base_url('home/getChatMessage/') ?>",
	            cache: false,
	            dataType: 'html',
	            data: {chatId: '<?php echo $cId ?>', lastId: lastId},
	            success: function (data) 
	            {
	            	//console.log(data);
	                var obj = jQuery.parseJSON(data);
	                $.each(obj, function (key, value) 
	                {
	                    //  alert(value.message);
	                    if (value.msg_from == '<?php echo $user ?>') 
	                    {
	                        name = 'You';
	                        side = 'right';
	                        ta = 'tar';
	                        avthar = '<?php echo $userAvthar ?>';
	                    } 
	                    else 
	                    {
	                        name = '<?php echo $memberName ?>';
	                        side = 'left';
	                        ta = 'tal';
	                        avthar = '<?php echo $mamberAvthar ?>';
	                    }
	                   	var fleprev='';
						if(value.msg_type==2)
						{
						   let ran = Math.random().toString(36).substring(8);
						   var entx=value.message.split('.').pop().toLowerCase();
						   if(entx=='pdf')
						   {
							   fleprev='<span id="msg-pdf"><i class="fa fa-file-pdf-o fa-5x" aria-hidden="true"></i><a class="msg-dwnl" download='+ran+'.'+entx+' href='+base_url+'uploads/chat_message/'+value.message+'><i class="fa fa-download" aria-hidden="true"></i> Download</a></span>';
						   }
						   else if(entx=='docx')
						   {
							   fleprev='<span id="msg-word"><i class="fa fa-file-word-o fa-5x" aria-hidden="true"></i><a class="msg-dwnl" download='+ran+'.'+entx+'  href='+base_url+'uploads/chat_message/'+value.message+'><i class="fa fa-download" aria-hidden="true"></i> Download</a></span>';
						   }
						   else 
						   {
							   fleprev='<span id="msg-imag"><img src='+base_url+'uploads/chat_message/'+value.message+' /><a class="msg-dwnl" download='+ran+'.'+entx+'  href='+base_url+'uploads/chat_message/'+value.message+'><i class="fa fa-download" aria-hidden="true"></i> Download</a></span>';
						   }
						}
						else
						{
							var fleprev='<span id="msg-text">'+value.message+'</span>';
						}
						var msgList = '<li id="id-' + value.chat_messages_id + '" class="message noapp ' + side + '"><div class="name ' + ta + '">' + name + '</div>\n\<img class=" avatar img-circle" src="' + avthar + '" title="Avthar" /><div class="text_wrapper">\n\<div class="text ' + ta + '">' + fleprev + '</div><div class="time ' + ta + '">' + value.time + '</div>\n\</div></li>';
						
						
	                    $('.messages').append(msgList);
	                    
	                    setTimeout(function () 
	                    {
							$('#id-' + value.chat_messages_id).removeClass('noapp');
	                        $('#id-' + value.chat_messages_id).addClass('appeared');
	                    }, 150);
						$('.chat_window .messages').animate({scrollTop: $('.messages').prop('scrollHeight')}, 200);
	                    lastId = value.chat_messages_id;
	                });
	                $('#lastId').val(lastId);
	            }
	        });
	        setTimeout(function () {
	            getChatMessages();
	        }, 5000);
	    }



	    function fileupjs(fchid) 
	    {
	      
		  var url=base_url+'home/ChatFile/add/'+fchid;
		   $.ajax(
			   {
				url: base_url+'home/ChatFile/add/'+fchid, 
				cache: false,
				dataType: "html",
				beforeSend: function() 
				{
					console.log(url);
				},
				success: function(data) 
				{
					$("#file-up-form-div").html(data);
				},
				error: function(e) 
				{
					console.log(e)
				}
			   });
			
		   $('#file-up-modal').modal('show');
	    }
	</script>

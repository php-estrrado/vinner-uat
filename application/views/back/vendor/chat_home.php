
<div id="content-container">
    <div id="page-title">
        <h1 class="page-header text-overflow"><?php echo translate('chat_messages');?></h1>
    </div>
	
	<div class="tab-base" id="lang_select">
		<div class="panel">
			<div class="panel-body">
                <div class="tab-pane fade active in" >
					
					<div class="">
						<?php
							$lists 	 	= $chatLists['list'];
							$details 	= $chatLists['details'];
							$cId 		= $chatId;
							$defchatid 	= 0;
						?>
						
						<div  class="ps-section__container">
					            <div class="ps-section__left col-lg-4 col-md-4 col-sm-12 col-12 nopad">
					              	<div class="ps-block--vendor">
						                <div id="sidebxwrap" class="sidebx">
						                    <ul>
												<?php
						                    		//print_r($lists);
						                    		if($lists) 
						                    		{
														$memberName=$mamberAvthar=$userAvthar='';
														$userAvthar  = base_url('uploads/vendor/logo_0.png');
														$mamberAvthar = base_url('uploads/user_image/default.png');
														
						                    			foreach ($lists as $ckey) 
						                    			{
						                    				$active = '';
															$user_data=$this->db->get_where('user',array('user_id'=>$ckey->user_id,'status'=>'approved'))->row();
														  if($user_data)
														  {
						                    				if ($ckey->chat_id == $chatId) 
						                    				{
							                                    $active = 'active';
																if(file_exists('uploads/user_image/user_'.$ckey->user_id.'.jpg')) 
				                                				{
				    												$mamberAvthar = base_url().'uploads/user_image/user_'.$ckey->user_id.'.jpg';
				    											}
																$memberName=ucfirst($user_data->username);
																if(file_exists('uploads/vendor/logo_'.$ckey->vendor_id.'.png')) 
				                                				{
																	$userAvthar=base_url('uploads/vendor/logo_'.$ckey->vendor_id.'.png');
																}
							                                } 
						                    				?>
						                    				<li class="<?php echo $active . ' -' . $chatId ?> chat-li">
						                          				<a href="<?php echo base_url('vendor/chat/'. $ckey->chat_id);?>"> 												<b>	
						                          					<?php 
						                          						echo ucfirst($user_data->username);
																		//print_r($user_data);
						                          					?>
																	</b>
																	<?php 
																		if($ckey->vendor_unread>0 && $active!='active')
																		{	?>
																			<span class="cmsg_cnt" >
																				<i class="fa  fa-envelope"></i>
																				<?php // $ckey->vendor_unread; ?>
																			</span>
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

					            <div class="ps-section__right col-lg-8 col-md-8 col-sm-12 col-12 nopad">
					                <div class="chat_window">
					                    <ul class="messages">
					                      	<?php
				                                $lastId = 0;
				                                if ($details) 
				                                {
				                                    foreach ($details as $detail) 
				                                    {
				                                    	//print_r($detail);
				                                        if ($detail->msg_from == $vendor) 
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
				                                        <li id="id-<?php echo $detail->chat_messages_id ?>" class="message appeared <?php echo $side ?>">
				                                            <div class="name <?php echo $ta ?>"><?php echo $name ?></div>
				                                            <img class=" avatar img-circle" src="<?php echo $avthar ?>" title="Avthar" />
				                                            <div class="text_wrapper">
				                                                <div class="text <?php echo $ta ?>">
																	<?php 
																		if($detail->msg_type=='2')
																		{
																			$ext = pathinfo($detail->message, PATHINFO_EXTENSION);
																			if($ext=='pdf')
																			{
																				echo '<span id="msg-pdf"><i class="fa fa-file-pdf-o fa-5x" aria-hidden="true"></i><a class="msg-dwnl" download='.md5($detail->chat_messages_id.$ext).' href='.base_url().'uploads/chat_message/'.$detail->message.'><i class="fa fa-download" aria-hidden="true"></i> Download</a></span>';
																			}
																			else if($ext=='docx')
																			{
																				echo '<span id="msg-word"><i class="fa fa-file-word-o fa-5x" aria-hidden="true"></i><a class="msg-dwnl" download='.md5($detail->chat_messages_id.$ext).' href='.base_url().'uploads/chat_message/'.$detail->message.'><i class="fa fa-download" aria-hidden="true"></i> Download</a></span>';
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
																		
																		//print_r($detail);
																	?>
																</div>
				                                                <div class="time <?php echo $ta ?>">
																	<?php echo $detail->time; ?>
																</div>
																<div class="clear"></div>
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
					                                    <div class="message_input_wrapper col-md-9">
					                                        <div class="chattext">
					                                            <input id="msg" name="message" class="message_input" placeholder="Type your message here..." />
					                                        </div>
															<span data-toggle="tooltip" onclick="ajax_modal('add','<?php echo translate('file_upload'); ?>','<?php echo translate('successfully_added!'); ?>','chat_image',<?php echo $cId; ?>)" data-original-title="Edit" data-container="body" id="up-chat-image">
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
					            </div>
					        </div>
						
					</div>
                
		<div class="modal fade" id="image-up-modal" tabindex="-1" role="dialog"  aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
			   	<div class="modal-content">
				    <div class="modal-header">
				       <span class="modal-title" >Image Upload</span>
				       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				         <span aria-hidden="true">&times;</span>
				       </button>
				    </div>
				    <div class="modal-body">
				       
				    </div>
				    <div class="modal-footer">
				       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				       <button type="button" class="btn btn-primary">Send</button>
				    </div>
			   	</div>
			</div>
		</div>
					
					
                </div>
			</div>
        </div>
	</div>
  
</div>

<style>
/* cahtbox */
.ps-section__container {
	/*margin-top: 50px;*/
}
#msg-text {
	display: block;
    
}
.messages .message.left #msg-text {
	float: left;
	
}
.messages .message.right #msg-text {
	float: right;
	
}
.messages .message.left .time {
	float: left;
}
.messages .message.right .time {
	float: right;
}
.time.tar {
	clear: both;
}
#sidebxwrap {
   display: block;
}
.sidebx {
   border: 2px solid #e1e6ea;
   min-height: 500px;
}
.sidebx ul,
.sidebx ul li {
   float: left;
   width: 100%;
}
.sidebx ul li.active {
   background: #e1e6ea;
}
.sidebx ul,
.sidebx ul li {
   float: left;
   width: 100%;
   list-style: none;
   padding: 0;
}
.sidebx ul li {
   border-bottom: 1px solid #e1e6ea;
}
.sidebx ul li a {
   padding: 10px;
   color: #222;
   font-size: 16px;
   display: block;
}
.chat_window {
   min-height: 500px;
   border-radius: 0;
   border: 2px solid #e1e6ea;
   background-color: #f8f8f8;
   overflow: hidden;
}
.messages {
   min-height: 400px;
   max-height: 408px;
}
.messages {
   position: relative;
   list-style: none;
   padding: 20px 10px 0 10px;
   margin: 0;
   min-height: 408px;
   overflow-y: scroll;
   overflow-x: hidden;
}
.messages .message.appeared {
   opacity: 1;
}
.messages .message.noapp
	{
		display: none !important;
	}
	
.messages .message {
   margin-bottom: 7px;
}
.messages .message {
   clear: both;
   overflow: hidden;
   margin-bottom: 20px;
   transition: all 0.5s linear;
   opacity: 0;
}
.tar {
   text-align: right;
}
.messages .message.right .avatar {
   background-color: #ce643d;
   float: right;
}
.messages .message.left .avatar {
	float: left;
}
.messages .message .avatar {
   width: 50px;
    height: 50px;
    border-radius: 50%;
    display: inline-block;
    background: #e22626;
    padding: 1px;
}
.messages .message.right .text_wrapper {
   /*background-color: #f1f1f1;*/
   margin-right: 20px;
   float: right;
}
.messages .message .text_wrapper {
   padding: 5px 15px;
}
.messages .message .text_wrapper {
   display: inline-block;
   padding: 0 10px;
   border-radius: 6px;
   width: calc(100% - 85px);
   min-width: 100px;
   position: relative;
}
.messages .message.right .text_wrapper .text.tar {
   word-wrap: break-word;
   width: calc(100% - 0px);
}
.messages .message .text_wrapper .text {
   font-size: 14px;
   font-weight: 300;
   text-align: justify;
}
.messages .message.right .text {
   color: #020202;
   text-align: justify;
}
.time {
   font-size: 12px;
    color: gray;
    clear: both;
}
.bottom_wrapper {
   position: relative;
   width: 100%;
   background-color: #e1e6ea;
   padding: 19px 30px;
}
.bottom_wrapper .message_input_wrapper {
   display: inline-block;
   height: 50px;
   border-radius: 0;
   border: 1px solid #bcbdc0;
   position: relative;
   padding: 0 20px;
   background: #fff;
}
.bottom_wrapper .message_input_wrapper .message_input {
   border: none;
   height: 100%;
   box-sizing: border-box;
   width: calc(100% - 40px);
   position: absolute;
   outline-width: 0;
   color: black;
   background: #fff;
}
/*#chatForm .col-md-4 {
   flex: 0 0 31%;
   max-width: 31%;
   width: 31%;
}*/
#chatForm .btn.btn-theme {
   height: 50px;
   width: 100%;
   line-height: 38px;
   float: left;
   border: none;
}
.btn:not(:disabled):not(.disabled) {
   cursor: pointer;
}
.btn.btn-theme {
   height: 44px;
   line-height: 30px;
   color: #ffffff;
}
.bottom_wrapper .send_message {
   width: 90px;
   height: 50px;
   display: inline-block;
   border-radius: 0;
   background-color: #cd1424;
   border: 2px solid #cd1424;
   color: #fff;
   cursor: pointer;
   transition: all 0.2s linear;
   text-align: center;
   float: left;
   margin-right: 5px;
}
.btn.btn-theme {
   background-color: #cd1424;
   border-radius: 0;
   border: none;
   height: 45px;
   width: 150px;
   color: #fff;
   line-height: 36px;
}
.pr_0 {
	padding-right: 0 !important;
}
	
	
	.cmsg_cnt 
	{
		position: relative;
    	float: right;
		background: #e22626;
		color: #fff;
		border-radius: 50%;
		height: 20px;
		width: 20px;
		font-size: 10px;
		line-height: 21px;
		text-align: center;
		font-weight: bold;
	}
	.messages .tal.name {
		display:none;
	}
.messages .message.left #msg-imag{
	text-align: left;
	width: 120px;
	position: relative;
	float: left;
}
.messages .message.left #msg-word,
.messages .message.left #msg-pdf {
	font-size: 18px;
	text-align: left;
	position: relative;
    width: 78px;
    float: left;
}
.messages .message.right #msg-imag{
	text-align: right;
	position: relative;
    width: 120px;
    float: right;
	
	}
.messages .message.right #msg-word,
.messages .message.right #msg-pdf {
	font-size: 18px;
	text-align: right;
	position: relative;
    width: 78px;
    float: right;
}
	
.msg-dwnl {
    position: absolute;
    right: 0;
    font-size: 10px;
    bottom: 0px;
    background: #5f5f5f;
    padding: 5px;
    border-radius: 0 0 5px 5px;
    left: 0;
    color: #ffffff;
    text-align: center;
}
	
/* cahtbox */
</style>

<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>'
	var user_type = 'vendor';
	var module = 'ChatImage';
	    $(document).ready(function () 
	    {  
			var chatIdd= '<?php echo $cId ?>';
			console.log(chatIdd);
			if(chatIdd>0)
			{
				getChatMessages();
			}
	        	
	        $('.chat_window .messages').animate({scrollTop: $('.messages').prop('scrollHeight')}, 200);
	        $('#chatForm').on('submit', function () 
	        {
	            if ($('#msg').val() == '')
	                return false;
	            var message = $('#msg').val();
	            $('#msg').val('');
	            $.ajax({
	                type: "GET",
	                url: "<?php echo base_url('vendor/addChatMessage/') ?>",
	                cache: false,
	                dataType: 'html',
	                data: {chatId: '<?php echo $cId ?>', from: '<?php echo $vendor ?>', message: message},
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
	            url: "<?php echo base_url('vendor/getChatMessage/') ?>",
	            cache: false,
	            dataType: 'html',
	            data: {chatId: '<?php echo $cId ?>', lastId: lastId},
	            success: function (data) 
	            {
	            	//console.log(data);
	                var obj = jQuery.parseJSON(data);
	                $.each(obj, function (key, value) 
	                {
	                    console.log(value);
	                    if (value.msg_from == '<?php echo $vendor ?>') 
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
						
						if(value.msg_type==2)
						{
						   var fleprev='';
						   let ran = Math.random().toString(36).substring(8);
						   var entx=value.message.split('.').pop().toLowerCase();
						   if(entx=='pdf')
						   {
							   fleprev='<span id="msg-pdf"><i class="fa fa-file-pdf-o fa-5x" aria-hidden="true"></i><a  href='+base_url+'uploads/chat_message/'+value.message+' download='+ran+'.'+entx+' class="msg-dwnl"><i class="fa fa-download" aria-hidden="true"></i> Download</a></span>';
						   }
						   else if(entx=='docx')
						   {
							   fleprev='<span id="msg-word"><i class="fa fa-file-word-o fa-5x" aria-hidden="true"></i><a  href='+base_url+'uploads/chat_message/'+value.message+' download='+ran+'.'+entx+' class="msg-dwnl"><i class="fa fa-download" aria-hidden="true"></i> Download</a></span>';
						   }
						   else 
						   {
							   fleprev='<span id="msg-imag"><img src='+base_url+'uploads/chat_message/'+value.message+' /><a class="msg-dwnl" download='+ran+'.'+entx+'  href='+base_url+'uploads/chat_message/'+value.message+' ><i class="fa fa-download" aria-hidden="true"></i> Download</a></span>';
						   }
						  
						   var msgList = '<li id="id-' + value.chat_messages_id + '" class="message noapp ' + side + '"><div class="name ' + ta + '">' + name + '</div>\n\<img class=" avatar img-circle" src="' + avthar + '" title="Avthar" />'
						   +'<div class="text_wrapper">\n\<div class="text ' + ta + '">' + fleprev + '</div><div class="time ' + ta + '">' + value.time + '</div>\n\ </div></li>';
						}
						else
						{
						  var msgtext='<span id="msg-text">'+value.message+'</span>';	
						   var msgList = '<li id="id-' + value.chat_messages_id + '" class="message noapp ' + side + '"><div class="name ' + ta + '">' + name + '</div>\n\<img class=" avatar img-circle" src="' + avthar + '" title="Avthar" /><div class="text_wrapper">\n\<div class="text ' + ta + '">' + msgtext + '</div><div class="time ' + ta + '">' + value.time + '</div>\n\ </div></li>';
						   
						}
						   
	                    
						 if(value.chat_messages_id > lastId)
						   {  
	                    	 $('.messages').append(msgList);
						   }
	                    setTimeout(function () 
	                    {
							$('#id-' + value.chat_messages_id).removeClass('noapp');
	                        $('#id-' + value.chat_messages_id).addClass('appeared');
	                    }, 175);
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
</script>
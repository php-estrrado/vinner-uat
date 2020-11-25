
<div>
    <?php
        echo form_open(base_url() . 'home/ChatFile/do_add/'.$chat_id, array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'chat_file_form',
            'enctype' => 'multipart/form-data'
        ));
        ?>

        <div class="panel-body">
            
			<div class="form-group">
                
            </div>
            <div class="form-group">
                <div class="col-sm-12 nopad input-filebx">
                    <div id='wrap' class="file-thump" >
                        
                    </div>
					<span class="upload-btn-wrapper ">
						  <span class="btn btn-default btn-file"><?php echo translate('select_file');?></span>
						  <input type="file" name="img" id='imgInp' class='required' />
					</span>
					
                    <span id='file-valid' style="color:red">
                    </span>
                    
                </div>
            </div>
            <div class="form-group img-upload" >
				
                <button id='btn-flieup' type='submit' class="btn btn-info" >Upload</button>
				
            </div>
        </div>
           <?php 
        echo form_close();
    ?>
</div>

<script type="text/javascript">

    $(document).ready(function() 
    {
        $("#chat_file_form").submit(function(e)
        {
            var validf='ok';
            var here = $(this);
            var form = here.closest('form');
            var formdata = false;
            if (window.FormData)
            {
                formdata = new FormData(form[0]);
            }
            if($("#imgInp").val())
            {
                $.ajax(
                {
                    url: form.attr('action'), 
                    type: 'POST', 
                    dataType: 'html',
                    data: formdata ? formdata : form.serialize(), 
                    cache       : false,
                    contentType : false,
                    processData : false,
                    beforeSend: function() 
                    {
                        $("#btn-flieup").html('<i class="fa fa-spinner fa-spin"></i>');
                    },
                    success: function(data) 
                    {
                        console.log(data);
                        getChatMessages();
                         $("#file-up-modal").modal('hide');
                    },
                    error: function(e) {
                        console.log(e)
                    }
                });

            }
            else
            {
                $('#file-valid').html("Please select any file.");
            }
            return false;
        });
    });

    $("#imgInp").change(function() 
    {
       $('#file-valid').html("");
       if (this.files && this.files[0]) 
       {
            var fileExtension = ['jpeg','png','jpg','pdf','docx'];
            var entx=$(this).val().split('.').pop().toLowerCase();
            if ($.inArray(entx, fileExtension) == -1)
            {
                $('#wrap').html('');
                $('#file-valid').html("Formats allowed :"+fileExtension.join(','));
                $(this).val("");
            }
            else
            {
                $('#file-valid').html("");
                $('#wrap').html('');
                var fileExte2 =['pdf','docx'];
                if($.inArray(entx,fileExte2)==-1)
                {
                    var reader = new FileReader();
                    reader.onload = function(e) 
                    {
                        $('#wrap').html('<img src="" width="50%" id="img-prev" > ');
                        $('#img-prev').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
                else if(entx=='pdf')
                {
                    $('#wrap').html('<span id="file-prev"><i class="fa fa-file-pdf-o fa-5x" aria-hidden="true"></i></span><span id="file-prev-name">'+this.files[0].name+'</span>');
                }
                else
                {
                    $('#wrap').html('<span id="file-prev"><i class="fa fa-file-word-o fa-5x" aria-hidden="true"></i></span><span id="file-prev-name">'+this.files[0].name+'</span>');
                }
                
            }
       }
    });
    
</script>
<style>
 .upload-btn-wrapper {
	  position: relative;
	  overflow: hidden;
	  display: inline-block;
}
 .upload-btn-wrapper input[type=file] {
	  font-size: 100px;
	  position: absolute;
	  left: 0;
	  top: 0;
	  opacity: 0;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: 0;
    background: white;
    cursor: pointer;
    display: block;
}
.img-upload .btn.btn-info {
    width: 140px;
	color: #fff;
    background: #07af4a;
    border: 1px solid #07af4a;
}
.img-upload {
    text-align: center;
}
#image_add .col-sm-12.nopad {
    text-align: center;
}
.file-thump {
    margin-bottom: 10px;
}
	.btn-default {
    background-color: #fff;
    border-color: #c3cedb;
    color: #404040;
}
.btn-file {
    position: relative;
    overflow: hidden;
}
.btn {
    cursor: pointer;
    background-color: transparent;
    color: inherit;
    padding: 6px 12px;
    border-radius: 2px;
    border: 1px solid 2px;
    font-size: 12px;
    line-height: 1.42857;
    vertical-align: middle;
    -webkit-transition: all .15s;
    transition: all .15s;
}
.btn-default {
    color: #333;
    background-color: #fff;
    border-color: #ccc;
}
.btn {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border-radius: 4px;
}
.input-filebx {
	text-align:center;
}
.modal-header .close {
	font-size: 22px;
}
#file-prev,
#file-prev-name,
#file-valid {
	display:block;
}
.time.tal {
	float: right;
    clear: both;
}
.messages .message .avatar {
	float: right;
}
	#img-prev
	{
		height: 180px;
    	width: 180px;
	}
</style>

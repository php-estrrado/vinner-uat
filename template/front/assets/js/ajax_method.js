
	function wish_js(button)
	{  
		return false;
	}

	function mysql_real_escape_string (str) 
 	{

        return str.replace(/[\0\x08\x09\x1a\n\r"'\\\%]/g, function (char) {

            switch (char) {

                case "\0":

                    return "\\0";

                case "\x08":

                    return "\\b";

                case "\x09":

                    return "\\t";

                case "\x1a":

                    return "\\z";

                case "\n":

                    return "\\n";

                case "\r":

                    return "\\r";

                case "\"":

                case "'":

                case "\\":

                case "%":

                    return "\\"+char;
              }
          });
    }



	// if (typeof other_action == 'function') 
	// { 

	//   function other_action()
	//   {

	//   }

	// }

	

	$.ajaxPrefilter('script', function(options) { 

		options.cache = true; 

	});



	

    /*
    $(document).ready(function() 
    {

        $(".various").fancybox({

            maxWidth    : 800,

            maxHeight   : 600,

            fitToView   : false,

            width       : '70%',

            height      : '70%',

            autoSize    : false,

            closeClick  : false,

            openEffect  : 'none',

            closeEffect : 'none'

        });

    });
	*/
    

	$('#quick_view').modal({
        show: false,
        remote: ''
	});

	

	$(".product_quick").on('click', function () 
	{
			var link = $(this).data("href");
			$('#quick_view').removeData('bs.modal');
			$('#quick_view').modal({remote: link });
			$('#quick_view').modal('show');
	});

	

	function ajax_load(url,id)
	{

		var list = $('#'+id);

		$.ajax({

			url: url,

			beforeSend: function() {
				list.html('...'); // change submit button text
			},

			success: function(data) {
				list.html('');
				list.html(data).fadeIn();
				//other_action();
			},
			error: function(e) 
			{
				console.log(e)
			}

		});
	}

  	

	function notify(message,type,from,align)
	{		
		$.notify({
			// options
			message: message 
		},{

			// settings
			type: type,
			placement: 
			{
				from: from,
				align: align
		  	}
		});
	}

		



    $('body').on('click', '.add_to_cart', function()
    {        

        var product = $(this).data('pid');
        var elm_type = $(this).data('type');
        var button = $(this);
		var alread = button.html();
		var type = 'pp';

        if(button.closest('.margin-bottom-40').find('.cart_quantity').length)
        {
            quantity = button.closest('.margin-bottom-40').find('.cart_quantity').val();
        }
	
        if($('#pnopoi').length)
        {
        	type = 'pp';
            var form = button.closest('form');
			var formdata = false;
			if (window.FormData)
			{
				formdata = new FormData(form[0]);
			}
            var option = formdata ? formdata : form.serialize();
        } 

        else if ($('#pnopo').length) 
        {
        	type = 'other';
            var form = button.closest('form');
			var formdata = false;
			if (window.FormData)
			{
				formdata = new FormData(form[0]);
			}
            var option = formdata ? formdata : form.serialize();
        }
        else 
        {
        	type = 'other';
        	var form = $('#cart_form_singl');
			var formdata = false;
			if (window.FormData)
			{
				formdata = new FormData(form[0]);
			}
        	var option = formdata ? formdata : form.serialize();
        }

        $.ajax({

            url 		: base_url+'home/cart/add/'+product+'/'+type,
			type 		: 'POST', 
			dataType 	: 'html', 
			data 		: option, 
			cache       : false,
			contentType : false,
			processData : false,
            beforeSend: function() 
            {
				if(elm_type !== 'icon')
				{
                	button.html(cart_adding); 
				}
            },
            success: function(data) 
            {
                //console.log(data);
                if(data == 'added' || data == 'update' )
                {
					$('.add_to_cart').each(function(index, element) 
					{
						if( $('body .add_to_cart').length )
						{
							$('body .add_to_cart').each(function() 
							{
								if($(this).data('pid') == product)
								{
									var h = $(this);
									if(h.data('type') == 'text')
									{
										h.html(added_to_cart).fadeIn();
									} 
									else if(h.data('type') == 'icon')
									{
										h.html('<i style="color:#e85559" class="fa fa-shopping-cart"></i>').fadeIn();
									}
									else if( h.data('type')=='button')
									{
									    h.html('Added To Cart ').fadeIn();
									}
								}
							});
						}
                    });

					if(!button.hasClass("crt-black")) 
					{
						button.addClass("crt-black");
					}
                    ajax_load(base_url+'home/cart/added_list/','added_list');
					ajax_load(base_url+'home/cart/added_list_mobile/','mobile_added_list');
                    $('#pnval').val("1");				
					if(data == 'update')
					{
						notify(product_update,'success','bottom','right');
						$('#pnopoi').attr('id', 'pnopo');
					}
					else
					{
				    	notify(product_added,'success','bottom','right');
					}					
					//sound('successful_cart');
                } 
                else if (data == 'shortage')
                {
                    button.html(alread);
					notify(quantity_exceeds,'warning','bottom','right');
					//sound('cart_shortage');
                } 
                else if (data == 'already')
                {
                    if(elm_type == 'text')
					{
						button.html(added_to_cart).fadeIn();				
					} 
					else if(elm_type == 'icon')
					{
						button.html('<i style="color:#e85559" class="fa fa-shopping-cart"></i>').fadeIn();					
					}
					else if(elm_type=='button')
					{
						button.html('Added To Cart').fadeIn();
					}
					else
					{
					    button.html(alread);
					}
					
					if(!button.hasClass("alr-wrnd")) 
					{
						notify(product_already,'warning','bottom','right');
						button.addClass("alr-wrnd");
					}
					
					
					
					//sound('already_cart');
                }
            },

            error: function(e) {

                console.log(e)

            }

        });

    });

 

    $('body').on('click', '.buy_now', function()
    {        

        var product = $(this).data('pid');
        var elm_type = $(this).data('type');
        var button = $(this);
		var alread = button.html();
		var type = 'pp';
        if(button.closest('.margin-bottom-40').find('.cart_quantity').length)
		{
            quantity = button.closest('.margin-bottom-40').find('.cart_quantity').val();
        }
        if($('#pnopoi').length)
		{
        	type = 'pp';
            var form = button.closest('form');
			var formdata = false;
			if (window.FormData){
				formdata = new FormData(form[0]);
			}
            var option = formdata ? formdata : form.serialize();
        } 
		else if ($('#pnopo').length) 
        {
        	type = 'other';
            var form = button.closest('form');
			var formdata = false;
			if (window.FormData)
			{
				formdata = new FormData(form[0]);
			}
            var option = formdata ? formdata : form.serialize();
        }
		else 
		{
        	type = 'other';
        	var form = $('#cart_form_singl');
			var formdata = false;
			if (window.FormData)
			{
				formdata = new FormData(form[0]);
			}
        	var option = formdata ? formdata : form.serialize();
        }

        $.ajax({
            url 		: base_url+'home/cart/add/'+product+'/'+type,
			type 		: 'POST', 
			dataType 	: 'html', 
			data 		: option, 
			cache       : false,
			contentType : false,
			processData : false,
            beforeSend: function() 
			{
				/*if(elm_type !== 'icon'){
                	button.html(cart_adding); 
				}*/
            },
            success: function(data) 
			{
                if(data == 'added')
				{
					$('.add_to_cart').each(function(index, element) 
					{
						if( $('body .add_to_cart').length )
						{
							$('body .add_to_cart').each(function() 
							{
								if($(this).data('pid') == product)
								{
									var h = $(this);
									if(h.data('type') == 'text')
									{
										h.html(added_to_cart).fadeIn();				

									} else if(h.data('type') == 'icon')
									{
										h.html('<i style="color:#e85559" class="fa fa-shopping-cart"></i>').fadeIn();
									}
								}
							});
						}
                    });
					if (button.hasClass("btn_cart")) 
					{
						button.removeClass("btn_cart");
						button.addClass("btn_carted");
					}
					//growl
                    window.location.replace(base_url+'home/cart_checkout');
                } 
				else if (data == 'shortage')
				{
                    button.html(alread);
					notify(quantity_exceeds,'warning','bottom','right');
					//sound('cart_shortage');
                } 
				else if (data == 'already' || data == 'update')
				{
                    //button.html(alread);
					//notify(product_already,'warning','bottom','right');
					window.location.replace(base_url+'home/cart_checkout');
                }
            },
            error: function(e) 
			{
                console.log(e)
            }
        });
    });

  
    $('body').on('click', '.wish_it', function()
    {

        var state = check_login_stat('state');

		var product = $(this).data('pid');

		var button = $(this);

		

        state.success(function (data) {

            if(data == 'hypass'){

				$.ajax({

					url: base_url+'index.php/home/wishlist/add/'+product,

					beforeSend: function() {

					},

					success: function(data) {

						button.removeClass("wish_it");

						button.addClass("wished_it");

						var wished = check_login_stat('wished');
						wished.success(function (data2)
						  {
							  if(data2>0)
							  {
								  $(".count_wished").html(data2);
							  }
						  });
						
						button.closest('ul').data('originalTitle',wishlist_add1);

						notify(wishlist_add,'info','bottom','right');

						//sound('successful_wish');

					},

					error: function(e) {

						console.log(e)

					}

				});

            } else {

				signin();

			}

        });

    });

	

    $('body').on('click', '.btn_wish', function()
    {
        var state = check_login_stat('state');
		var product = $(this).data('pid');
		var button = $(this);
        state.success(function (data) 
		 {
            if(data == 'hypass')
			{
				$.ajax({
					url: base_url+'home/wishlist/add/'+product,
					beforeSend: function() 
					{
						//button.html(wishlist_adding); // change submit button text
					},
					success: function(data) 
					{
						$('body .btn_wish').each(function() 
							{
								if($(this).data('pid') == product)
								{
									$(this).removeClass("btn_wish");
									$(this).addClass("btn_wished");
									$(this).tooltip('dispose');
									$(this).attr('title', 'Remove from Wishlist')
									$(this).tooltip();
								}
							});
						var wished = check_login_stat('wished');
						wished.success(function (data2)
						  {
							  if(data2>0)
							  {
								  $(".count_wished").html(data2);
							  }
						  });
						notify(wishlist_add,'info','bottom','right');
						//sound('successful_wish');
					},
					error: function(e) {
						console.log(e)
					}
				});

            } 
			else 
			{
            	//$('.fancybox-close').click();
				signin();
			}
        });

    });


    $('body').on('click', '.btn_wished', function()
    {
		
		var state = check_login_stat('state');
		var product = $(this).data('pid');
		var button = $(this);
		
		state.success(function (data) 
		{
	        if(data == 'hypass')
	        {
				$.ajax(
				{
					url: base_url+'index.php/home/wishlist/remove/'+product,
					beforeSend: function() {
						//button.html(wishlist_rmvng);
					},
					success: function(data) 
					{
						$('body .btn_wished').each(function() 
							{
								if($(this).data('pid') == product)
								{
									$(this).removeClass("btn_wished");
									$(this).addClass("btn_wish");
									$(this).tooltip('dispose');
									$(this).attr('title', 'Add to Wishlist')
									$(this).tooltip();
								}
							});
						
						var wished = check_login_stat('wished');
						wished.success(function (data2)
						  {
							  if(data2>0)
							  {
								  $(".count_wished").html(data2);
							  }
							  else
							  {
								  $(".count_wished").html('0');
							  }
						  });
						notify(wishlist_remove,'info','bottom','right');
					},
					error: function(e) {
						console.log(e)
					}
				});
	   		} 
	   		else 
	   		{
			 signin();
			}
        });
    });



    $('body').on('click', '.remove_from_wish', function()
    {
		var product = $(this).data('pid');
		var button = $(this);
		$.ajax({
			url: base_url+'index.php/home/wishlist/remove/'+product,
			beforeSend: function() {
				button.parent().parent().hide('fast');
			},

			success: function(data) 
			{
						//$(".count_wished").html('0');
						var wished = check_login_stat('wished');
						wished.success(function (data2)
						  {
							  if(data2>0)
							  {
								  $(".count_wished").html(data2);
							  }
							  else
							  {
								  $(".count_wished").html('0');
							  }
						  });
				button.tooltip('dispose');
				button.parent().parent().remove();
				notify(wishlist_remove,'info','bottom','right');
			},
			error: function(e) {
				console.log(e)
			}
		});
    });

  

    /*Reviews Code start*/

    $('body').on('click', '.sub_btn', function()
    {

        var state = check_login_stat('state');

		var product = $('.rate_it').closest('.stars-ratings').data('pid');

		/*var rating = $('.rate_it').data('rate');*/

		var button = $('.rate_it');

        var myRadio = $('input[name=rating]');

        var rating = myRadio.filter(':checked').val();

        var title = $('#rev_tit').val();

        var review = $('textarea#review').val();

		   /* alert(escape("mike's"));

		alert(unescape(escape("mike's")));*/

        review=escape(review);

    	review=review.slice(0, -1);

       	/* var dataString = 'product='+ product + '&rating='+ rating + '&title='+ title + '&review='+ review;*/   

        var dataString =product +"/"+ rating + "/"+ title +"/"+ review;   

        console.log(dataString);

        state.success(function (data) {

            if(data == 'hypass'){

				$.ajax({

                   

					url: base_url+'index.php/home/review/'+dataString,



					beforeSend: function() {

					},

					success: function(data) {

						if(data == 'success'){

							notify(rated_success,'info','bottom','right');

						} else if(data == 'failure'){

							notify(rated_fail,'alert','bottom','right');

						} else if(data == 'already'){

							notify(rated_already,'info','bottom','right');

						}

                        else{

                            notify(data,'info','bottom','right');

                        }

					},

					error: function(e) {

						console.log(e)

					}

				});

            } else {

				signin();

			}

        });

    });

	

	$("body").on('click','.login_btn',function()
	{
        var here = $(this); 
        var text = here.html(); 
        var form = here.closest('form');
        var formdata = false;

        if (window.FormData)
        {
            formdata = new FormData(form[0]);
        }

        $.ajax({
            url: form.attr('action'), 
            type: 'POST', 
            dataType: 'html', 
            data: formdata ? formdata : form.serialize(),  
            cache       : false,
            contentType : false,
            processData : false,
            beforeSend: function() 
            {
				here.addClass('disabled');
                here.html(logging); 
            },
            success: function(data) 
            {
            	//alert(data);
                here.fadeIn();
                here.html(text);
				here.removeClass('disabled');
				if(data == 'done')
				{
					notify(login_success,'info','bottom','right');
					here.closest('.modal-content').find('#close_log_modal').click();
					set_loggers();
					//sound('successful_login');
					// var pp= $('#emap').val();
					// if (pp=='welcome') 
					// {
					// 	window.location.replace(base_url);
					// 	pp=0;
					// }
					// var kk= $('#tracklog').val();
					// if (kk=='tracklog') 
					// {
					// 	window.location.reload();
					// 	kk=0;
					// }
				} 
				else if(data == 'failed')
				{
					//here.closest('.modal-content').find('#close_log_modal').click();
					$("#fail").show();
					//notify(login_fail,'warning','bottom','right');
					//sound('unsuccessful_login');
				} 
				else 
				{
					notify(data,'warning','bottom','right');
				}
            },
            error: function(e) 
            {
                console.log(e)
            }
        });
    });

	
    $('body').on('change','input.phone',function(){ var id = this.id; var val = this.value.replace(/[^0-9\+]/g,''); $('#'+id).val(val);});
	

    $('body').on('click','.logup_btn', function()
    {
        var here = $(this); // alert div for show alert message
        var form = here.closest('form');
        var can = '';
		var ing = here.data('ing');
		var msg = here.data('msg');
		var prv = here.html();
		form.find('.summernotes').each(function() {
            var now = $(this);
            now.closest('div').find('.val').val(now.code());

        });

        var formdata = false;
        if (window.FormData)
		{
            formdata = new FormData(form[0]);
        }
        var a = 0;
        var take = '';
        form.find(".required").each(function()
        {
       		var txt = '* '+required;
            a++;
            if(a == 1)
            {
                take = 'scroll';
            }

            var here = $(this);

            if(here.val() == '')
            {
                if(!here.is('select'))
                {
                    here.css({borderColor: 'red'});

                    if(here.attr('type') == 'number')
					{
                        txt = '* '+mbn;
                    }
                    if(here.closest('.input').find('.require_alert').length)
                    {
						here.closest('.input').find('.require_alert').html(txt);
                    } 
                    else 
                    {
                        //sound('form_submit_problem');
                        here.closest('.input').append(''
                            +'  <span id="'+take+'" class="require_alert" >'
                            +'      '+txt
                            +'  </span>'
                        );
                    }
                } 
                else if(here.is('select'))
                {
                    here.closest('div').find('.chosen-single').css({borderColor: 'red'});
                    if(here.closest('.input').find('.require_alert').length)
					{
						here.closest('.input').find('.require_alert').html(txt);
                    } 
                    else 
                    {
                        //sound('form_submit_problem');
                        here.closest('.input').append(''
                            +'  <span id="'+take+'" class="require_alert" >'
                            +'      '+txt
                            +'  </span>'
                        );
                    }
                }
                var topp = 100;
                // $('html, body').animate({
                //     scrollTop: $("#scroll").offset().top - topp
                // }, 500);

                can = 'no';
            }
			if (here.attr('type') == 'email' && here.val() != '')
			{
				if(!isValidEmailAddress(here.val()))
				{
					here.css({borderColor: 'red'});
					if(here.closest('.input').find('.require_alert').length)
					{
						here.closest('.input').find('.require_alert').html(mbe);
					} 
					else 
					{
						//sound('form_submit_problem');
						here.closest('.input').append(''
                            +'  <span id="'+take+'" class="require_alert" >'

                            +'      '+mbe
                            +'  </span>'
						);
					}
					can = 'no';
				}
			}
			if (here.attr('id') == 'mobile' && here.val() != '')
			{
				var phone = here.val();
				var phoneno = "/^[0-9]{9,11}$/";
				if(phone.match(phoneno))
				{
				} 
				else 
				{
					here.css({borderColor: 'red'});
					if(here.closest('.input').find('.require_alert').length)
					{
						here.closest('.input').find('.require_alert').html('* Enter valid mobile Number');
					} 
					else 
					{
						here.closest('.input').append(''
                            +'  <span id="'+take+'" class="require_alert" >'
                            +'     * Enter valid mobile Number'
                            +'  </span>'
						);
					}
				}
			}
			
			
			if (here.attr('id') == 'zip' && here.val() != '')
			{
				var zip= here.val();
        		var zip_code =/([0-9])$/;
        		if(zip.match(zip_code))
				{
				} 
				else 
				{
					here.css({borderColor: 'red'});
					if(here.closest('.input').find('.require_alert').length)
					{
						here.closest('.input').find('.require_alert').html('* Enter valid Zip code(00000)');
					} 
					else 
					{
						here.closest('.input').append(''
                            +'  <span id="'+take+'" class="require_alert" >'
                            +'     * Enter valid Zip code(00000)'
                            +'  </span>'
						);
					}
				}
			}
	        if (here.attr('id') == 'password1'){
                if($('#password1').val() != $('#password2').val()){ $('#pass_error').text('Confirm Password not match with password'); can = 'no'; }
                else{ $('#pass_error').text(''); }
            }

            take = '';
        });
        

        if($("#logup_form #mDisabled").val() == 1 || $("#logup_form #eDisabled").val() == 1){ can = 'no'; }
        if($(this).prop('disabled') == true){ can = 'no'; }else{  }

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
                success: function(data) 
                {

                    here.fadeIn();
                    here.html(prv);
                	if(data == 'done')
                	{
						here.closest('.modal-content').find('#close_logup_modal').click();
                		notify(logup_success,'success','bottom','right'); 
						//sound('successful_logup');  		
                	} 
                	else 
                	{
						here.closest('.modal-content').find('#close_logup_modal').click();
                		notify(logup_fail+'<br>'+data,'warning','bottom','right');
						//sound('unsuccessful_logup');
                	}
                },
                error: function(e) 
                {
                    console.log(e)
                }
            });
        }
        else 
        {
            //sound('form_submit_problem');
            return false;
        }
    });

    

	function isValidEmailAddress(emailAddress) 
	{

		var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);

		return pattern.test(emailAddress);

	};	

		

	$("body").on('change','.required',function()
	{

		var here = $(this);

		here.css({borderColor: '#931ECD'});

		if (here.attr('type') == 'email'){

			if(isValidEmailAddress(here.val())){

				here.closest('.input').find('.require_alert').remove();

			}

		} else {

			here.closest('.input').find('.require_alert').remove();

		}

		if(here.is('select')){

			here.closest('.input').find('.chosen-single').css({borderColor: '#dcdcdc'});

		}

	});



	$("body").on('click','.forget_btn',function()
	{

        var here = $(this); // alert div for show alert message

        var text = here.html(); // alert div for show alert message

        var form = here.closest('form');

        //var form = $(this);

        var formdata = false;

        if (window.FormData){

            formdata = new FormData(form[0]);

        }

        $.ajax({

            url: form.attr('action'), // form action url

            type: 'POST', // form submit method get/post

            dataType: 'html', // request type html/json/xml

            data: formdata ? formdata : form.serialize(), // serialize form data 

            cache       : false,

            contentType : false,

            processData : false,

            beforeSend: function() {

				here.addClass('disabled');

                here.html(submitting); // change submit button text

            },

            success: function(data) {

                here.fadeIn();

                here.html(text);

				here.removeClass('disabled');

				if(data == 'email_sent'){

					notify("Check your email for new password !",'info','bottom','right');

					here.closest('.modal-content').find('#close_log_modal').click();

				} else if(data == 'email_nay'){

					here.closest('.modal-content').find('#close_log_modal').click();

					notify(email_noex,'info','bottom','right');

				} else if(data == 'email_not_sent'){

					here.closest('.modal-content').find('#close_log_modal').click();

					notify(email_fail,'info','bottom','right');

				} else {

					notify(data,'warning','bottom','right');

				}

            },

            error: function(e) {

                console.log(e)

            }

        });

    });

	
	 $('body').on('click', '.btn_compare', function()
     {
		var product = $(this).data('pid');
		var button = $(this);
		$.ajax({
			url: base_url+'home/compare/add/'+product,
			beforeSend: function() 
			{
				button.addClass('fa fa-spin fa-fw');	
			},
			success: function(data) 
			{
				console.log(data);
				if(data == 'cat_full')
				{
					notify('Compare list is full, please remove a product or reset the compare list','warning','bottom','right');
					button.removeClass("fa fa-spin fa-fw");
				} 
				else 
				{
					$('#compare_num').load(base_url+'home/compare/num/');
					$('body .btn_compare').each(function() 
						{
							if($(this).data('pid') == product)
							{
								//console.log($(this).data('pid'));
								$(this).removeClass("fa fa-spin fa-fw");
								$(this).removeClass("btn_compare");
								$(this).addClass("btn_compared");
								$(this).tooltip('dispose');
								$(this).attr('title', 'Remove from Compare')
								$(this).tooltip();
							}
						});
					if (data == 'already')
					{
						notify(compare_already,'warning','bottom','right');
					} 
					else
					{
						notify(compare_add,'info','bottom','right');
					}
					
				}

			},
			error: function(e) 
			{
				console.log(e)
			}

		});

    });



    $('body').on('click', '.btn_compared', function()
    {
		var product = $(this).data('pid');
		var button = $(this);
		$.ajax({

			url: base_url+'home/compare/remove/'+product,
			beforeSend: function() 
			{
				button.addClass('fa fa-spin fa-fw');
			},
			success: function(data) 
			{
				console.log(data);
				$('#compare_num').load(base_url+'home/compare/num/');
				$('body .btn_compared').each(function() 
				{
					if($(this).data('pid') == product)
					{
						//console.log($(this).data('pid'));
						$(this).removeClass("fa fa-spin fa-fw");
						$(this).removeClass("btn_compared");
						$(this).addClass("btn_compare");
						$(this).tooltip('dispose');
						$(this).attr('title', 'Compare')
						$(this).tooltip();
					}
				});
				notify(compare_remove,'info','bottom','right');
			},
			error: function(e) 
			{
				console.log(e)
			}

		});

    });


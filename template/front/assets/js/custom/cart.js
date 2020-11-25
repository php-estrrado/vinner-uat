					$('.coupon_btn').on('click',function()
                    {
                        var txt = $(this).html();
                        var code = $('.coupon_code').val();
                        $('#coup_frm').val(code);
                        var form = $('#coupon_set');
                        var formdata = false;
                        if (window.FormData){
                            formdata = new FormData(form[0]);
                        }
                        var datas = formdata ? formdata : form.serialize();
                        $.ajax({
                                url: base_url+'home/coupon_check/',
                                type        : 'POST', 
                                dataType    : 'html', 
                                data        : datas, 
                                cache       : false,
                                contentType : false,
                                processData : false,
                                beforeSend: function() 
                                {
                                    $(this).html("applying..");
                                },
                                success: function(result)
                                {
                                    //console.log(result);
                                    if(result == 'nope')
                                    {
                                        notify("Coupon not valid",'warning','bottom','right');
                                    } 
                                    else 
                                    {
                                        var re = result.split(':-:-:');
                                        var ty = re[0];
                                        var ts = re[1];
                                        $("#coupon_report").fadeOut();
                                        notify('Coupon discount added successfully','success','bottom','right');
                                        if(ty == 'total')
                                        {
                                            $("#disco").html(re[2]);
                                        }
                                        $("#disco").html(re[2]);
										$(".frm-coup").addClass('copna-hide');
										$(".alert-coup").removeClass('copna-hide');
                                        //$("#coupon_report").html('<h3>'+ts+'</h3>');
                                        $("#coupon_report").fadeIn();
                                        update_calc_cart();
                                        update_prices();
                                    }
                                }
                        });
                    });		

					function clearcoupon()
                    {
						$("#disco").html('0');
						$('.coupon_code').val('');
                        $('#coup_frm').val('');
						$(".frm-coup").removeClass('copna-hide');
						$(".alert-coup").addClass('copna-hide');
						$('#shipping_operator').val('');
                        $('.shipping_msg').html('');
					}
					
					function clearShip()
                    {
                        $.ajax(
                        {
                            //type: "POST",
                            url: base_url+"home/clear_ship_cost/", 
                            dataType:"html",
                            cache       : false,
                            contentType : false,
                            success: function()
                            {
                                update_prices();
                                update_calc_cart();
                            }
                        });
                    }

					

                    $('.colrs').on('click', function()
                    {
                        var here = $(this);
                        var rowid = here.closest('tr').data('rowid');
                        var val = here.closest('li').find('input').val();
                        if(val == 'undefined'){
                            val = '';
                        }
                        val = val.split(",").join("-");
                        val = val.replace(')','--');
                        val = val.replace('(','---');

                        $.ajax({
                            url: base_url+'home/cart/upd_color/'+rowid+'/'+val,
                            beforeSend: function() {
                            },
                            success: function() {
                                //other option
                                ajax_load(base_url+'index.php/home/cart/added_list/','added_list');
                            },
                            error: function(e) {
                                console.log(e)
                            }
                        });
                    });

                    function others_count()
                    {
						update_prices();
                        update_calc_cart();
                    }
                    
                    $('.close').on('click', function()
					{
                        var here = $(this);
						console.log(here.data('rowid'));
                        var rowid = here.data('rowid');
                        var thetr = here.closest('tr');
                        var list1 = $('#total');
						console.log(rowid);
                        $.ajax({
                            url: base_url+'home/cart/remove_one/'+rowid,
                            beforeSend: function() {
                                list1.html('...');
                            },
                            success: function(data) 
							{
								//console.log(data);
                                list1.html(data).fadeIn();
                                ajax_load(base_url+'home/cart/added_list/','added_list');
                                notify(cart_product_removed,'success','bottom','right');
								clearcoupon();
                                others_count();
                                //thetr.hide('fast');
								$("#wb-pr-tr-"+rowid).hide('fast');
								$("#mb-pr-div-"+rowid).hide('fast');
                            },
                            error: function(e) {
                                console.log(e)
                            }
                        });
                    });

                    function check_ok(element)
					{
                        var here = $(element);
                        here.closest('td').find('.minus').click();
                        here.closest('td').find('.plus').click();
                    }

                    $('.quantity-button').on('click', function()
					{
                        var here = $(this);
                        var quantity = here.closest('div.form-group--number').find('input').val();
                        var limit = here.closest('div.form-group--number').find('input').data('limit');
						console.log(limit);
                        if(here.val()=='minus')
						{
                            quantity = quantity-1;
                        } 
						else if (here.val()=='plus')
						{
                             quantity = Number(quantity)+1;
                        }
                        if(quantity >= 1)
						{
                           
                            var rowid = here.data('rowid');
							var list1 = $("#wb-pr-tr-"+rowid).find('.sub_total');
							$("#wb-qvalue-"+rowid).val(quantity);
							$("#mb-qvalue-"+rowid).val(quantity);
							
                            $.ajax({
                                url: base_url+'home/cart/quantity_update/'+rowid+'/'+quantity,
                                beforeSend: function() {
                                    list1.html('...'); 
                                },
                                success: function(data) 
								{
                                    var res = data.split("---")
                                    list1.html(res[0]).fadeIn();
                                    ajax_load(base_url+'home/cart/added_list/','added_list');
                                    if(res[1] !== 'not_limit')
									{
										notify('Product exceeded than stock limit','warning','bottom','right');
                                        here.closest('td').find('input').data('limit','yes');
										$("#wb-qvalue-"+rowid).val(res[1]);
										$("#mb-qvalue-"+rowid).val(res[1]);
                                        //here.closest('td').find('input').val(res[1]);
                                    } 
									else 
									{
										clearcoupon();
                                        here.closest('td').find('input').data('limit','no');
                                    }
									
                                    others_count();
                                },
                                error: function(e) {
                                    console.log(e)
                                }
                            });
                        }
                    });

                    function cart_submission()
                    {
                        //var payment_type = $('#ab').val();
                        var payment_type = '';
                        var state = check_login_stat('state');
                        state.success(function (data) 
						{
                            if(data == 'hypass'){
                                 var form = $('#cart_form');
                                 form.submit();
                            } else {
                                $('#loginss').click();
                                $('#login_form').attr('action',base_url+'index.php/home/login/do_login/nlog');
                                $('#logup_form').attr('action',base_url+'index.php/home/registration/add_info/nlog');
                            }
                        });
                    }

                    $(document).ready(function() 
					{
                        $('.colrs').each(function() 
						{
                            var here = $(this);
                            var rad = here.closest('li').find('input');
                            if(rad.is(':checked')) {
                                setTimeout( function(){ 
                                    here.click();
                                }
                                , 800 );
                            }
                        });
                        $(".numbers-only").keydown(function (e) 
						{
                            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || (e.keyCode >= 35 && e.keyCode <= 40)) { return; }
                            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) { e.preventDefault(); }
                        });
						//clearShip();
						others_count();
                    });

                    function update_prices()
					{
                        var url = base_url+'home/cart/calcs/prices';
                        $.ajax({
                            url: url,
                            dataType: 'json', 
                            beforeSend: function() {

                            },
                            success: function(data) {
                                $.each(data, function(key, item) {
                                    var elem = $("table").find("[data-rowid='" + item.id + "']");
                                    elem.find('.sub_total').html(item.subtotal);
                                    elem.find('.pric').html(item.price);
                                });
                            },
                            error: function(e) {
                                console.log(e)
                            }
                        });
                    }

                    function update_calc_cart()
                    {
                        var url = base_url+'home/cart/calcs/full';
                        var total = $('#total');
                        var ship = $('#shipping');
                        var tax = $('#tax');
                        var grand = $('#grand');
                        //var rvat = $('#rvat');
                        $.ajax({
                            url: url,
                            beforeSend: function() {
                                total.html('...'); 
                                ship.html('...'); 
                                tax.html('...'); 
                                grand.html('...');
                                //rvat.html('...');
                            },
                            success: function(data) {
                                var res = data.split('-');
                                total.html(res[0]).fadeIn(); 
                                ship.html(res[1]).fadeIn(); 
                                tax.html(res[2]).fadeIn(); 
                                grand.html(res[3]).fadeIn();
                                //rvat.html(res[5]).fadeIn();
                                //other_action();
                            },
                            error: function(e) {
                                console.log(e)
                            }
                        });
                    }
                
                    function shippingcalc()
                    {
                        $('.shipping_msg').html('');
                        var opert_id=$('#shipping_operator').val();
                        var url = base_url+'home/shipping_cost/';
                        var ship = $('#shipping');
                        
                        $.get(url+opert_id, function(data, status)
                            {
                                console.log("Data: " + data + "\nStatus: " + status);
                                var rest = data.split('-');
                                if(rest[0]=='1')
                                {
                                    $('.shipping_msg').html('<span style="color:green">'+rest[2]+'</span>');
                                    update_calc_cart();
                                }
                                else
                                {
                                    $('.shipping_msg').html('<span style="color:red">'+rest[1]+'</span>');
                                    update_calc_cart();
                                }
                                
                            });
                        
                    }
                
                
                    function set_cart_map()
                    {
                        //$('#maps').animate({ height: '400px' }, 'easeInOutCubic', function(){});
                        initialize();
                        var address = [];
                        //$('#pos').show('fast');
                        //$('#lnlat').show('fast');
                        $('.address').each(function(index, value){
                            if(this.value !== ''){
                                address.push(this.value);
                            }
                        });
                        address = address.toString();
                        deleteMarkers();
                        geocoder.geocode( { 'address': address}, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                if($('#langlat').val().indexOf(',')  == -1 || $('#first').val() == 'no'){
                                    deleteMarkers();
                                    var location = results[0].geometry.location; 
                                    var marker = addMarker(location);
                                    map.setCenter(location);
                                    $('#langlat').val(location);
                                } else if($('#langlat').val().indexOf(',')  >= 0){
                                    deleteMarkers();
                                    var loca = $('#langlat').val();
                                    loca = loca.split(',');
                                    var lat = loca[0].replace('(','');
                                    var lon = loca[1].replace(')','');
                                    var marker = addMarker(new google.maps.LatLng(lat, lon));
                                    map.setCenter(new google.maps.LatLng(lat, lon));
                                }
                                if($('#first').val() == 'yes'){
                                    $('#first').val('no');
                                }
                                // Add dragging event listeners.
                                google.maps.event.addListener(marker, 'drag', function() {
                                    $('#langlat').val(marker.getPosition());
                                });
                            }
                        }); 
                    }

                    var geocoder;
                    var map;
                    var markers = [];
                    function initialize() 
                    {
                        geocoder = new google.maps.Geocoder();
                        var latlng = new google.maps.LatLng(-34.397, 150.644);
                        var mapOptions = {
                            zoom: 14,
                            center: latlng
                        }
                        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                        google.maps.event.addListener(map, 'click', function(event) {
                            deleteMarkers();
                            var marker = addMarker(event.latLng);
                            $('#langlat').val(event.latLng);    
                            // Add dragging event listeners.
                            google.maps.event.addListener(marker, 'drag', function() {
                                $('#langlat').val(marker.getPosition());
                            });
                            
                        });     
                    }
        
                    $('.address').on('blur', function()
            		{
            			console.log('address');
                        //set_cart_map();
                    });

                    // Add a marker to the map and push to the array.
                    function addMarker(location) 
                   {
                        var image = {
                            url: base_url+'uploads/others/marker.png',
                            size: new google.maps.Size(40, 60),
                            origin: new google.maps.Point(0,0),
                            anchor: new google.maps.Point(20, 62)
                        };

                        var shape = {
                            coords: [1, 5, 15, 62, 62, 62, 15 , 5, 1],
                            type: 'poly'
                        };

                        var marker = new google.maps.Marker({
                            position: location,
                            map: map,
                            draggable:true,
                            icon: image,
                            shape: shape,
                            animation: google.maps.Animation.DROP
                        });
                        markers.push(marker);
                        return marker;
                    }

                    // Deletes all markers in the array by removing references to them.
                    function deleteMarkers() {
                        clearMarkers();
                        markers = [];
                    }

                    // Sets the map on all markers in the array.
                    function setAllMap(map) {
                        for (var i = 0; i < markers.length; i++) {
                            markers[i].setMap(map);
                        }
                    }

                    // Removes the markers from the map, but keeps them in the array.
                    function clearMarkers() {
                        setAllMap(null);
                    }
                    //google.maps.event.addDomListener(window, 'load', initialize);
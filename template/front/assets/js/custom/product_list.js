
    function toggle_subs(cat){
        $("#subs_"+cat).toggle('fast');
    }
    
    function sub_clear(){
        $(".check_sub_category").each(function(){
             this.checked = false;
        });
    }
    
    $('.srch').click(function(){

    if($('#txtr').val() != "")
    {
        $('#valm').hide();
        filter('click','none','none','0');
    }
     else
    {
        $('#valm').show();
        $("#txtr").focus();
    }

    
    });
    function filterCat(id){
        var category_set = [];
        category_set.push(this.value);
        var category = category_set.toString();
        avs(id,'','');
    }
    
    $('.check_category').on('click', function(){ 
        var category_set = [];
        $(".check_category:checked").each(function(){
             if(this.checked == true){
                category_set.push(this.value);
             }
        });
        var category = category_set.toString();
        avs(category,'','');
    });
    
    if($('.check_vendor').length){
        $('.check_vendor').on('click', function(){
            var category_set = [];
            $(".check_category:checked").each(function(){
                 if(this.checked == true){
                    category_set.push(this.value);
                 }
            });
            var category = category_set.toString();
            avs(category,'','');
        });
    }


/*brand*/
  if($('.check_vendor3').length){
        $('.check_vendor3').on('click', function(){
            var category_set = [];
            $(".check_category:checked").each(function(){
                 if(this.checked == true){
                    category_set.push(this.value);
                 }
            });
            var category = category_set.toString();
            avs(category,'','');
        });
    }
/*brand*/


/*equi*/
  if($('.check_vendor9').length){
        $('.check_vendor9').on('click', function(){
            var category_set = [];
            $(".check_category:checked").each(function(){
                 if(this.checked == true){
                    category_set.push(this.value);
                 }
            });
         //   $("#collapseOneeqi").html('<img src="'+base_url+'uploads/others/loader.gif" />');
         
            var category = category_set.toString();
            avs(category,'','');
        });
    }
/*equi*/

/*Test*/
 
        $('.check_vendor1').on('change', function(){
            var category_set = [];
            $(".check_category:checked").each(function(){
                 if(this.checked == true){
                    category_set.push(this.value);
                 }
            });
            var category = category_set.toString();
            avs(category,'','');
        });
    
/*Test*/
    
    function avs(category,start,end,now){
        var list2 = $('#range');
        $.ajax({
            url: base_url+'index.php/home/others/get_range_by_cat/'+category+'/'+start+'/'+end,
            beforeSend: function() {
                list2.html('...');
            },
            success: function(data) {
                list2.html(data);
                if(now == 'first'){
                    filter('click',cur_category,cur_sub_category,'0');
                } else {
                    filter('click','none','none','0');
                }
            },
            error: function(e) {
                console.log(e)
            }
        });
    }
    
    function filter(set,cat,subcat,page){ 
        var category_set = [];
        var vendor_set = [];
        var sub_category_set = [];
        var fltr_set = [];
        var brand_set=[];
        var height = $( window ).height();

        var equipment_set=[];
        
        $(".check_category:checked").each(function(){
             if(this.checked == true){
                category_set.push(this.value);
             }
        });

        if($('.check_vendor').length){
            $(".check_vendor:checked").each(function(){
                 if(this.checked == true){
                    vendor_set.push(this.value);
                 }
            });
        }
        
        
        /*brand*/
        
        if($('.check_vendor3').length){
            $(".check_vendor3:checked").each(function(){
                 if(this.checked == true){
                    brand_set.push(this.value);
                 }
            });
        }
        
        /*brand*/
        
/*equi*/
        if($('.check_vendor9').length){
            $(".check_vendor9:checked").each(function(){
                 if(this.checked == true){
                    equipment_set.push(this.value);
                 }
            });
        }
/*equi*/


        /*test*/
         if($('.check_vendor1').children('option').length){
          
            $(".check_vendor1 option:selected").each(function(){
                 if(this.selected == true){
                    fltr_set.push(this.value);
                 }
            });
        }
        /*test*/

        $(".check_category").each(function(){
            if(this.checked == false){
                $("#subs_"+this.value+" li input:radio").removeAttr("checked");
                $("#subs_"+this.value).hide('fast');
             }
        });
        
        $(".check_sub_category:checked").each(function(){
             if(this.checked == true){
                sub_category_set.push(this.value);
             }
        });
        
        
        var category = category_set.toString();
        if($('.check_vendor').length){
            var vendor = vendor_set.toString();
        }
        
        
        
        /*brand*/
        if($('.check_vendor').length){
            var brand = brand_set.toString();
        }
        /*brand*/

         /*equ*/
        if($('.check_vendor').length){
            var equipment = equipment_set.toString();
        }
        /*equi*/
        
        /*Test*/
        if($('.check_vendor').length){
            var fltr = fltr_set.toString();
        }
        /*Test*/
        var featured = '';
        var sub_category = sub_category_set.toString();
        var type = $("#viewtype").val();
        var fload = $("#fload").val();
        if(cat !== 'none'){
            category = cat;
        }
        if(subcat !== 'none'){
            sub_category = subcat;
        }
        var alert = $('#list'); // alert div for show alert message
        
        var range = $('#rangelvl').val();
		var form = $('#plistform');
        var trxt = $('#txtr').val();
         trxt    =   trxt.replace("'", '');
        trxt = trxt.trim();
        trxt = trxt.split(","); 
        $.each(trxt , function (index, value){
            if(value != ''){
                if(index == 0){ trxt = value; }else{ trxt = trxt+' '+value; }
            }
        });
		$('#categoryaa').val(category);
		$('#sub_categoryaa').val(sub_category);
		$('#featuredaa').val(featured);
        $('#rangeaa').val(range);
        $('#search_text').val(trxt);
        if($('.check_vendor').length){
            $('#vendora').val(vendor);
        }
        /*Test*/
        if($('.check_vendor1').length){
            $('#fltr_text').val(fltr);
        }
		
        //brand
         if($('.check_vendor3').length){
            $('#brnd_text').val(brand);
        }
        //brand

        //equi
        if($('.check_vendor9').length){
            $('#equ_text').val(equipment);
         //  alert($('#equ_text').val(equipment));
        }
        //equi

        //var form = $(this);
        var formdata = false;
        if (window.FormData){
            formdata = new FormData(form[0]);
        }
         
	var filterData  =   {
                                0: 'category',
                                1: 'brand',
                                2: 'equipment',
                                3: 'vendor',
                            };	
        var filterId    =   $('#filter-id').val();
        if(filterId != ''){
            var setCat      =   parseInt($('#filter-cat').val());
            if(parseInt($('#filter-cat').val()) > 0){ 
                var param1  =   $('#filter-cat').val(); $('.all-cat').hide(); var allCat    =   0;
            }else{ 
                var param1  =   category ? category : 0;  var allCat    =   1;
            }
            if($('#elvText').val() != ''){ trxt = $('#elvText').val(); trxt = trxt.trim(); }
            var param2      =   sub_category ? sub_category.replace(',','-') : 0;
            var param3      =   brand ? brand : 0;
            var param4      =   equipment ? equipment : 0;
            var param5      =   trxt; 
            var param6      =   vendor ? vendor : 0;
            if(filterId == 'category'){
                filterCategory(base_url,param1,param2,param3,param4,param5,allCat,param6);
                filterBrands(base_url,param1,param2,param3,param4,param5,allCat,param6);
                filterEquipments(base_url,param1,param2,param3,param4,param5,allCat,param6);
                filterVendor(base_url,param1,param2,param3,param4,param5,allCat,param6);
            }else if(filterId == 'brand'){
                $("#subs_"+param1).show('fast');
                filterCategory(base_url,param1,param2,param3,param4,param5,allCat,param6);
                filterBrands(base_url,param1,param2,param3,param4,param5,allCat,param6);
                filterEquipments(base_url,param1,param2,param3,param4,param5,allCat,param6);
                filterVendor(base_url,param1,param2,param3,param4,param5,allCat,param6);
            }else if(filterId == 'equipment'){
                filterCategory(base_url,param1,param2,param3,param4,param5,allCat,param6);
                filterBrands(base_url,param1,param2,param3,param4,param5,allCat,param6);
                filterEquipments(base_url,param1,param2,param3,param4,param5,allCat,param6);
                filterVendor(base_url,param1,param2,param3,param4,param5,allCat,param6);
            }
            else if(filterId == 'vendor'){
                filterCategory(base_url,param1,param2,param3,param4,param5,allCat,param6);
                filterBrands(base_url,param1,param2,param3,param4,param5,allCat,param6);
                filterEquipments(base_url,param1,param2,param3,param4,param5,allCat,param6);
                filterVendor(base_url,param1,param2,param3,param4,param5,allCat,param6);
            }
         //   filterCategory(base_url);
        }
        $.ajax({
            url: form.attr('action')+set+'/'+page+'/'+type, // form action url
			type: 'POST', // form submit method get/post
			dataType: 'html', // request type html/json/xml
			data: formdata ? formdata : form.serialize(), // serialize form data 
			cache       : false,
			contentType : false,
			processData : false,
            beforeSend: function() {
				alert.fadeOut();
                                
                              
                alert.html(''
                +'<div style="height:'+height+'px; width:100%;">'
                +'  <img style="top:'+(height/3)+'px; left:45%; position:relative;"' 
                +'      src="'+base_url+'uploads/others/loader.gif" />'
                +'<div>').fadeIn(); // change submit button text
            },
            success: function(data) {
				setTimeout(function(){
                	alert.html(data); // fade in response data
				}, 20);
				setTimeout(function(){
                	alert.fadeIn(); // fade in response data
				}, 30);
				if(fload == 'done'){
					//history.pushState('data', '', base_url+'index.php/home/category/'+category);
				}
				$("#fload").val('done');
                $(".pagination li a").attr("href", "#");
            //    filterEquipments(base_url);
            },
            error: function(e) {
                console.log(e)
            }
        });
        
        
        
     //   for($i=0; $i<2; $i++){
        //    var filterId    =   $('#filter-id').val();
       //     if(filterId != filterData[$i] && filterId != ''){
//                $.ajax({
//                    url: base_url+'index.php/home/filterSidebar/brand',
//                    type: 'POST', // form submit method get/post
//                    dataType: 'html', // request type html/json/xml
//                    formdata    :   {cat:category,subcat:sub_category},
//                    data        : formdata,
//                    cache       : false,
//                    contentType : false,
//                    processData : false,
//                    beforeSend: function() {
//                        $('.brand-panel').html('<img style=" left:45%; position:relative;" src="'+base_url+'uploads/others/loader.gif" />');
//                    },
//                    success: function(response) {
//                        $('.brand-panel').html(response);
//                      //  filterEquipments(base_url);
//                    },
//                    error: function(e) {
//                        console.log(e)
//                    }
//                });
       //     }
      //  }
//            $.ajax({
//                url: base_url+'index.php/home/filterSidebar/equipment',
//                type: 'POST', // form submit method get/post
//                dataType: 'html', // request type html/json/xml
//                formdata    :   {cat:'category'},
//                data        : formdata,
//                cache       : false,
//                contentType : false,
//                processData : false,
//                beforeSend: function() {
//                    $('.equipment-panel').html('<img style=" left:45%; position:relative;" src="'+base_url+'uploads/others/loader.gif" />');
//                },
//                success: function(response) {
//                    $('.equipment-panel').html(response);
//                    filterEquipments();
//                },
//                error: function(e) {
//                    console.log(e)
//                }
//            });
      
    }
    function filterBrands(base_url,val1,val2,val3,val4,val5,val6,val7){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            $('#collapseOne2').html('<img style=" left:45%; position:relative;" src="'+base_url+'uploads/others/loader.gif" />');
            $('#filter-subcat-id').val(val2);
            if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
               if (xmlhttp.status == 200) {
                   document.getElementById("collapseOne2").innerHTML = xmlhttp.responseText;
               }
               else if (xmlhttp.status == 400) {
                  alert('There was an error 400');
               }
               else {
                   alert('something else other than 200 was returned');
               }
            }
        };
        xmlhttp.open("GET", base_url+"index.php/home/filterSidebar/brand/"+val1+"/"+val2+"/"+val3+"/"+val4+"/"+val7+"/"+val6+"/"+val5, true);
        xmlhttp.send();
    }
    function filterEquipments(base_url,val1,val2,val3,val4,val5,val6,val7){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            $('#collapseOne3').html('<img style=" left:45%; position:relative;" src="'+base_url+'uploads/others/loader.gif" />');
            $('#filter-subcat-id').val(val2);
            if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
               if (xmlhttp.status == 200) {
                   document.getElementById("collapseOne3").innerHTML = xmlhttp.responseText;
               }
               else if (xmlhttp.status == 400) {
                  alert('There was an error 400');
               }
               else {
                   alert('something else other than 200 was returned');
               }
            }
        };
        xmlhttp.open("GET", base_url+"index.php/home/filterSidebar/equipment/"+val1+"/"+val2+"/"+val3+"/"+val4+"/"+val7+"/"+val6+"/"+val5, true);
        xmlhttp.send();
    }
    function filterCategory(base_url,val1,val2,val3,val4,val5,val6,val7){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            $('#collapseOne1').html('<img style=" left:45%; position:relative;" src="'+base_url+'uploads/others/loader.gif" />');
            $('#filter-subcat-id').val(val2);
            if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
               if (xmlhttp.status == 200) {
                   document.getElementById("collapseOne1").innerHTML = xmlhttp.responseText;
               }
               else if (xmlhttp.status == 400) {
                  alert('There was an error 400');
               }
               else {
                   alert('something else other than 200 was returned');
               }
            }
        };
        xmlhttp.open("GET", base_url+"index.php/home/filterSidebar/category/"+val1+"/"+val2+"/"+val3+"/"+val4+"/"+val7+"/"+val6+"/"+val5, true);
        xmlhttp.send();
    }
    function filterVendor(base_url,val1,val2,val3,val4,val5,val6,val7){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            $('#collapseOne4').html('<img style=" left:45%; position:relative;" src="'+base_url+'uploads/others/loader.gif" />');
            $('#filter-subcat-id').val(val2);
            if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
               if (xmlhttp.status == 200) {
                   document.getElementById("collapseOne4").innerHTML = xmlhttp.responseText;
               }
               else if (xmlhttp.status == 400) {
                  alert('There was an error 400');
               }
               else {
                   alert('something else other than 200 was returned');
               }
            }
        };
        xmlhttp.open("GET", base_url+"index.php/home/filterSidebar/vendor/"+val1+"/"+val2+"/"+val3+"/"+val4+"/"+val7+"/"+val6+"/"+val5, true);
        xmlhttp.send();
    }
                
    $(document).ready(function() {
        $(".check_category").each(function(){ 
            if(this.value == cur_category && $('#filter-id').val() != ''){
                $(this).attr("checked",true);
                $("#subs_"+this.value).show('fast');
             }
        });
        
        $(".check_sub_category").each(function(){
            if(this.value == cur_sub_category){
                $(this).attr("checked",true);
             }
        });
        
        var a = range;
        a = a.split(';');
        avs(cur_category,a[0],a[1],'first');
    });

    $(".viewers").click(function(){
        $("#viewtype").val($(this).data('typ'));
        filter('click','none','none','0');
    });
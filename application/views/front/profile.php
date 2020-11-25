    <?php
     foreach($user_info as $row)
        {
        ?>
    <div class="profile container content mt-5">
    	<div class="row">
            <div class="col-md-3 mb-4 profwidget">
				<div class="profilebx">
					<?php 
        	            if(file_exists('uploads/user_image/user_'.$row['user_id'].'.jpg'))
        	            { ?>
                            <img class="img-responsive profile-img margin-bottom-20" src="<?php echo base_url(); ?>uploads/user_image/user_<?php echo $row['user_id']; ?>.jpg?<?php echo time(); ?>" alt="User_Image">
                            <?php 
                        } 
                        else if($row['fb_id'])
                        { ?>
                            <img class="img-responsive profile-img margin-bottom-20" src="https://graph.facebook.com/<?php echo $row['fb_id']; ?>/picture?type=large" alt="User_Image">
                            <?php 
                        } 
                        else if($row['g_id'])
                        { ?>
                            <img class="img-responsive profile-img margin-bottom-20" src="<?php echo $row['g_photo']; ?>" alt="User_Image">
                            <?php 
                        } 
                        else 
                        { ?>
                            <img class="img-responsive profile-img margin-bottom-20" src="<?php echo base_url(); ?>uploads/user_image/default.png" >
                            <?php 
                        } ?>
				</div>
                <table class="table">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <center><h4><?php echo translate('personal_information');?></h4></center>
                            </td>                          
                        </tr>
                        <tr>
                            <th><?php echo translate('name');?></th>
                            <td> <?php echo ucfirst($row['username']).' '.$row['surname'];?></td>                          
                        </tr> 
                        <tr>
                            <th><?php echo translate('email');?></th>
                            <td><?php echo $row['email'];?></td>                          
                        </tr> 
                        <tr>
                            <th><?php echo translate('mobile');?></th>
                            <td><?php echo $row['mobile'];?></td>                          
                        </tr> 
                        <tr>
                            <th><?php echo translate('address');?></th>
                            <td>
								<?php 
		 							$ucountry =  $this->crud_model->getCountryName($row['country_id']);
									$ustate   = $this->crud_model->getStateName($ucountry->country_id, $row['state_code']);
		 							echo $row['address1'];
		 							echo ($row['address2'])?' ,'.$row['address2']:'';
		 							echo '<br/>'.$row['city'];
		 							echo ($row['state_code'])?' ,'.$ustate:'';
		 							echo '<br/>'.$ucountry->name;
		 							echo ($row['zip'])?' - '.$row['zip']:'';
								?>
                            </td>                          
                        </tr> 
                    </tbody>
                </table>
            </div>
            

            <div class="col-md-9 mb-4">
                <div class="row mr-0 ml-0">
                        <div class="col-sm-6 profwidget">
							
                            <div class="service-block-v3 service-block-u">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="service-heading">
                                	<?php echo translate('total_purchase');?>
                                </span>
                                <span class="counter">
                                	<?php echo currency().$this->crud_model->user_total(0); ?>
                                </span>
                                <div class="clearfix margin-bottom-10"></div>
                                <div class="row">
                                    <div class="col-md-6 service-in">
                                        <small><?php echo translate('last_7_days');?></small>
                                        <h4 class="counter" style="margin-bottom:0;">
											<?php echo currency().$this->crud_model->user_total(7); ?>
                                        </h4>
                                    </div>
                                    <div class="col-md-6 text-right service-in">
                                        <small><?php echo translate('last_30_days');?></small>
                                        <h4 class="counter" style="margin-bottom:0;">
											<?php echo currency().$this->crud_model->user_total(30); ?>
                                        </h4>
                                    </div>
                                </div>            
                            </div>
                        </div>
                        <div class="col-sm-6 profwidget">
                            <div class="service-block-v3 service-block-u">
                                <i class="fa fa-heart"></i>
                                <span class="service-heading"><?php echo translate('wished_products');?></span>
                                <span class="counter count_wished">
                                	<?php echo $this->crud_model->user_wished(); ?>
                                </span>
                                
                                <div class="clearfix mb-2"></div>
                                
                                <div class="row mb-3 mr-0 ml-0">
                                    <div class="col-md-6 service-in">
                                        <small><?php echo translate('user_since');?></small>
                                        <h4 class="counter" style="margin-bottom:0;">
                                        	<?php
                                            	echo date('d M, Y',$row['creation_date']);
											?>
                                        </h4>
                                    </div>
                                    <div class="col-md-6 text-right service-in">
                                        <small><?php echo translate('last_login');?></small>
                                        <h4 class="counter" style="margin-bottom:0;">
                                        	<?php
                                            	echo date('d M, Y',$row['last_login']);
											?>
                                        </h4>
                                    </div>
                                </div>            
                            </div>
                        </div>
						
                </div>

                <div class="tab-v2" id="tab_profile">
                    <ul class="nav nav-tabs">
						<?php
		 					$purcmenu=$wishmenu=$editmenu=$chpasmenu='';
		 					$purctab=$wishtab=$edittab=$chpastab='';
		 					if($argu=='wishlist')
							{
								$wishmenu='active';
								$wishtab='active in';
							}
		 					else if($argu=='edit')
							{
								$editmenu='active';
								$edittab='active in';
							}
		 					else if($argu=='password')
							{
								$chpasmenu='active';
								$chpastab='active in';
							}
		 					else
							{
								$purcmenu='active';
								$purctab='active in';
							}
		 				?>
                            <li class="<?php echo $purcmenu; ?>">
								<a href="#tab-1" data-toggle="tab">
									<?php echo translate('purchase_history');?>
								</a>
							</li>
                            <!--<li class="">
									<a href="#downloads" data-toggle="tab">
										<?php //echo translate('downloads');?>
									</a>
							</li> -->
                            <li class="<?php echo $wishmenu; ?>">
								<a href="#wishli" data-toggle="tab">
									<?php echo translate('wishlist');?>
								</a>
							</li>
                            <li class="<?php echo $editmenu; ?>">
								<a href="#tab-2" data-toggle="tab">
									<?php echo translate('edit_info');?>
								</a>
							</li>
                            <li class="">
                                <a href="#address" data-toggle="tab">
                                        <?php echo translate('address');?>
                                </a>
                            </li>
                            <li class="<?php echo $chpasmenu; ?>">
								<a href="#tab-3" data-toggle="tab">
									<?php echo translate('change_password');?>
								</a>
							</li>
                    </ul>  

                    <div class="tab-content">
                            <div class="tab-pane fade <?php echo $purctab; ?>" id="tab-1">
                                <table id="purchase_table" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sl.No</th>
                                            <th style="width:110px;"><?php echo translate('date');?></th>
                                            <th><?php echo translate('item_name');?></th>
                                            <th><?php echo translate('total');?></th>
                                            <th><?php echo translate('payment_status');?></th>
                                           <!--  <th><?php // echo translate('shop_name');?></th>-->
                                            <th><?php echo translate('delivery_status');?></th>
                                            <th><?php echo translate('invoice');?></th>
                                             <th><?php echo translate('reorder');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $i = 0;
                                        $this->db->order_by('sale_id','desc');
                                        $sales = $this->db->get_where('sale',array('buyer'=>$row['user_id']))->result_array();
                                        foreach ($sales as $row1) 
                                        {
                                            
                                            //echo $row1['product_details'];
                                            $pr=$row1['product_details'];
                                            $data = json_decode($pr,true);
                                            
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo date('d M Y', strtotime($row1['sale_datetime'])); ?></td>
                                                <td id="<?php echo $i."_" ?>reorder">  
                                                
                                                    <?php 
                                                 
                                                        $s=0;                        
                                                        foreach($data as $datum)
                                                        {
                                                           $product_id=$datum['id'];
                                                            $s++;
                                                            
                                                           echo  $s.") "." ".$this->crud_model->get_type_name_by_id('product', $product_id, 'title');
                                                            ?>
                                                            <div class="clear"></div>

                                                            <?php  
                                                                if($this->crud_model->is_added_to_cart($product_id))
                                                                { ?>
                                                                    <a style="visibility:hidden ;" class=" add_to_cart " data-type='icon'  data-original-title="<?php echo translate('reorder'); ?>" data-toggle="tooltip" data-placement="top"   data-pid='<?php echo $product_id; ?>' id='<?php echo $product_id; ?>' >
                                                                    </a>
                                                                    <?php 
                                                                } 
                                                                else 
                                                                { ?>
                                                                    <a style="visibility:hidden;" class="add_to_cart " data-original-title="<?php echo translate('reorder'); ?>" data-toggle="tooltip" data-placement="top"    data-type='icon' data-pid='<?php echo $product_id; ?>' id='<?php echo $product_id; ?>' >
                                                                    </a>
                                                                    <?php 
                                                                } 
                                                        }
                                                            
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        echo currency().$this->cart->format_number($row1['grand_total']);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $payment_status = json_decode($row1['payment_status'],true); 
                                                        foreach ($payment_status as $dev) 
                                                        {
                                                            ?>

                                                            <span class="label label-<?php if($dev['status'] == 'paid'){ ?>purple<?php } else { ?>danger<?php } ?>" style="margin:2px;">
                                                            <?php
                                                            if(isset($dev['vendor']))
                                                            {
                                                             
                                                                echo translate($dev['status']).'<br>';
                                                            } 
                                                            else if(isset($dev['admin'])) 
                                                            {
                                                                echo translate($dev['status']);
                                                            }
                                                            ?>
                                                            </span>
                                                            <br>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $delivery_status = json_decode($row1['delivery_status'],true); 
                                                        foreach ($delivery_status as $dev) 
                                                        {
                                                            ?>

                                                            <span class="label label-<?php if($dev['status'] == 'delivered'){ ?>purple<?php } else { ?>danger<?php } ?>" style="margin:2px;">
                                                            <?php
                                                            if(isset($dev['vendor']))
                                                            {
                                                                echo translate($dev['status']).'<br>';
                                                            } 
                                                            else if(isset($dev['admin'])) 
                                                            {
                                                                echo translate($dev['status']);
                                                            }
                                                            ?>
                                                            </span>
                                                            <br>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <a class="btn-u btn-u-cust btn-u btn-u-xs float-shadow" href="<?php echo base_url(); ?>index.php/home/invoice/<?php echo $row1['sale_id']; ?>"><?php echo translate('invoice');?>
                                                    </a>
                                                </td>  
                                                <td class="text-center tdBg">
                                                    <button onclick="myReorder(this.id);" id="<?php echo $i."_" ?>reordercart" class="tooltips btn-u btn-u-cust  btn_radius2" data-original-title="<?php echo translate('reorder'); ?>" data-toggle="tooltip" data-placement="top"    data-type='icon' >
                                                            <i class="fa fa-shopping-cart"></i>
                                                    </button>
                                                </td>                        
                                            </tr>
                                            <?php
                                        }
                                    ?>   
                                	</tbody>
                                </table>  
                                <script>
                                function myReorder(id)
                                {
                                    var reid=id;
                                    var roed=reid.split('_');
                                    var div_id='#'+roed[0]+'_reorder';
                                    $(div_id).find('a').each(function() {
                                        var id_tgr='#'+$(this).attr('data-pid');
                                        $(id_tgr).trigger('click');
                                        console.log(id_tgr);
                                        //alert(div_id);
                                        });  
                                }
                                </script>                       
                            </div>


                            <div class="tab-pane fade" id="downloads">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo translate('image');?></th>
                                            <th><?php echo translate('name');?></th>
                                            <th><?php echo translate('download');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $i = 0;
                                        $downloads = $this->db->get_where('user',array('user_id'=>$row['user_id']))->row()->downloads;
                                        if($downloads == ''){
                                            $downloads = json_decode('[]',true);
                                        } else {
                                            $downloads = json_decode($downloads,true);
                                        }
                                        foreach ($downloads as $row1) {
                                            $i++;
                                            $query1 = $this->db->get_where('product',array('product_id'=>$row1['product']));
											if($query1->num_rows()>0){
												$query = $query1->row();
                                    ?>
                                        
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td>
                                                <img src="<?php echo $this->crud_model->file_view('product',$row1['product'],'','','thumb','src','multi','one'); ?>" width="100" />
                                            </td>
                                            <td><?php echo $query->title; ?></td>
                                            <td>
                                                <a class="btn-u btn-u-cust btn-block  btn-labeled fa fa-cloud-download download_it" data-pid='<?php echo $row1['product']; ?>'><?php echo translate('download');?>
                                                </a>
                                            </td>                          
                                        </tr>
                                    <?php
											}
                                        }
                                    ?>   
                                    </tbody>
                                </table>                        
                            </div>
                        
                        <div class="tab-pane fade" id="address">
                            <?php include 'user/address.php'; ?>
                        </div>

                            <div class="tab-pane fade <?php echo $wishtab; ?>" id="wishli">
                                <table id="wishlist_table" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sl.No</th>
                                            <th><?php echo translate('image');?></th>
                                            <th><?php echo translate('name');?></th>
                                            <th><?php echo translate('price');?></th>
                                            <th><?php echo translate('availability');?></th>
                                            <th><?php echo translate('purchase');?></th>
                                            <th><?php echo translate('remove');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $i = 0;
                                        $wishlist = json_decode($this->db->get_where('user',array('user_id'=>$row['user_id']))->row()->wishlist);
                                        foreach ($wishlist as $row1) {
                                            $i++;
                                            $query = $this->db->get_where('product',array('product_id'=>$row1))->row();
                                    ?>
                                        
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td>
                                                <img src="<?php echo $this->crud_model->file_view('product',$row1,'','','thumb','src','multi','one'); ?>" width="100" />
                                            </td>
                                            <td><?php echo $query->title; ?></td>
                                            <td><?php echo currency().$this->crud_model->get_product_price($row1); ?></td>
                                            <td>
                                                <?php if($query->current_stock <= 0){ ?>
                                                    <span class="label label-dark">
                                                        <?php echo translate('unvailable'); ?>
                                                    </span>
                                                <?php } else { ?>
                                                    <span class="label label-green">
                                                        <?php echo translate('available'); ?>
                                                    </span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($this->crud_model->is_added_to_cart($row1)){ ?>
                                                    <a class="tooltips btn-u btn-u-default disabled add_to_cart btn_radius2" data-type='icon'  data-original-title="<?php echo translate('add_to_cart'); ?>" data-toggle="tooltip" data-placement="top"   data-pid='<?php echo $row1; ?>' >
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </a>
                                                <?php } else { ?>
                                                    <a class="tooltips btn-u btn-u-cust add_to_cart btn_radius2" data-original-title="<?php echo translate('added_to_cart'); ?>" data-toggle="tooltip" data-placement="top"  data-type='icon' data-pid='<?php echo $row1; ?>' >
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                            <td class="text-center tdBg">
                                                <a class="tooltips remove_from_wish" data-original-title="<?php echo translate('remove_from_wishlist'); ?>" data-placement="top" data-toggle="tooltip" data-pid='<?php echo $row1; ?>' >
                                                    <button class="tooltips btn-u btn-u-red" type="button">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </a>
                                            </td>                          
                                        </tr>
                                    <?php
                                        }
                                    ?>   
                                    </tbody>
                                </table>                        
                            </div>

                            <div class="tab-pane fade <?php echo $edittab; ?>" id="tab-2">
                                <div class="row margin-bottom-40">
                                    <div class="col-md-12">
                        				<!-- Reg-Form -->
										<?php
                                        echo form_open(base_url() . 'home/registration/update_info/', array(
                                                'class' => 'sky-form log-reg-v3',
                                                'method' => 'post',
                                                'enctype' => 'multipart/form-data',
                                                'id' => 'sky-form4'
                                            ));
                                        $countries      =   $this->db->where(['status'=>1])->order_by('id','desc')->get('countries')->result();
                                        ?>    
                                        	<?php
                                            foreach($user_info as $row){ ?>
                                            <fieldset class="col-12">         
                                                <div class="row">
                                                        <section class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <label class="input">
                                                                        <i class="fa fa-user" ></i>
                                                                        <input type="text" name="username" class="required" value="<?php echo $row['username'];?>" placeholder='<?php echo translate('first_name'); ?>' data-toggle="tooltip" data-placement="left" title="<?php echo translate('your_first_name'); ?>">
                                                                </label>
                                                        </section> 

                                                        <section class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <label class="input">
                                                                        <i class="fa fa-user"></i>
                                                                        <input type="text" name="surname" class="required" value="<?php echo $row['surname'];?>" placeholder='<?php echo translate('last_name'); ?>' data-toggle="tooltip" data-placement="left" title="<?php echo translate('your_last_name'); ?>">
                                                                </label>
                                                        </section>
                                                </div>

                                                <div class="row">
                                                        <section class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <label class="input">
                                                                        <i class="fa fa-envelope"></i>
                                                                        <input readonly type="email" name="email" class="required emailss" onchange="exitsemail()" value="<?php echo $row['email'];?>" placeholder='<?php echo translate('email_id'); ?>' data-toggle="tooltip" data-placement="left" > <!-- title="<?php //echo translate('your_email'); ?>" -->
                                                                </label>
                                                                <span id="email_note" style="display: none;"> 
                                                                        * <?php echo translate('this_email_exist'); ?>    
                                                                </span>                
                                                        </section>
                                                        <input id="keyemail" type="text" hidden value="<?php echo $row['email'];?> ">                                            
                                                    <section class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="row"><div class="col-md-3 col-4 pr-0">
                                                                <select id="c_code" name="c_code" class="form-control p-1" ><?php
                                                                    if($countries){ foreach($countries as $rw){
                                                                        if($rw->phonecode == $row['c_code']){ $selected = 'selected="selected"'; }else{ $selected = ''; }
                                                                        echo '<option value="'.$rw->phonecode.'" data-image="'.base_url('template/front/assets/img/msdropdown/icons/blank.gif').'" data-imagecss="flag '.strtolower($rw->sortname).'" data-title="'.$rw->name.'" '.$selected.'>+'.$rw->phonecode.'</option>';
                                                                    } }?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-9 col-8 pl-2">
                                                                <label class="input">
                                                                    <i class="fa fa-mobile"></i>
                                                                    <input type="text" id="mobile" class="required only-numeric" name="mobile" value="<?php echo $row['mobile'];?>" maxlength="10" placeholder='<?php echo translate('mobile_number'); ?>' data-toggle="tooltip" data-placement="left" title="<?php echo translate('your_mobile_number'); ?>">
                                                                </label>
                                                            </div></div>
                                                        
                                                        <span id="mobile_note" style="display: none;"> 
                                                            * <?php echo translate('this_number_exist'); ?>    
                                                        </span> 
                                                    </section>
                                                </div>

                                                <div class="row">
                                                        <section class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <label class="input">
                                                                        <i class="fa fa-home"></i>
                                                                        <input type="text" name="address1" class="required" value="<?php echo $row['address1'];?>" placeholder='<?php echo translate('address_line_1'); ?>' data-toggle="tooltip" data-placement="left" title="<?php echo translate('address_line_1'); ?>">
                                                                </label>
                                                        </section>
                                                        <section class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <label class="input">
                                                                        <i class="fa fa-home"></i>
                                                                        <input type="text" name="address2" value="<?php echo $row['address2'];?>" placeholder='<?php echo translate('address_line_2'); ?>' data-toggle="tooltip" data-placement="left" title="<?php echo translate('address_line_2'); ?>">
                                                                </label>
                                                        </section>
                                                </div>

                                                <div class="row">
                                                        <section class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <label class="input">
                                                                        <i class="fa fa-university"></i>
                                                                        <input type="text" name="city" class="required" value="<?php echo $row['city'];?>" placeholder='<?php echo translate('city'); ?>' data-toggle="tooltip" data-placement="left" title="<?php echo translate('city'); ?>">
                                                                </label>
        </section>
                                                        <section class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <label class="input">
                                                                        <i class="fa fa-home"></i>
                                                                        <input type="text" name="zip" class="required" value="<?php echo $row['zip'];?>" placeholder='<?php echo translate('Zip/Pin Code'); ?>' data-toggle="tooltip" data-placement="left" title="<?php echo translate('zip_code'); ?>">
                                                                </label>
                                                        </section>
                                                </div>
												
												<div class="row">
													<section class="col-lg-6 col-md-6 col-sm-12 col-12">
														<label class="input">
															<i class="fa fa-facebook"></i>
															<input type="text" name="facebook" value="<?php echo $row['facebook'];?>" placeholder='<?php echo translate('facebook_profile_link'); ?>' data-toggle="tooltip" data-placement="left" title="<?php echo translate('your_facebook_profile_link'); ?>">
														</label>
													</section>
                        
													<section class="col-lg-6 col-md-6 col-sm-12 col-12">
														<label for="file" class="input input-file">
															<div class="upload-btn-wrapper ">
															  <i class="fa fa fa-picture-o"></i>	
															  <span id="wrap-btn" class="btn-default btn-file">
																  <?php echo translate('select_new_profile_picture');?>
															  </span>
															   <input data-toggle="tooltip" data-placement="left" title="<?php echo translate('change_your_profile_picture'); ?>" type="file" name="image" id='profpic' accept="image/*" />
															</div>
															<!-- <div class="button btn-u btn-u-cust">
																<input type="file" name="image" onchange="document.getElementById('nam').value = this.value;"  data-toggle="tooltip" data-placement="left" title="<?php echo translate('change_your_profile_picture'); ?>">
															</div>
															<input type="text" id="nam" placeholder="Change Profile Picture" readonly> -->
														</label>
														<span id="file-valid"></span>
													</section>
												</div>
                                            </fieldset>
                                            <?php
												}
											?>
                                            <footer>
                                            	<section class="col-12 nopad">
													<div class="ps-checkbox pull-left">
													 <?php
		 												$sub_check='';
		 												$ubqry=$this->db->get_where('subscribe', array('email' =>$row['email']))->num_rows();
		 												//echo $ubqry;
		 												$sub_check=($ubqry>0)?'checked':'';
		 											 ?>
													  <input <?php echo $sub_check; ?> class="form-control" type="checkbox" id="subcribe-profile" name="subscribe_profile">
													  <label for="subcribe-profile">Subscribe to get information about products and coupons</label>
            										</div>
                                                    <div class="pull-right">
                                                        <span type="submit" id="sub_upi" class="btn-u btn-u-update btn-block margin-bottom-20 btn-labeled fa fa-check-circle submitter" data-msg='Info Updated!' data-ing='Updating..'>
															<?php echo translate('update_info')?>
                                                        </span>
                                                    </div>
                                                </section>
												<div class="clear"></div>
                                            </footer>
                                        <?php
										  echo form_close();		
										?>        
                                        <!-- End Reg-Form -->
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade <?php echo $chpastab; ?>" id="tab-3">
                               <div class="row margin-bottom-40">
                               		<div class="col-md-12">
										<?php
                                            echo form_open(base_url() . 'home/registration/update_password/', array(
                                                'class' => 'sky-form',
                                                'method' => 'post',
                                                'enctype' => 'multipart/form-data',
                                                'id' => 'sky-form1',
												'novalidate' => 'novalidate'
                                            ));
                                        ?> 
                                            <fieldset class="col-12"> 
												<div class="">
													<section class="col-lg-6 col-md-6 col-sm-12 col-12">
														<label class="input">
															<i class="fa fa-lock"></i>
															<input type="password" name="password"  class="passr required" placeholder="<?php echo translate('current_password');?>" data-toggle="tooltip" data-placement="left" title="<?php echo translate('your_current_password'); ?>">
														</label>
													</section>
												
													<section class="col-lg-6 col-md-6 col-sm-12 col-12">
														<label class="input">
															<i class="fa fa-key"></i>
															<input type="password" name="password1" class="pass pass1 passr required" placeholder="<?php echo translate('new_password');?>" data-toggle="tooltip" data-placement="left" title="<?php echo translate('enter_new_password'); ?>" >
														</label>
													</section>
                                                
													<section class="col-lg-6 col-md-6 col-sm-12 col-12">
														<label class="input">
															<i class="fa fa-thumbs-up"></i>
															<input type="password" name="password2" class="pass pass2 passr required" placeholder="<?php echo translate('confirm_new_password');?>" data-toggle="tooltip" data-placement="left" title="<?php echo translate('re-enter_your_new_password'); ?>">
															<div id="pass_note"></div>
														</label>
													</section>
												</div>
                                            </fieldset>
                                            <footer>
                                               <section class="col-md-12 nopad">
                                                    <div class="pull-right">
                                                          <span class="btn btn-u btn-u-update btn-block margin-bottom-20 btn-labeled fa fa-key submitter pass_chng disabled" disabled='disabled' data-msg='Password Saved!' data-ing='Saving'><?php echo translate('save_password'); ?></span>
                                                    </div>
                                               </section>
                                            </footer>
                                         <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                
            </div>
        </div>
    </div>  
    
    <?php
    }
?>
<script>
	var mismatch = '<?php echo translate('password_mismatched'); ?>';
	var required = '<?php echo translate('required'); ?>';
	var must_number = '<?php echo translate('must_be_a_number'); ?>';
	var valid_email = '<?php echo translate('must_be_a_valid_email_address'); ?>';
    var incor = '<?php echo translate('incorrect_password'); ?>';
    var downloading = '<?php echo translate('downloading...'); ?>';
	var base_url = '<?php echo base_url(); ?>';

    $('.download_it').on('click',function(){
        var here = $(this);
        var id = here.data('pid');
        var txt = here.html();
        $.ajax({
            url: base_url+'index.php/home/can_download/'+id,
            beforeSend: function() {
                $(this).html(downloading);
            },
            success: function(data) {
                if(data == 'not'){
                    notify("<?php echo translate('download_permission_denied'); ?>",'warning','bottom','right');
                } else {
                    window.location =""+base_url+'index.php/home/download/'+id+"";
                }
                here.html(txt);
            },
            error: function(e) {
                console.log(e)
            }
        });
    });

function exitsemail()
{
    var email = $(".emailss").val();
    var keyemail= $("#keyemail").val(); 
    keyemail=$.trim(keyemail); 
 	if(email == keyemail)
 	{
   		// alert(keyemail);
    	$("#email_note").hide();
    	$("#sub_upi").css("pointer-events", "auto");       
 	}
 	else 
 	{
     $.post("<?php echo base_url(); ?>home/exists",
        {
            <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',
            email: email
        },
        function(data, status){
            if(data == 'yes'){
                $("#email_note").show();
                $("#sub_upi").css("pointer-events", "none");
            } else if(data == 'no'){
                $("#email_note").hide();
                $("#sub_upi").css("pointer-events", "auto");
            }
        });
 }
}
	$(document).ready(function()
	 {
		$('#tab_profile .nav-tabs li').on('click', function(){
    		$(this).addClass('active').siblings().removeClass('active');
		});
		
		$('#purchase_table').DataTable({
			"bLengthChange": false,
			"iDisplayLength": 5,
			"ordering": false,
			"searching": false
       });
		
		$('#wishlist_table').DataTable({
			"bLengthChange": false,
			"iDisplayLength": 5,
			"ordering": false,
			"searching": false
       });
       $(".only-numeric").bind("keypress", function (e) {

          var keyCode = e.which ? e.which : e.keyCode

               

          if (!(keyCode >= 48 && keyCode <= 57)) {

            $(".error").css("display", "inline");

            return false;

          }else{

            $(".error").css("display", "none");

          }

      });
      
      $('#mobile').on('keyup',function(){
          isExistMobile($('#c_code').val(),this.value);
      });
      $('#c_code').on('change',function(){
          isExistMobile(this.value,$('#mobile').val());
      });
//      $('#sub_upi').on('click',function(){
//          alert('sss'); return false;
//        });

        
    });
	
	
	$("#profpic").change(function() 
    {
       $('#file-valid').html("");
       if (this.files && this.files[0]) 
       {
            var fileExtension = ['jpeg','png','jpg'];
            var entx=$(this).val().split('.').pop().toLowerCase();
            if ($.inArray(entx, fileExtension) == -1)
            {
                $('#wrap-btn').html('<?php echo translate('select_new_profile_picture');?>');
                $('#file-valid').html("Image formats allowed : "+fileExtension.join(','));
                $(this).val("");
            }
            else
            {
                $('#file-valid').html("");
                $('#wrap-btn').html('');
                $('#wrap-btn').html(this.files[0].name);
                 /*var reader = new FileReader();
                    reader.onload = function(e) 
                    {
                        $('#wrap').html('<img src="" width="50%" id="img-prev" > ');
                        $('#img-prev').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);*/
            }
       }
    });
	
    function isExistMobile(code,mobile){
        $('#sub_upi').prop('disabled',true);
        $.post("<?php echo base_url(); ?>home/mobile_exists",
        {
            <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',
            c_code: code, mobile: mobile
        },
        function(data, status){
            if(data == 'no'){
                $("#mobile_note").hide();
                $("#sub_upi").css("pointer-events", "auto");
                $('#sub_upi').prop('disabled',false);
            } else{
                $("#mobile_note").text(data); $("#mobile_note").show(); 
                $("#sub_upi").css("pointer-events", "none");
            }
        });

    }
 
	
</script>
<script src="<?php echo base_url(); ?>template/front/assets/js/custom/profile.js"></script>
<style type="text/css">
	#tab-3 .require_alert,#email_note,#mobile_note
    {
        color: red;
        position: absolute;
        top: 5px;
        right: 24px;
    }
	#tab-2 .require_alert,#email_note,#mobile_note
	{
		color: red;
		position: absolute;
		top: 5px;
		right: 24px;
	}
	.sky-form fieldset label {
		display: block;
		border: 1px solid #b7b7b7;
		height: 30px;
	}
	.sky-form fieldset label i {
		padding: 5px 10px 0 10px;
		border-right: 1px solid #bebebe;
		height: 28px;
		line-height: 20px;
		width: 35px;
	}
	.nopad {
		padding-right: 0 !important;
		padding-left: 0 !important;
	}
	.sky-form fieldset {
		border: none;
		margin: 0;
		padding-right: 0 !important;
		padding-left: 0 !important;
		padding-top: 15px;
	}
	.sky-form fieldset label .tooltip {
		display: none;
	}
	.sky-form fieldset label input[type='text'],
	.sky-form fieldset label input[type='email'],
	.sky-form fieldset label input[type='password']{
		width: 80%;
		background: none;
	}
	.sky-form fieldset label.input-file {
		background: #ddd !important;
	}
	.sky-form fieldset label #nam {
		position: absolute;
		top: 1px;
		height: 28px;
		width: 37%;
		padding: 0;
		right: 16px;
	}
	#tab_profile .table td, 
	#tab_profile .table th {
		vertical-align: middle;
	}
	.tdBg {
		background: #eee;
	}
	
	
 .upload-btn-wrapper {
	  position: relative;
	  overflow: hidden;
	  display: inline-block;
}
 .upload-btn-wrapper input[type=file] {
	  /*font-size: 100px;*/
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
.upload-btn-wrapper .btn-file
	{
		font-size: 12px;
		font-weight: 500;

	}
	#file-valid
	{
		color:red;
	}
table{
    width:100%;
}
#example_filter{
    float:right;
}
#example_paginate{
    float:right;
}
#tab-1 label {
    display: inline-flex;
    margin-bottom: .5rem;
    margin-top: .5rem;
}
.dataTables_info {
	float:left;
}
.dataTables_paginate {
	float:right;
}
.dataTables_paginate span .paginate_button,
.dataTables_paginate .paginate_button{
	position: relative;
    display: inline-block;
    padding: 5px 12px;
    margin-left: -1px;
    line-height: 1.25;
    color: #222;
    background-color: #fff;
    border: 1px solid #dee2e6;
}
.dataTables_paginate span .paginate_button,
	.paginate_button.next,
	.paginate_button.previous{
	cursor: pointer;
}
.dataTables_paginate .paginate_button.disabled {
	color: #6c757d;
    pointer-events: none;
    cursor: auto;
    background-color: #fff;
    border-color: #dee2e6;
}
.dataTables_paginate .paginate_button.current {
	z-index: 1;
    color: #fff;
    background-color: #e22626;
    border-color: #e22626;
}
.dataTables_paginate .ellipsis {
	display: inline-block;
    padding: 5px 8px;
}
.paginate_button.next.disabled,
.paginate_button.previous.disabled {
	pointer-events: none;
}
.ddcommon{ line-height: 18px !important;}
</style>

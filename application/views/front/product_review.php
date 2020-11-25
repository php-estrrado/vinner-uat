
			<?php
				echo form_open(base_url() . 'home/review/add/'.$row["product_id"], array('class' => 'ps-form--review','method' => 'post','enctype' => 'multipart/form-data','id' => 'review_add' ,'onsubmit' =>'return reviewadd()'));
					?>
                    
                    <?php
                        if ($this->session->userdata('user_id')>0) 
                        {
                        	$review_data2=$this->db->get_where('reviews',array('user_id !='=>$this->session->userdata('user_id'),'status'=>1,'product_id'=>$row["product_id"]))->result();
                        	if($review_data2)
                        	{
							?>
								<h4>All Reviews</h4>
								<?php 
								foreach ($review_data2 as $key => $rw1)
								 {
								 	$userId = $rw1->user_id;
								 	 // $name = $this->db->where('user_id',$userId)
								 	$uname = $this->db->get_where('user', array('user_id' =>$userId))->row();
								?>
							    <p>
								<b><?php echo $rw1->review_title; ?></b>
								<br/><?php echo $rw1->review; ?>
								<br/>
								<?php
								if($uname)
								{
								?>
								<span style="color: #b4aeae">Reviewed by <?php echo $uname->username; ?> </span>
								<?php
								  }
								  ?></p>
								  <?php
								}
							}
							if ($this->crud_model->is_rated($row["product_id"]) == 'yes') 
							{	
								
								$review_datt=$this->db->get_where('reviews',array('user_id'=>$this->session->userdata('user_id'),'product_id'=>$row["product_id"]));
								if($review_datt->num_rows() > 0)
								{
									$review_data = $review_datt->row();
								?>
								<h4>Your Review</h4>
								<p>
									<b><?php echo $review_data->review_title; ?></b>
									<br/><?php echo $review_data->review; ?>
									<?php
										$rating2 = $review_data->rating;
										$r2 = $rating2; $ri = 0;
										if($r2>0)
										{
										  ?>
											  <select class="ps-rating" data-read-only="true">
												<?php
												  while($ri<5)
												  {
													  $ri++;
													  ?>
													  <option value="<?php if($ri<=$r2){echo '1';}else{echo '2';}?>"></option>
													  <?php
												  }
											   ?>
											  </select>
										<?php
										}
									?>	
								</p>
								<!-- <a href="" class="ps-btn" onclick="return false;">Edit</a> -->
								<?php
								}
							}	
							else
							{
                            ?>
								<h4>Submit Your Review</h4>
								<p>
									Your email address will not be published. Required fields are marked<sup>*</sup>
								</p>
								<div class="form-group form-group__rating">
									<label>Your rating of this product <sup>*</sup>
									</label>
									<select name="rating" id="rev_rating" class="ps-rating" data-read-only="false" >
									  <option value="0">0</option>
									  <option value="1">1</option>
									  <option value="2">2</option>
									  <option value="3">3</option>
									  <option value="4">4</option>
									  <option value="5">5</option>
									</select>
									<label id='raterequ'> </label>
								</div>
								<div class="form-group">
									<input type="text" id="rev_titl" name="review_title" class="form-control"  placeholder="Review Title" />
								</div>
								<div class="form-group">
									<textarea name="review" id="rev_text" class="form-control" rows="6" placeholder="Write your review here"></textarea>
								</div>
								<div class="row">
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12  ">
									  <div class="form-group">
										<input readonly id="rev_name" name="rev_name" class="form-control" type="text" placeholder="Your Name" value=<?php  echo $this->crud_model->get_type_name_by_id('user',$userid,'username') ; ?>>

									  </div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12  ">
									  <div class="form-group">
										<input readonly name="rev_email" id="rev_email" class="form-control" type="email" placeholder="Your Email" value=<?php  echo $this->crud_model->get_type_name_by_id('user',$userid,'email') ; ?>>
									  </div>
									</div>
								</div>
								<div class="form-group submit">
									<button type="submit" class="ps-btn"  onclick="">Submit Review</button>
								</div>
                            	<?php
							}
                        }
                        else
                        {
                            ?>
							<h4>Submit Your Review</h4>
                            <p>
                               	Please <a href="<?php echo base_url('home/login/redirect?page=product_view/'.$row['product_id']); ?>">Log In</a> To Add/Edit/View Review
                            </p>
                             <?php
                        }
                        ?>
                    <?php
            	echo form_close();
        	?>

      <script type="text/javascript">
      	
      	function reviewadd() 
      	{
      		// alert('hai');
      		if($("#rev_rating").val()<=0) 
			{
				if($("#rev_titl").val()=='')
				{
					$("#raterequ").html('Required');
					return false;
				}
				
			}

      	}

      </script>

	<style>
		#raterequ
		{
			color:red;
			margin: auto;
		}
	</style>
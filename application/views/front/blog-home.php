<div class="container" style="margin-bottom: -40px;">
    <div class=" margin-bottom-20">
       <div class="tab-v2 margin-bottom-30" style="background:#fff;">
            <ul class="navp nav-tabs full theme_4" >
                <li class="pull-left"> <h2><?php echo translate('the blog');?></h2></li>
                <li class="pull-right">
                    <div class="owl-btn next tab_hov" style="padding:5px 13px !important;">
                    <i class="fa fa-angle-right"></i>
                    </div>
                </li>
                <li class="pull-right">
                    <div class="owl-btn prev tab_hov" style="padding:5px 13px !important;">
                    <i class="fa fa-angle-left"></i>
                    </div>
                </li>
            </ul>            
            <div class="tab-content">
                <div class="tab-pane fade in active" id="sub_CAT">
                    <div class="row">
                        
                        <div class="illustration-v2 margin-bottom-20">
                            <ul class="list-inline owl-slider-v2 blog_div"><?php 
                                $blogs  =   $this->db->limit(7)->order_by('blog_id','desc')->get('blog')->result_array();
                                foreach($blogs as $row){ ?>
                                    <li class="item custom_item">
                                        <div class="col-sm-12 blog">
                                            <a href="<?php echo base_url() . 'index.php/home/blog_view/' . $row['blog_id'] . '/' . $row['title']; ?>">
                                                <img src="<?php echo base_url()?>uploads/blog_image/blog_<?php echo $row['blog_id']; ?>_thumb.jpg">
                                                <p><?php echo $row['date'];?></p>
                                                <h4 ><?php echo $row['title']; ?> </h4>
                                            </a>
                                            <p><?php echo $limited_word = word_limiter( $row['summery'],30); ?></p>
                                            <span><a href="<?php echo base_url() . 'index.php/home/blog_view/' . $row['blog_id'] . '/' . $row['title']; ?>">Read more<i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                                        </div>
                                    </li><?php
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
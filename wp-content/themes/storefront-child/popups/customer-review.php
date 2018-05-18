<?php
    //$post_data = bf_get_field_acf_group('slide_show');
    //$content = apply_filters('the_content', $post_data->post_content);
    //echo 'xxxxxxxx'.$content.'dddddddddd';

    //$slide = bf_get_field_acf_group('slide_show');
    //$content = apply_filters('the_content', $post_data->post_content);
    /**/
    $args = array(
        'post_type' => 'page',
        'meta_key' => 'customer_page',
        'meta_value' => '1'
    );

    $pages = get_pages($args);


    
    if(count($pages) > 0):
        $customer_page = $pages[0];
        $id = $customer_page->ID;
    else:
        $id = 1133;
    endif;
    
    $post = get_post($id); 
    $content = apply_filters('the_content', $post->post_content); 
    //echo $content;  

    $slides = bf_get_field_acf_group('slide_show');
    
?>
<div class="modal bd-example-modal-lg fade modal-customer-review" id="modal-customer-review" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-customer-review" role="document">
        <div class="modal-content">
            <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/button-customer-review.png';?>" class="customer-review-icon" />
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span  class="close-popup" aria-hidden="true">X</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="wrapper col-md-12 on-desktop">
                    
                    <?php if( !empty($slides) && count($slides) > 0): ?>
                            <?php foreach($slides as $slide): ?>
                                    
                                    <?php
                                        $title = explode('<br/>', $slide['title'] );
                                        
                                        $customer_name = $title[0];
                                        
                                        $customer_job = '&nbsp;';

                                        $description = '&nbsp;';
                                        
                                        if( count($title) > 1)
                                            $customer_job = $title[1];

                                        if( !empty($slide['description']))
                                            $description = $slide['description'];

                                    ?>
                                    <div class="col-review-item col-xs-12 col-md-3">
                                        <?php if( !empty( $slide['image']) ): ?>
                                                 <img src="<?php echo $slide['image']['url'];?>" class="customer-img" />
                                        <?php else:?>
                                                 <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/person-icon.png';?>" class="customer-img" />
                                        <?php endif;?>
                                        <div class="wrapp-review-item">
                                            <div class="wrapp-review-item-title">
                                                <span class="review-customer-name"><?php echo $customer_name;?></span>
                                                <span class="review-customer-job"><?php echo $customer_job;?></span>
                                            </div>
                                            <div class="wrapp-review-item-content">
                                                <?php echo strip_tags($description);?>
                                            </div>
                                        </div>
                                    </div>
                            <?php endforeach;?>
                    <?php endif;?>
                </div>
                
                
                <div class="customer-review-slider col-md-6 on-mobile">
                    <div class="wrapper-slide">
                        <!-- <div class="block-title text-center">
                            <h2>TEST</h2>
                        </div> -->
                        <div class="owl-carousel owl-loaded">
                            <div class="owl-stage-outer">
                                <div class="owl-stage">
                                    <?php if( !empty($slides) && count($slides) > 0): ?>
                                        <?php foreach($slides as $slide): ?>
                                                
                                                <?php
                                                    $title = explode('<br/>', $slide['title'] );
                                                    
                                                    $customer_name = $title[0];
                                                    
                                                    $customer_job = '&nbsp;';

                                                    $description = '&nbsp;';
                                                    
                                                    if( count($title) > 1)
                                                        $customer_job = $title[1];

                                                    if( !empty($slide['description']))
                                                        $description = $slide['description'];

                                                ?>
                                                <div class="owl-item">
                                                    
                                                    <div class="col-review-item">
                                                        <?php if( !empty( $slide['image']) ): ?>
                                                                 <img src="<?php echo $slide['image']['url'];?>" class="customer-img" width="200" height="200" />
                                                        <?php else:?>
                                                                 <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/person-icon.png';?>" class="customer-img" />
                                                        <?php endif;?>
                                                        
                                                        <div class="wrapp-review-item">
                                                            <div class="wrapp-review-item-title">
                                                                <span class="review-customer-name"><?php echo $customer_name;?></span>
                                                                <span class="review-customer-job"><?php echo $customer_job;?></span>
                                                            </div>
                                                            <div class="wrapp-review-item-content">
                                                                <?php echo $description;?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                        <?php endforeach;?>
                                    <?php endif;?>

                                </div>
                                <div class="owl-controls on-desktop">
                                    <div class="owl-nav">
                                        <div class="owl-prev">
                                            <img class='img-fluid' src="<?php child_theme_assets('assets/images/common/prev.png'); ?>" alt="">
                                        </div>
                                        <div class="owl-next">
                                            <img class='img-fluid' src="<?php child_theme_assets('assets/images/common/next.png'); ?>" alt="">
                                        </div>
                                    </div>
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
    

    .col-review-item{
        border:1px solid #fff;
        background-color: #fcd307;
        padding:16px;
        border-radius: 10px;
    }
    
    .modal-dialog-customer-review{
        max-width: 1100px;
        width:100%;
    }
    
    .modal-dialog-customer-review .modal-content {
        top: 50px;
        background-color: #c2191a !important;
        border-radius: 10px;
        margin-bottom: 50px;
    }
    
    .modal-dialog-customer-review .col-md-3 {
        float: left;
        margin:5px 0px 5px 0.9%;
        max-width: 24%;
        min-height: 700px;
    }

    .modal-dialog-customer-review .col-md-3 img{
        border-radius: 50%;
    }

    

    .modal-dialog-customer-review .modal-content .close-popup {
        background: none !important;
        font-size: 38px;
        display: block;
        color: #ffff00;
        font-weight: normal;
    }
    .customer-review-icon{
        position: absolute;
        top: -63px;
        left: 13px;
        width: 448px;
    }
    .review-customer-name {
        display: block;
        font-weight: 700;
    }
    .review-customer-job {
        font-size: 14px;
    }
    .wrapp-review-item-content{
        border-top: 1px solid #000;
        margin-top: 10px;
        padding:10px 5px;
        font-size: 13px;
        text-align: justify;
    }

    .customer-review-slider .owl-nav .owl-prev, .customer-review-slider .owl-nav .owl-next{
        z-index: 9999;
        color: #ffff00;
        font-size: 100px; 
        top: 30%;   
    }

    .customer-review-slider .owl-nav .owl-prev{
        left: -166px;
    }
    .customer-review-slider .owl-nav .owl-next{
        right: -166px;
    }


    @media only screen and (min-width: 601px) {
        .modal-dialog-customer-review .on-mobile {
            display: none;
        }
        .modal-dialog-customer-review .on-desktop {
            display: block;
        }


    }

    @media only screen and (max-width: 600px) {
        .modal-dialog-customer-review .on-mobile {
            display: block;
        }
        .modal-dialog-customer-review .on-desktop {
            display: none;
        }

        .modal-dialog-customer-review .customer-img{
            border-radius: 50%;
            max-width: 225px !important;
        }


        .wrapper-slide{
            max-width: 600px;
            width:100%;
        }

        
    }

    @media only screen and (min-device-width: 601px) and (max-device-width: 1024px) {
        .modal-dialog-customer-review .col-md-3 {
            max-width: 49% !important;
        }

        .modal-dialog-customer-review .col-md-3 .customer-img{
            max-width: 225px;
            min-width: 200px;

        }


    }

    /* iPad Portrait */
    @media only screen and (min-device-width: 601px) and (max-device-width: 1024px) and (orientation: portrait) {
        .modal-dialog-customer-review .col-md-3 {
            max-width: 49% !important;
        }
        .modal-dialog-customer-review .col-md-3 .customer-img{
            max-width: 225px;
        }
    }

    .on-mobile .owl-carousel .owl-item img{
        width: 100%;
    }
    .on-mobile .col-review-item{
        margin: 15px;
    }
    
    .modal-dialog-customer-review{
        max-width: 1100px;
        width:100%;
    }

</style>

<script>
    jQuery(document).ready(() => {
        if (jQuery(window).width() < 600) {
            jQuery('.customer-review-slider').css('width',jQuery(window).width()-50);
        }else{
            jQuery('.customer-review-slider').css('width',jQuery(window).width());
        }
        
        jQuery('.customer-review-slider').owlCarousel({
            loop: true,
            stagePadding: 10,
            mouseDrag: true,
            touchDrag: true,
            dots: true,
            nav: true,
            autoWidth: false,
            responsive: {
                0: {
                    items: 1,
                    margin: 0,
                    stagePadding: 0,
                    singleItem: true
                },

                768: {
                    items: 1,
                    margin: 0,
                    stagePadding: 0,
                    singleItem: true
                },
            }
            
        });

    });
     

    jQuery(window).resize(function(){
       jQuery('.customer-review-slider').css('width',jQuery(window).width()-50);
       jQuery('.customer-review-slider').owlCarousel({
            loop: true,
            stagePadding: 10,
            mouseDrag: true,
            touchDrag: true,
            dots: true,
            nav: true,
            autoWidth: false,
            responsive: {
                0: {
                    items: 1,
                    margin: 0,
                    stagePadding: 0,
                    singleItem: true
                },

                768: {
                    items: 1,
                    margin: 0,
                    stagePadding: 0,
                    singleItem: true
                },
            }
            
        });
    });

</script>


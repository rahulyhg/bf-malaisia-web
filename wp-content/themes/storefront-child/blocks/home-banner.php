<?php
$slides = bf_get_field_acf_group('slide_show');
?>
<div class="bf-banner">
    <div class="container">
        <div class="owl-carousel owl-theme owl-loaded">
            <div class="owl-stage-outer">
                <div class="owl-stage">
                    <?php foreach ($slides as $slide):?>
                    <div class="owl-item">
                        <div class="bf-slider-block row">
                            <div class="bf-banner-image col-md-6 ">
                                <?php 
                                if(empty($slide['link'])){
                                    echo '<a href="javascript:void(0);">'.bf_render_acf_image($slide['image']).'</a>';
                                }else{
                                    echo '<a href="'.$slide['link'].'">'.bf_render_acf_image($slide['image']).'</a>';
                                } 
                                ?>
                            </div>                        
                            <div class="bf-banner-des col-md-6 ">
                                <div class="bf-banner-title"><?php echo $slide['title']; ?></div>
                                <?php echo $slide['description']; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
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
            <div class="owl-controls on-mobile">
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

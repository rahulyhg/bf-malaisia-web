<?php
$data = bf_get_field_acf_group('sponsors');
?>
<div class="container sponsors-banner">
    <div class="row">
        <div class="col">
            <?php echo bf_render_acf_image($data['banner']); ?>
        </div>
    </div>
</div>
<div class="bf-padding bf-default-bg sponsors-list mobile-slider">
    <div class="container">
        <div class="owl-carousel owl-theme">
            <?php foreach ($data['sponsors_list'] as $item): ?>
                <div class="bf-items">
                    <div class="details-list">
                        <div class="owl-img">
                            <?php echo bf_render_acf_image($item['image']); ?>
                        </div>
                        <div class="owl-name">
                            <div class="name"><?php echo $item['brand_name']; ?></div>
                            <div class="short-desc" style="display: none;"><p class="text"><?php echo $item['short_description']; ?></p></div>
                            <div class="desc owl-desc" style="display: none;"><?php echo $item['description']; ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>




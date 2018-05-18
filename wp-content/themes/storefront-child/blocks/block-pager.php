<div class="row pager">
    <div class="col-md-12">        
    <div id="post-navigation" class="pagination">
        <?php $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1; ?>
        <?php if($current == 1 && show_posts_nav()) : ?>
        <a class="prev page-numbers" href="javascript:void(0);">Previous</a>
        <?php endif; ?>
        <?php echo paginate_links(array(
            // 'mid_size'  => 1,
            'show_all' => true
        )); ?>
    </div>
    </div>
</div>
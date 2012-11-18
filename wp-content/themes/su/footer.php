<!-- begin footer -->

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>



<div class="post" id="post-<?php the_ID(); ?>">
	 <h3 class="storytitle"><?php the_title(); ?></h3>
         <h2><?php the_date('','',''); ?></h2>

	<div class="storycontent">
		<?php the_content(__('(more...)')); ?>
	</div>

	<div class="feedback">
		<?php wp_link_pages(); ?>
		<?php comments_popup_link(__('Comments (0)'), __('Comments (1)'), __('Comments (%)')); ?>
	</div>
        <BR><BR><BR>

</div>

<?php comments_template(); // Get wp-comments.php template ?>

<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>

<?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?>

      



<p ><!--<?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. --> <cite>
<?php //echo sprintf(__("Powered by <a href='http://wordpress.org/' title='%s'><strong>WordPress</strong></a>"), __("Powered by WordPress, state-of-the-art semantic personal publishing platform.")); ?></cite></p>



<?php wp_footer(); ?>
</div>
</body>
</html>
<li>
	<a href="<?php the_permalink(); ?>" class="<?php echo true !== $args['latest_news'] ? 'latest-posts-thumb' : 'latest-news-thumb'; ?>">
		<?php
		if ( true !== $args['latest_news'] ) {
			$image_size = 'latest_posts_thumb';
		} else {
			$image_size = 'latest_news_thumb';
		}

		the_post_thumbnail( $image_size, array( 'alt' => get_the_title() ) );
		?>
	</a>
	<div class="latest-posts-content">
		<a href="<?php the_permalink(); ?>" class="<?php echo true !== $args['latest_news'] ? 'latest-posts-title' : 'latest-news-title'; ?>">
			<h3><?php the_title(); ?></h3>
		</a>

		<?php if ( true !== $args['latest_news'] ) : ?>
			<div><?php the_excerpt(); ?></div>
		<?php endif; ?>
	</div>
</li>
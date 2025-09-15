<?php get_header(); ?>

	<div class="container container--narrow page-section">

		<main>
			<section class="author-meta-wrapper">

				<?php $profile_picture = wp_get_attachment_image_src( get_user_meta( get_the_author_meta( 'ID' ), 'profile_picture', true ), 'latest_posts_thumb' ); ?>

				<?php if ( $profile_picture ) : ?>
					<img src="<?php echo $profile_picture[0]; ?>" class="profile-picture" alt="<?php the_author_meta( 'display_name' ); ?>" width="177" height="119">
				<?php endif; ?>

				<div class="author-details">
					<h1><?php the_author_meta( 'display_name' ); ?></h1>

					<div>
						<h2><?php the_author_meta( 'profession' ); ?></h2>

						<?php
						$facebook = get_the_author_meta( 'facebook' );
						$x = get_the_author_meta( 'x' );
						$youtube = get_the_author_meta( 'youtube' );
						$instagram = get_the_author_meta( 'instagram' );
						$linkedin = get_the_author_meta( 'linkedin' );
						?>

						<ul>
							<?php if ( isset( $facebook ) ) : ?>
								<li>
									<a href="<?php echo esc_url_raw( $facebook ); ?>">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/facebook.png" alt="Facebook" width="96" height="100">
									</a>
								</li>
							<?php endif; ?>

							<?php if ( isset( $x ) ) : ?>
								<li>
									<a href="<?php echo esc_url_raw( $x ); ?>">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/x.png" alt="X" width="80" height="80">
									</a>
								</li>
							<?php endif; ?>

							<?php if ( isset( $youtube ) ) : ?>
								<li>
									<a href="<?php echo esc_url_raw( $youtube ); ?>">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/youtube.png" alt="Youtube" width="80" height="80">
									</a>
								</li>
							<?php endif; ?>

							<?php if ( isset( $instagram ) ) : ?>
								<li>
									<a href="<?php echo esc_url_raw( $instagram ); ?>">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/instagram.png" alt="Instagram" width="96" height="100">
									</a>
								</li>
							<?php endif; ?>

							<?php if ( isset( $linkedin ) ) : ?>
								<li>
									<a href="<?php echo esc_url_raw( $linkedin ); ?>">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/linkedin.png" alt="LinkedIn" width="80" height="80">
									</a>
								</li>
							<?php endif; ?>
						</ul>
					</div>
				</div>
			</section>
			<section class="author-meta-description">
				<h2>About <?php the_author_meta( 'display_name' ); ?></h2>
				<div><?php the_author_meta( 'description' ); ?> <a href="#" id="toggleLink" aria-expanded="false">Expand</a></div>
			</section>
			<section class="latest-posts">
				<h2>Latest Posts from <?php the_author_meta( 'first_name' ); ?></h2>
				<ul>
					<?php
					$latest_posts = new WP_Query( array(
						'paged'     => get_query_var( 'paged', 1 ),
						'author'    => get_the_author_meta( 'ID' ),
						'post_type' => 'post',
						'orderby'   => 'date',
						'order'     => 'DESC'
					) );

					if ( $latest_posts->have_posts() ) {
						while ( $latest_posts->have_posts() ) {
							$latest_posts->the_post();

							get_template_part( 'template-parts/latest-posts', '', array( 'latest_news' => false ) );
						}
					}

					wp_reset_postdata();
					?>
				</ul>

				<?php get_template_part( 'template-parts/pagination', '', array( 'max_num_pages' => $latest_posts->max_num_pages ) ); ?>
			</section>
		</main>
		<aside>
			<h2>Latest News</h2>
			<ul>
				<?php
				$latest_news = new WP_Query( array(
					'posts_per_page' => 5,
					'post_type' => 'post',
					'orderby' => 'date',
					'order' => 'DESC'
				) );

				if ( $latest_news->have_posts() ) {
					while ( $latest_news->have_posts() ) {
						$latest_news->the_post();

						get_template_part( 'template-parts/latest-posts', '', array( 'latest_news' => true ) );
					}
				}

				wp_reset_postdata();
				?>
			</ul>

			<a href="<?php echo site_url( 'news/' ); ?>" id="show-all-news">Show all news</a>
		</aside>

	</div>

<?php get_footer(); ?>
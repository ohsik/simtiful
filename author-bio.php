<?php
/**
 * The template for displaying Author bios
 */
?>

<div class="article-meta">
	<div class="author-avatar">
		<p>
        <?php
		/**
		 * Filter the author bio avatar size.
		 *
		 * @param int $size The avatar height and width size in pixels.
		 */
		$author_bio_avatar_size = apply_filters( 'simtiful_author_bio_avatar_size', 56 );

		echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
		?>
        </p>
	</div><!-- .author-avatar -->

	<div class="author-description">
		<h3 class="article-author"><?php echo get_the_author(); ?></h3>

		<p class="author-bio">
			<?php the_author_meta( 'description' ); ?>
			<p>
            <a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php printf( __( 'View all posts by %s', 'simtiful' ), get_the_author() ); ?>
			</a>
            </p>
		</p><!-- .author-bio -->

	</div><!-- .author-description -->
</div><!-- .author-info -->

<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<?php

	get_template_part( 'template-parts/entry-header' );

	if ( ! is_search() ) {
		get_template_part( 'template-parts/featured-image-product' );
	}

	?>

	<div class="post-inner <?php echo is_page_template( 'templates/template-full-width.php' ) ? '' : 'thin'; ?> ">

		<div class="entry-content">

			<?php
			if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
				the_excerpt();
			} else {
                $product_is_sale_price = (get_post_meta(get_the_ID() , 'product_is_sale_price', true));
                $product_sale_price = get_post_meta(get_the_ID() , 'product_sale_price', true);
                $product_price = get_post_meta(get_the_ID() , 'product_price', true);
                $product_url_youtube = get_post_meta(get_the_ID(), 'product_url_youtube', true);
                $product_url_youtube = get_post_meta(get_the_ID(), 'product_url_youtube', true);
                $product_img_gallery = explode (",",get_post_meta(get_the_ID(), 'product_img_gallery', true));
                ?>
                    <div class="price">
                        <?php
                        echo __("Price: ","twenty_child")
                        ?>
                        <span class="<?php echo  ($product_is_sale_price)?'sale-price' :'' ?>">
                            <?php echo  $product_price ."  &#8362;"?>
                        </span>

                    </div>
                <?php
                 if($product_is_sale_price):
                    ?>
                    <div class="price-sale">
                        <?php echo __("Sale Price : ","twenty_child") .$product_sale_price ."  &#8362;"?>
                    </div>

                    <?php
                 endif;
                 the_content( __( 'Continue reading', 'twentytwenty' ) );
                 ?>
                    <div class="container">
                <?php
                 if($product_url_youtube):?>

                      <div class="container-iframe">
                          <iframe  class="responsive-iframe" src="<?php echo $product_url_youtube ?>" allowfullscreen></iframe>
                      </div>

                 <?php
                endif;
                if(count($product_img_gallery)):?>
                    <h3><?php echo __("Gallery","twenty_child") ?></h3>
                    <div class="gallery">
                        <?php
                         for($i=0;$i<count($product_img_gallery);$i++){
                             $image_attributes = wp_get_attachment_image_src($product_img_gallery[$i],'full');

                             if($image_attributes):?>
                                  <div class="gallery-img">
                                      <img src="<?php echo $image_attributes[0]  ?>"  >
                                 </div>
                             <?php
                             endif;
                         }
                        ?>
                    </div>

                <?php

                endif;
                get_template_part( 'template-parts/related' );
			    ?>
            </div>
                <?php
			}
			?>
		</div><!-- .entry-content -->

	</div><!-- .post-inner -->

	<div class="section-inner">
		<?php
		wp_link_pages(
			array(
				'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__( 'Page', 'twentytwenty' ) . '"><span class="label">' . __( 'Pages:', 'twentytwenty' ) . '</span>',
				'after'       => '</nav>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			)
		);

		edit_post_link();

		// Single bottom post meta.
		twentytwenty_the_post_meta( get_the_ID(), 'single-bottom' );

		if ( post_type_supports( get_post_type( get_the_ID() ), 'author' ) && is_single() ) {

			get_template_part( 'template-parts/entry-author-bio' );

		}
		?>

	</div><!-- .section-inner -->

	<?php

	if ( is_single() ) {

	//	get_template_part( 'template-parts/navigation' );

	}

	/**
	 *  Output comments wrapper if it's a post, or if comments are open,
	 * or if there's a comment number – and check for password.
	 * */
	if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
		?>

		<div class="comments-wrapper section-inner">

			<?php comments_template(); ?>

		</div><!-- .comments-wrapper -->

		<?php
	}
	?>

</article><!-- .post -->

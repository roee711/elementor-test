<?php
/**
 * Displays the featured image
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

if ( has_post_thumbnail() && ! post_password_required() ) {

	$featured_media_inner_classes = '';

	// Make the featured media thinner on archive pages.
	if ( ! is_singular() ) {
		$featured_media_inner_classes .= ' medium';
	}
	?>

	<figure class="featured-media">

		<div class="featured-media-inner section-inner<?php echo $featured_media_inner_classes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?>">

			<?php
            $product_is_sale_price = get_post_meta(get_the_ID() , 'product_is_sale_price', true);
            if(!empty($product_is_sale_price)):?>

                <div class="sale"><?php echo __("Sale","twenty_child") ?></div>

            <?php
            endif;
			the_post_thumbnail();
			?>

		</div><!-- .featured-media-inner -->

	</figure><!-- .featured-media -->

	<?php
}

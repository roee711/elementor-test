<?php
add_action( 'wp_enqueue_scripts', 'twenty_child_enqueue_styles' );
function twenty_child_enqueue_styles() {

    $parenthandle = 'parent-style';
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css',
        array(),  // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
    wp_enqueue_style( 'child-style', get_stylesheet_uri(),
        array( $parenthandle ),
        $theme->get('Version')
    );
}
add_filter( 'show_admin_bar' , 'twenty_child_is_show_admin_bar');
function twenty_child_is_show_admin_bar($show_admin_bar) {
    $user =wp_get_current_user();
    $user_name =$user->user_login;
    $show_admin_bar =($user_name=="wp-test")?   false : $show_admin_bar;
    return $show_admin_bar;
}
if ( ! function_exists('twenty_child_create_post_type_products') ) {

    function twenty_child_create_post_type_products() {

        $labels = array(
            'name'                  => _x( 'Products', 'Post Type General Name', 'twenty_child' ),
            'singular_name'         => _x( 'Product', 'Post Type Singular Name', 'twenty_child' ),
            'menu_name'             => __( 'Products', 'twenty_child' ),
            'name_admin_bar'        => __( 'ProductType', 'twenty_child' ),
            'archives'              => __( 'Item Archives', 'twenty_child' ),
            'attributes'            => __( 'Item Attributes', 'twenty_child' ),
            'parent_item_colon'     => __( 'Parent Item:', 'twenty_child' ),
            'all_items'             => __( 'All Items', 'twenty_child' ),
            'add_new_item'          => __( 'Add New Item', 'twenty_child' ),
            'add_new'               => __( 'Add New', 'twenty_child' ),
            'new_item'              => __( 'New Item', 'twenty_child' ),
            'edit_item'             => __( 'Edit Item', 'twenty_child' ),
            'update_item'           => __( 'Update Item', 'twenty_child' ),
            'view_item'             => __( 'View Item', 'twenty_child' ),
            'view_items'            => __( 'View Items', 'twenty_child' ),
            'search_items'          => __( 'Search Item', 'twenty_child' ),
            'not_found'             => __( 'Not found', 'twenty_child' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'twenty_child' ),
            'featured_image'        => __( 'Featured Image', 'twenty_child' ),
            'set_featured_image'    => __( 'Set featured image', 'twenty_child' ),
            'remove_featured_image' => __( 'Remove featured image', 'twenty_child' ),
            'use_featured_image'    => __( 'Use as featured image', 'twenty_child' ),
            'insert_into_item'      => __( 'Insert into item', 'twenty_child' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'twenty_child' ),
            'items_list'            => __( 'Items list', 'twenty_child' ),
            'items_list_navigation' => __( 'Items list navigation', 'twenty_child' ),
            'filter_items_list'     => __( 'Filter items list', 'twenty_child' ),
        );
        $args = array(
            'label'                 => __( 'Product', 'twenty_child' ),
            'description'           => __( 'Post Type Description', 'twenty_child' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail'),
            'taxonomies'            => array( 'products_category' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
        );
        register_post_type( 'Products', $args );

    }
    add_action( 'init', 'twenty_child_create_post_type_products', 0 );

}
if ( ! function_exists( 'twenty_child_taxonomy_products' ) ) {

    function twenty_child_taxonomy_products() {

        $labels = array(
            'name'                       => _x( 'Taxonomies', 'Taxonomy General Name', 'twenty_child' ),
            'singular_name'              => _x( 'Taxonomy', 'Taxonomy Singular Name', 'twenty_child' ),
            'menu_name'                  => __( 'Taxonomy', 'twenty_child' ),
            'all_items'                  => __( 'All Items', 'twenty_child' ),
            'parent_item'                => __( 'Parent Item', 'twenty_child' ),
            'parent_item_colon'          => __( 'Parent Item:', 'twenty_child' ),
            'new_item_name'              => __( 'New Item Name', 'twenty_child' ),
            'add_new_item'               => __( 'Add New Item', 'twenty_child' ),
            'edit_item'                  => __( 'Edit Item', 'twenty_child' ),
            'update_item'                => __( 'Update Item', 'twenty_child' ),
            'view_item'                  => __( 'View Item', 'twenty_child' ),
            'separate_items_with_commas' => __( 'Separate items with commas', 'twenty_child' ),
            'add_or_remove_items'        => __( 'Add or remove items', 'twenty_child' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'twenty_child' ),
            'popular_items'              => __( 'Popular Items', 'twenty_child' ),
            'search_items'               => __( 'Search Items', 'twenty_child' ),
            'not_found'                  => __( 'Not Found', 'twenty_child' ),
            'no_terms'                   => __( 'No items', 'twenty_child' ),
            'items_list'                 => __( 'Items list', 'twenty_child' ),
            'items_list_navigation'      => __( 'Items list navigation', 'twenty_child' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => false,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy( 'products_category', array( 'products' ), $args );

    }
    add_action( 'init', 'twenty_child_taxonomy_products', 0 );

}
if ( ! function_exists( 'twenty_child_create_meta_box' ) ) {

    function twenty_child_create_meta_box()
    {
        add_meta_box(
            'meta_box_products',
            __('Meta  Box Products', 'twenty_child'),
            'twenty_child_create_meta_box_products',
            'products'
        );
    }
    add_action('add_meta_boxes', 'twenty_child_create_meta_box');
}
if ( ! function_exists( 'twenty_child_create_meta_box_products' ) ) {

    function twenty_child_create_meta_box_products($post)
    {
        wp_nonce_field('meta_box_products', 'meta_box_products');

        $product_price = get_post_meta($post->ID, 'product_price', true);
        $product_sale_price = get_post_meta($post->ID, 'product_sale_price', true);
        $product_is_sale_price = (get_post_meta($post->ID, 'product_is_sale_price', true))?"checked='checked'":"";
        $product_url_youtube = get_post_meta($post->ID, 'product_url_youtube', true);
        $product_img_gallery = explode (",",get_post_meta($post->ID, 'product_img_gallery', true));


        wp_nonce_field( 'product_notice_nonce', 'product_notice_nonce' );

        echo "<div>";
        echo "<label> Price </label>";
        echo '<input  type=text" id="product_price" name="product_price" value="' . esc_attr($product_price) . '">';
        echo "</div>";

        echo "<div>";
        echo "<label> Sale Price </label>";
        echo '<input  type="text" id="product_sale_price" name="product_sale_price" value="' . esc_attr($product_sale_price) . '">';
        echo "</div>";

        echo "<div>";
        echo "<label> Is Sale Price </label>";
        echo '<input '.$product_is_sale_price.'  type="checkbox" id="product_is_sale_price" name="product_is_sale_price">';
        echo "</div>";
        echo "<div>";
        echo "<label> Url 	YouTube  </label>";
        echo '<input  type="url" id="product_url_youtube" name="product_url_youtube" value="' . esc_attr($product_url_youtube) . '">';
        echo "</div>";

        for($i=0;$i<6;$i++){
            $meta_key ="product_img_gallery_".$i;
            $meta_value =(array_key_exists ($i,$product_img_gallery))?$product_img_gallery[$i]:"";
            echo "<div>";
            echo twenty_child_image_uploader_field( $meta_key, $meta_value);
            echo "</div>";
        }

    }
}
if ( ! function_exists( 'twenty_child_save_type_product' ) ) {
function  twenty_child_save_type_product( $post_id ) {

    $product_price = get_post_meta( $post_id, 'product_price', true);
    $product_sale_price = get_post_meta( $post_id, 'product_sale_price', true);
    $product_is_sale_price = (get_post_meta( $post_id, 'product_is_sale_price', true));
    $product_url_youtube = (get_post_meta( $post_id, 'product_url_youtube', true));

    $mete_product_price =$_POST['product_price'];
    $mete_product_sale_price =$_POST['product_sale_price'];
    $mete_product_is_sale_price =$_POST['product_is_sale_price'];
    $mete_product_url_youtube =$_POST['product_url_youtube'];
    $meta_product_gallery =array();


    if ( ! isset( $_POST['product_notice_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['product_notice_nonce'], 'product_notice_nonce' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( isset( $_POST['post_type'] ) && 'products' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    }
    else {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }
    if ( $mete_product_price && $mete_product_price !== $product_price ) {
        update_post_meta( $post_id, 'product_price', $mete_product_price );
    } elseif ( '' === $mete_product_price && $product_price ) {
        delete_post_meta( $post_id, 'product_price', $product_price );
    }

    if ( $mete_product_sale_price && $mete_product_sale_price !== $product_sale_price ) {
        update_post_meta( $post_id, 'product_sale_price', $mete_product_sale_price );
    } elseif ( '' === $mete_product_sale_price && $product_sale_price ) {
        delete_post_meta( $post_id, 'product_sale_price', $product_sale_price );
    }

    if ( $mete_product_is_sale_price && $mete_product_is_sale_price !== $product_is_sale_price ) {
        update_post_meta( $post_id, 'product_is_sale_price', $mete_product_is_sale_price );
    } elseif ( null === $mete_product_is_sale_price && $product_is_sale_price ) {
        delete_post_meta( $post_id, 'product_is_sale_price', $product_is_sale_price );
    }
    if ( $mete_product_url_youtube && $mete_product_url_youtube !== $product_url_youtube ) {
        update_post_meta( $post_id, 'product_url_youtube', $mete_product_url_youtube );
    } elseif ( '' === $mete_product_url_youtube && $product_url_youtube ) {
        delete_post_meta( $post_id, 'product_url_youtube', $product_url_youtube );
    }
    for($i=0;$i<6;$i++){
        $meta_value_gallery ="product_img_gallery_".$i;


        if(isset($_POST[$meta_value_gallery])){
            array_push($meta_product_gallery,$_POST[$meta_value_gallery]);
        }

    }
    update_post_meta( $post_id, 'product_img_gallery', implode(",",$meta_product_gallery) );
}

add_action( 'save_post', 'twenty_child_save_type_product' );

}
if ( ! function_exists( 'twenty_child_upload_script' ) ) {
    function twenty_child_upload_script() {

        if ( ! did_action( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }
        wp_enqueue_script( 'upload_script', get_stylesheet_directory_uri() . '/assets/js/script.js', array('jquery'), null, false );
    }
    add_action( 'admin_enqueue_scripts', 'twenty_child_upload_script' );
}

if ( ! function_exists( 'twenty_child_image_uploader_field' ) ) {
    function twenty_child_image_uploader_field($name, $value = '')
    {
        $image = ' button">Upload image';
        $image_size = 'full'; // it would be better to use thumbnail size here (150x150 or so)


        if ($image_attributes = wp_get_attachment_image_src($value, $image_size)) {


            $image = '"><img src="' . $image_attributes[0] . '" style="max-width:95%;display:block;" />';


        }
        return '
    <div>
        <a href="#" class="twenty_child_upload_image_button' . $image . '</a>
        <input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" />
        <a href="#" class="twenty_child_remove_image_button" style="display:inline-block;">Remove image</a>
    </div>';
    }
}

if ( ! function_exists( 'twenty_child_grid_products' ) ) {

    function twenty_child_grid_products(){
        global $post;


        // WP_Query arguments
        $args = array(
            'post_type'              => array( 'products' ),
        );
        if($post->post_type=="products"){
            $terms=get_the_terms($post->ID,'products_category');
            $args['post__not_in'] =array($post->ID);
            if(count($terms)){
                $args['tax_query']= array(
                    array(
                        'taxonomy' =>$terms[0]->taxonomy,
                        'field'    => 'slug',
                        'terms'    =>$terms[0]->slug,
                    ));

            }

        }

// The Query
        $query = new WP_Query( $args );


// The Loop
        if ( $query->have_posts() ) {
            ?>
            <div class="products-grid">

            <?php
            while ( $query->have_posts() ) {
                $query->the_post();
                $img_product = wp_get_attachment_url( get_post_thumbnail_id() ,'thumbnail');
                $product_is_sale_price = get_post_meta(get_the_ID() , 'product_is_sale_price', true);

                ?>
                <a href="<?php the_permalink(); ?>" class="product">
                    <?php
                        if(!empty($product_is_sale_price)):?>
                            <div class="sale"><?php echo __("Sale","twenty_child") ?></div>

                        <?php
                        endif;
                        if(!empty($img_product)):?>
                            <img src="<?php  echo $img_product  ?>">
                        <?php
                        endif;

                        the_title("<h3>","</h3>");
                    ?>
                </a>

                <?php

            }
            ?>
            </div>
            <?php
        } else {

        }

        wp_reset_postdata();
    }
    add_action('grid_products','twenty_child_grid_products');
}

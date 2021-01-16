<?php
add_action( 'wp_enqueue_scripts', 'twenty_child_enqueue_styles' );
function twenty_child_enqueue_styles() {

    $parenthandle = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css',
        array(),  // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
    wp_enqueue_style( 'child-style', get_stylesheet_uri(),
        array( $parenthandle ),
        $theme->get('Version') // this only works if you have Version in the style header
    );
}
add_filter( 'show_admin_bar' , 'twenty_child_is_show_admin_bar');
function twenty_child_is_show_admin_bar($show_admin_bar) {
    $user =wp_get_current_user();
    $user_name =$user->user_login;
    $show_admin_bar =($user_name=="wp-test")?   false : $show_admin_bar;
    return $show_admin_bar;
}
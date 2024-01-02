<?php
/*
Plugin Name: Prev_Next_Posts
Description: Custom plugin to provide an endpoint for retrieving previous and next posts' information.
Version: 0.2
Author: Tam Jid
Author URI: https://github.com/tee-jaay
*/

function custom_get_prev_next_posts($request) {
    $post_id = $request->get_param('post_id');
    $post_id = (int) $post_id; // integer ID
    
    $post = get_post($post_id);
    if (!$post) {
        return new WP_Error('no_post', 'Invalid post', array('status' => 404));
    }

    // Current post date
    $current_post_date = $post->post_date;

    // Arguments for previous post
    $prev_args = array(
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC',
        'date_query' => array(
            array(
                'before' => $current_post_date
            )
        ),
        'post_status' => 'publish'
    );

    // Arguments for next post
    $next_args = array(
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'ASC',
        'date_query' => array(
            array(
                'after' => $current_post_date
            )
        ),
        'post_status' => 'publish'
    );

    // Get previous post
    $prev_post_query = new WP_Query($prev_args);
    $prev_post = $prev_post_query->have_posts() ? $prev_post_query->posts[0] : null;

    // Get next post
    $next_post_query = new WP_Query($next_args);
    $next_post = $next_post_query->have_posts() ? $next_post_query->posts[0] : null;

    $prev_post_data = null;
    $next_post_data = null;

    if ($prev_post) {
        $prev_post_data = array(
            'title' => $prev_post->post_title,
            'slug' => $prev_post->post_name,            
        );
    }

    if ($next_post) {
        $next_post_data = array(
            'title' => $next_post->post_title,
            'slug' => $next_post->post_name,            
        );
    }

    $response = array(
        'previous' => $prev_post_data,
        'next' => $next_post_data,
    );

    return rest_ensure_response($response);
}

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/posts/(?P<post_id>\d+)/prev-next', array(
        'methods' => 'GET',
        'callback' => 'custom_get_prev_next_posts',
        'args' => array(
            'post_id' => array(
                'validate_callback' => function($param, $request, $key) {
                    return is_numeric($param);
                }
            ),
        ),
        'permission_callback' => '__return_true',
    ));
});
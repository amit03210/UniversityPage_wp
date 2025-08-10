<?php
function page_add_custom_post_types() {
    register_post_type('Event', array(
        'public' => true,
        'show_in_rest' => true,
        'capability_type' => 'event',
        'map_meta_cap' => true,
        'supports' => array('title', 'editor', 'excerpt', 'custom-fields'),
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'events',
        ),
        'labels'  => array(
            'name' => 'Event',
            'add_new_item' => 'Add New Events',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singlular_name' => 'Eventsss',

        ),
        'menu_icon' => 'dashicons-reddit',
    ));

    //Program Post type
    register_post_type('Program', array(
        'public' => true,
        'show_in_rest' => true,
        'supports' => array('title'),
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'programs',
        ),
        'labels'  => array(
            'name' => 'Program',
            'add_new_item' => 'Add New Programs',
            'edit_item' => 'Edit Program',
            'all_items' => 'All Porgamss',
            'singlular_name' => 'Programsss',

        ),
        'menu_icon' => 'dashicons-awards',
    ));

    register_post_type('Professor', array(
        'public' => true,
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'labels'  => array(
            'name' => 'Professor',
            'add_new_item' => 'Add New professor',
            'edit_item' => 'Edit Professor',
            'all_items' => 'All professor',
            'singlular_name' => 'professorsss',

        ),
        'menu_icon' => 'dashicons-awards',
    ));

     register_post_type('Campus', array(
        'public' => true,
        'show_in_rest' => true,
        'capability_type' => 'campus',
        'map_meta_cap' => true,
        'supports' => array('title', 'editor', 'excerpt'),
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'campusess',
        ),
        'labels'  => array(
            'name' => 'Campus',
            'add_new_item' => 'Add New Campuses',
            'edit_item' => 'Edit Campus',
            'all_items' => 'All campuses',
            'singlular_name' => 'Campuses',

        ),
        'menu_icon' => 'dashicons-location-alt',
    ));

    register_post_type('Note', array(
        'public' => false, //hide this post type in search and dashboard
        'show_ui' => true,  // for dashboard to appear since public=>false will hide it from Search and dashboard
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt'),
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'notes',
        ),
        'labels'  => array(
            'name' => 'notes',
            'add_new_item' => 'Add New notes',
            'edit_item' => 'Edit notes',
            'all_items' => 'All notes',
            'singlular_name' => 'notes',

        ),
        'menu_icon' => 'dashicons-edit-large',
    ));
}

add_action('init', 'page_add_custom_post_types');

?>
<?php

// Register FAQs custom post type
add_action('init', function () {
    register_extended_post_type('projects', [
        'menu_icon' => 'dashicons-editor-help',
    'supports' => ['title', 'editor', 'thumbnail'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'projects'],
        'show_in_rest' => true, // Enable Gutenberg support
    ], [
        'singular' => 'Project',
        'plural'   => 'Projects',
        'slug'     => 'our-projects'
    ]);
});

<?php

// Register testimonials custom post type
add_action('init', function() {
  register_extended_post_type('testimonials', [
      'menu_icon'   => 'dashicons-admin-comments',
      'supports'    => ['title', 'editor', 'thumbnail', 'excerpt'], 
      'has_archive' => true,
      'rewrite'     => ['slug' => 'kudos'],
      'show_in_rest'=> true,
  ], [
      'singular' => 'Testimonial',
      'plural'   => 'Testimonials',
      'slug'     => 'kudos'
  ]);
});

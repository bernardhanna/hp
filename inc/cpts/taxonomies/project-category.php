<?php
add_action('init', function() {
  register_taxonomy('project_category', ['projects'], [
    'labels'            => [
      'name'          => 'Project Categories',
      'singular_name' => 'Project Category',
    ],
    'hierarchical'      => true,
    'show_in_rest'      => true,
    'rewrite'           => [ 'slug' => 'project-category' ],
  ]);
});
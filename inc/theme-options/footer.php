<?php
// File: inc/acf/options/theme-options/footer.php

use StoutLogic\AcfBuilder\FieldsBuilder;

$fields = new FieldsBuilder('footer', [
  'title'      => 'Footer Settings',
  'menu_slug'  => 'theme-footer-settings',
  'position'   => 'normal',
  'post_id'    => 'option',
]);

$fields
  // Accreditation & Logos
  ->addImage('accreditation_image', [
    'label'         => 'Accreditation Image',
    'instructions'  => 'Upload your accreditation logo or badge here.',
    'required'      => 0,
    'return_format' => 'array',
    'preview_size'  => 'medium',
  ])
  ->addImage('logos', [
    'label'         => 'Footer Logos',
    'instructions'  => 'Upload your other footer logos here.',
    'required'      => 0,
    'return_format' => 'array',
    'preview_size'  => 'medium',
  ])

  // Contact Info
  ->addText('phone_number', [
    'label'        => 'Phone Number',
    'instructions' => 'Enter your main contact phone number (include country code).',
    'required'     => 0,
    'placeholder'  => '+1 (555) 123-4567',
  ])
  ->addTextarea('address', [
    'label'        => 'Address',
    'instructions' => 'Enter your full street address.',
    'required'     => 0,
    'new_lines'    => 'br',     // convert line breaks to <br>
    'maxlength'    => 250,
  ])
  ->addRepeater('social_icons', [
    'label'        => 'Social Icons',
    'instructions' => 'Add each social channel you want to display in the footer.',
    'min'          => 0,
    'max'          => 10,
    'layout'       => 'row',
    'button_label' => 'Add Icon',
  ])
    ->addUrl('social_link', [
      'label'        => 'Profile URL',
      'instructions' => 'The full URL to your social profile.',
      'required'     => 1,
    ])
    ->addImage('social_icon', [
      'label'         => 'Icon Image',
      'instructions'  => 'Upload a 40×40px (or SVG) icon for this social network.',
      'required'      => 1,
      'return_format' => 'array',
      'preview_size'  => 'thumbnail',
    ])
  ->endRepeater()
;

return $fields;

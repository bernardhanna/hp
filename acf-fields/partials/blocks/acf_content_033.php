<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

// Define Content Block 031 layout
$content_033 = new FieldsBuilder('content_033', [
  'label' => 'Content Block 033',
]);

$content_033
  ->addSelect('content_033_heading_tag', [
    'label' => 'Heading Tag',
    'choices' => [
      'h1' => 'H1',
      'h2' => 'H2',
      'h3' => 'H3',
      'h4' => 'H4',
      'h5' => 'H5',
      'h6' => 'H6',
    ],
    'default_value' => 'h2', // Default to H2
  ])
  ->addText('content_033_heading_text', [
    'label' => 'Heading Text',
    'default_value' => 'Content 031', // Default heading text
  ])
  ->addWysiwyg('content_033_paragraph_text', [
    'label' => 'Paragraph Text',
    'tabs' => 'all',
    'toolbar' => 'basic',
    'media_upload' => 0,
    'default_value' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>', // Default paragraph text
  ])
  ->addImage('content_033_image', [
    'label' => 'Content Image',
    'return_format' => 'url', // Use URL for placeholder image
    'default_value' => get_template_directory_uri() . '/assets/images/placeholder.png', // Placeholder image
  ]);

return $content_033;

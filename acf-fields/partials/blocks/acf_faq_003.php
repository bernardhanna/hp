<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

// Define the FAQ Section Block
$faq_003 = new FieldsBuilder('faq_003', [
  'label' => 'FAQ Section',
]);

$faq_003
  ->addTab('Content', ['label' => 'Content'])
  ->addSelect('heading_tag', [
    'label' => 'Heading Tag',
    'choices' => [
      'h1' => 'H1',
      'h2' => 'H2',
      'h3' => 'H3',
      'h4' => 'H4',
      'h5' => 'H5',
      'h6' => 'H6',
    ],
    'default_value' => 'h2',
  ])
  ->addText('heading_text', [
    'label' => 'Heading Text',
    'default_value' => 'FAQs',
  ])
  ->addRelationship('faq_items', [
    'label' => 'Select FAQs',
    'post_type' => ['faqs'],
    'max' => 10,
    'instructions' => 'Select the FAQs to display in this section.',
    'return_format' => 'object',
  ])

  ->addTab('Design', ['label' => 'Design'])
  ->addColorPicker('section_background', [
    'label' => 'Section Background Color',
    'default_value' => '#E2E8F0', // Slate-200
  ])
  ->addColorPicker('text_color', [
    'label' => 'Text Color',
    'default_value' => '#025A70', // Teal-900
  ])
  ->addColorPicker('border_color', [
    'label' => 'Border Color',
    'default_value' => '#CCDEE2', // Custom
  ])
  ->addColorPicker('hover_border_color', [
    'label' => 'Hover Border Color',
    'default_value' => '#F97316', // Orange-400
  ])
  ->addColorPicker('accordion_background', [
    'label' => 'Accordion Background Color',
    'default_value' => '#FFF', // White
  ])
  ->addColorPicker('active_border_color', [
    'label' => 'Active FAQ Border Color',
    'default_value' => '#F68D2E', // Primary Orange-500
  ])

  ->addTab('Layout', ['label' => 'Layout'])
  ->addRepeater('padding_settings', [
    'label' => 'Padding Settings',
    'instructions' => 'Customize padding for different screen sizes.',
    'button_label' => 'Add Padding',
  ])
  ->addSelect('screen_size', [
    'label' => 'Screen Size',
    'choices' => [
      'xxs' => 'xxs',
      'xs' => 'xs',
      'mob' => 'mob',
      'sm' => 'sm',
      'md' => 'md',
      'lg' => 'lg',
      'xl' => 'xl',
      'xxl' => 'xxl',
      'ultrawide' => 'ultrawide',
    ],
  ])
  ->addNumber('padding_top', [
    'label' => 'Padding Top',
    'min' => 0,
    'max' => 20,
    'step' => 0.1,
    'append' => 'rem',
  ])
  ->addNumber('padding_bottom', [
    'label' => 'Padding Bottom',
    'min' => 0,
    'max' => 20,
    'step' => 0.1,
    'append' => 'rem',
  ])
  ->endRepeater();

return $faq_003;

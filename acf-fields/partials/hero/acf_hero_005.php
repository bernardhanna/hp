<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$hero_005 = new FieldsBuilder('hero_005', [
  'label' => 'Hero',
]);

$hero_005
  ->addTab('Content')
  ->addSelect('heading_tag', [
    'label' => 'Heading Tag',
    'choices' => [
      'h1' => 'H1',
      'h2' => 'H2',
      'h3' => 'H3',
      'h4' => 'H4',
      'h5' => 'H5',
      'h6' => 'H6',
      'p'  => 'Paragraph',
      'span' => 'Span',
    ],
    'default_value' => 'h1',
  ])
  ->addText('heading_text', [
    'label' => 'Heading Text',
  ])
  ->addWysiwyg('subheading', [
    'label' => 'Subheading Text',
    'instructions' => 'Main content paragraph under heading',
  ])
->addLink('button_link', [
      'label' => 'Button Link',
  ])
  ->addTrueFalse('show_svg', [
      'label' => 'Show SVG Icon in Button?',
      'ui' => 1,
      'default_value' => 1,
  ])
  ->addImage('image', [
    'label' => 'Main Image',
    'return_format' => 'array',
    'preview_size' => 'medium',
  ])

  ->addTab('Design')

  ->addTab('Layout')
    ->addTrueFalse('reverse_layout', [
      'label'        => 'Reverse Layout',
      'ui'           => 1,
      'instructions' => 'On large screens, swap image & text.',
    ])
  ->addRepeater('padding_settings', [
    'label' => 'Padding Settings',
    'instructions' => 'Customize padding for different screen sizes.',
    'button_label' => 'Add Screen Size Padding',
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
    'instructions' => 'Set the top padding in rem.',
    'min' => 0,
    'max' => 20,
    'step' => 0.1,
    'append' => 'rem',
  ])
  ->addNumber('padding_bottom', [
    'label' => 'Padding Bottom',
    'instructions' => 'Set the bottom padding in rem.',
    'min' => 0,
    'max' => 20,
    'step' => 0.1,
    'append' => 'rem',
  ])
  ->endRepeater();


return $hero_005;

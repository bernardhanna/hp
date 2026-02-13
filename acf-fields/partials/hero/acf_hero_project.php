<?php
use StoutLogic\AcfBuilder\FieldsBuilder;

$hero_project = new FieldsBuilder('hero_project', [
  'label' => 'Hero Project Media',
]);

$hero_project
  ->addTab('Content', ['placement' => 'top'])

    ->addImage('hero_image', [
      'label'         => 'Top Hero Image',
      'return_format' => 'array',
      'instructions'  => 'Displayed above the two-column layout.',
    ])

    ->addSelect('project_heading_tag', [
      'label' => 'Project Heading Tag',
      'choices' => [
        'h1'=>'h1','h2'=>'h2','h3'=>'h3','h4'=>'h4','h5'=>'h5','h6'=>'h6','span'=>'span','p'=>'p',
      ],
      'default_value' => 'h1',
    ])

    ->addText('project_title', [
      'label'         => 'Project Title',
      'default_value' => 'Project title',
    ])

    ->addWysiwyg('project_intro', [
      'label'         => 'Intro (short description)',
      'instructions'  => 'Short lead-in text under the title.',
      'tabs'          => 'all',
      'media_upload'  => 0,
      'delay'         => 0,
      'wrapper'       => ['class' => 'wp_editor'],
    ])

    // Details list
    ->addRepeater('details_items', [
      'label'        => 'Details List',
      'button_label' => 'Add Detail',
      'layout'       => 'table',
    ])
      ->addText('label', ['label' => 'Label', 'placeholder' => 'Location'])
      ->addText('value', ['label' => 'Value', 'placeholder' => 'Dublin, Ireland'])
    ->endRepeater()

    ->addWysiwyg('project_extra', [
      'label'         => 'Additional Description',
      'tabs'          => 'all',
      'media_upload'  => 0,
      'delay'         => 0,
      'wrapper'       => ['class' => 'wp_editor'],
    ])

    // Right column media (first two are images, third is video in the design, but we allow flexible types)
    ->addRepeater('media_items', [
      'label'        => 'Right Column Media (Top 2 + Bottom 1)',
      'button_label' => 'Add Media',
      'min'          => 0,
      'max'          => 6,
      'layout'       => 'block',
      'instructions' => 'First three are rendered: top row shows the first two side by side, and the third appears below. Each item can be an Image or a YouTube video.',
    ])
      ->addSelect('type', [
        'label'   => 'Type',
        'choices' => [
          'image'   => 'Image',
          'youtube' => 'YouTube Video',
        ],
        'default_value' => 'image',
      ])
      ->addImage('image', [
        'label'         => 'Image',
        'return_format' => 'array',
        'conditional_logic' => [[['field' => 'type', 'operator' => '==', 'value' => 'image']]],
      ])
      ->addText('label', [
        'label' => 'Overlay Label (Image card)',
        'conditional_logic' => [[['field' => 'type', 'operator' => '==', 'value' => 'image']]],
      ])
      ->addText('title', [
        'label' => 'Overlay Title (Image card)',
        'conditional_logic' => [[['field' => 'type', 'operator' => '==', 'value' => 'image']]],
      ])
      ->addUrl('youtube_url', [
        'label' => 'YouTube URL',
        'placeholder' => 'https://www.youtube.com/watch?v=XXXXXXXXXXX',
        'conditional_logic' => [[['field' => 'type', 'operator' => '==', 'value' => 'youtube']]],
      ])
      ->addImage('poster', [
        'label'         => 'Video Poster (optional)',
        'return_format' => 'array',
        'instructions'  => 'Shown before playback; if empty, a YouTube thumbnail is used.',
        'conditional_logic' => [[['field' => 'type', 'operator' => '==', 'value' => 'youtube']]],
      ])
    ->endRepeater()

  ->addTab('Design', ['placement' => 'top'])
    ->addText('panel_bg_color', [
      'label'         => 'Left Panel Background',
      'default_value' => '#FFFFFF',
      'wrapper'       => ['width' => 33],
    ])
    ->addText('panel_border_color', [
      'label'         => 'Left Panel Border (left)',
      'default_value' => '#D97706',
      'wrapper'       => ['width' => 33],
    ])
    ->addSelect('panel_radius_class', [
      'label'   => 'Left Panel Radius',
      'choices' => [
        'rounded-none'=>'rounded-none','rounded-sm'=>'rounded-sm','rounded'=>'rounded','rounded-md'=>'rounded-md',
        'rounded-lg'=>'rounded-lg','rounded-xl'=>'rounded-xl','rounded-2xl'=>'rounded-2xl','rounded-3xl'=>'rounded-3xl',
      ],
      'default_value' => 'rounded-none',
      'instructions'  => 'Default is rounded-none.',
      'wrapper'       => ['width' => 33],
    ])
    ->addText('details_box_bg', [
      'label'         => 'Details Box Background',
      'default_value' => '#F3F4F6',
      'wrapper'       => ['width' => 33],
    ])
    ->addText('title_color', [
      'label'         => 'Title Color',
      'default_value' => '#0F172A',
      'wrapper'       => ['width' => 33],
    ])
    ->addText('intro_color', [
      'label'         => 'Intro Text Color',
      'default_value' => '#334155',
      'wrapper'       => ['width' => 33],
    ])

  ->addTab('Layout', ['placement' => 'top'])
    ->addRepeater('padding_settings', [
      'label'        => 'Padding Settings',
      'instructions' => 'Customize padding for different screen sizes.',
      'button_label' => 'Add Screen Size Padding',
    ])
      ->addSelect('screen_size', [
        'label'   => 'Screen Size',
        'choices' => [
          'xxs'=>'xxs','xs'=>'xs','mob'=>'mob','sm'=>'sm','md'=>'md','lg'=>'lg','xl'=>'xl','xxl'=>'xxl','ultrawide'=>'ultrawide',
        ],
      ])
      ->addNumber('padding_top', [
        'label'        => 'Padding Top',
        'min'          => 0, 'max' => 20, 'step' => 0.1, 'append' => 'rem',
      ])
      ->addNumber('padding_bottom', [
        'label'        => 'Padding Bottom',
        'min'          => 0, 'max' => 20, 'step' => 0.1, 'append' => 'rem',
      ])
    ->endRepeater();

return $hero_project;

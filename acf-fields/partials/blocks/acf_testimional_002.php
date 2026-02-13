<?php
use StoutLogic\AcfBuilder\FieldsBuilder;

$testimonial_002 = new FieldsBuilder('testimonial_002', [
    'label' => 'Testimonial Slider',
]);

$testimonial_002

// -----------------------------
// Content Tab
// -----------------------------
->addTab('Content', ['placement' => 'top'])

  // Source selector
  ->addSelect('source', [
      'label'         => 'Source',
      'instructions'  => 'Choose where testimonials should come from.',
      'choices'       => [
          'manual' => 'Manual (ACF Repeater)',
          'posts'  => 'From Testimonials Post Type',
      ],
      'default_value' => 'manual',
      'return_format' => 'value',
  ])

  // Manual mode (only when source = manual)
  ->addRepeater('testimonials', [
      'label'            => 'Testimonials',
      'instructions'     => 'Add customer testimonials to display in the slider.',
      'button_label'     => 'Add Testimonial',
      'min'              => 1,
      'layout'           => 'block',
      'conditional_logic'=> [
          [
              [
                  'field'    => 'source',
                  'operator' => '==',
                  'value'    => 'manual',
              ],
          ],
      ],
  ])
      ->addWysiwyg('quote_text', [
          'label'         => 'Quote Text',
          'instructions'  => 'Enter the testimonial quote text.',
          'required'      => 1,
          'default_value' => 'Hanley Pepper Consulting Engineers, under the leadership of Michael Jackson, provided a real commitment to delivering a safe, high quality school building at St. Peter\'s College, Dunboyne. They demonstrated excellent attention to detail and proactive communication which ensured a smooth process from design through to completion. I would have no hesitation in recommending Hanley Pepper for future projects.',
          'toolbar'       => 'basic',
          'media_upload'  => 0,
      ])
      ->addText('author_name', [
          'label'         => 'Author Name',
          'instructions'  => 'Enter the name of the person giving the testimonial.',
          'required'      => 1,
          'default_value' => 'Dr. John Doe',
          'placeholder'   => 'e.g., Dr. John Doe',
      ])
      ->addText('author_title', [
          'label'         => 'Author Title',
          'instructions'  => 'Enter the job title and company of the testimonial author.',
          'required'      => 1,
          'default_value' => 'CEO @ Company name',
          'placeholder'   => 'e.g., CEO @ Company name',
      ])
      ->addImage('testimonial_image', [
          'label'        => 'Testimonial Image',
          'instructions' => 'Upload an image related to the testimonial (author photo, company logo, project image, etc.).',
          'return_format'=> 'array',
          'preview_size' => 'medium',
      ])
  ->endRepeater()

  // Posts mode (only when source = posts)
  ->addRelationship('testimonial_posts', [
      'label'            => 'Select Testimonials',
      'instructions'     => 'Choose testimonials from the post type to display.',
      'post_type'        => ['testimonials'],
      'filters'          => ['search', 'taxonomy'],
      'elements'         => ['featured_image'],
      'return_format'    => 'id',
      'min'              => 1,
      'max'              => 20,
      'conditional_logic'=> [
          [
              [
                  'field'    => 'source',
                  'operator' => '==',
                  'value'    => 'posts',
              ],
          ],
      ],
  ])

// -----------------------------
// Design Tab (all design here)
// -----------------------------
->addTab('Design', ['placement' => 'top'])

  // Background Image with default set by filter below
  ->addImage('background_image', [
      'label'         => 'Background Image',
      'instructions'  => 'Optional background image for the section.',
      'return_format' => 'array',
      'preview_size'  => 'medium',
  ])

  // Colors (global)
  ->addColorPicker('background_color', [
      'label'         => 'Section Background Color',
      'default_value' => '#ffffff',
  ])
  ->addColorPicker('nav_active_color', [
      'label'         => 'Active Navigation Dot Color',
      'default_value' => '#d97706',
  ])
  ->addColorPicker('nav_inactive_color', [
      'label'         => 'Inactive Navigation Dot Color',
      'default_value' => '#64748b',
  ])
  ->addColorPicker('arrow_active_bg', [
      'label'         => 'Active Arrow Background Color',
      'default_value' => '#d97706',
  ])
  ->addColorPicker('arrow_inactive_bg', [
      'label'         => 'Inactive Arrow Background Color',
      'default_value' => '#d1d5db',
  ])

  // Typography controls
  ->addText('quote_text_size_lg_value', [
      'label'        => 'Quote Text Size (lg and above) — custom',
      'instructions' => 'Enter a CSS size (e.g., 36px, 2.25rem, 2em). Leave empty to use the default.',
      'placeholder'  => '36px',
      'wrapper'      => ['width' => 50],
  ])
  ->addNumber('quote_line_height_lg_rem', [
      'label'        => 'Quote Line Height (rem, global)',
      'instructions' => 'If set, applied via inline CSS. Example: 1.4',
      'min'          => 0.5,
      'max'          => 4,
      'step'         => 0.05,
      'append'       => 'rem',
      'wrapper'      => ['width' => 50],
  ])

// -----------------------------
// Layout Tab
// -----------------------------
->addTab('Layout', ['placement' => 'top'])
  ->addRepeater('padding_settings', [
      'label'         => 'Padding Settings',
      'instructions'  => 'Customize padding for different screen sizes.',
      'button_label'  => 'Add Screen Size Padding',
      'layout'        => 'table',
  ])
    ->addSelect('screen_size', [
        'label'   => 'Screen Size',
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
        'default_value' => 'lg',
        'required'      => 1,
    ])
    ->addNumber('padding_top', [
        'label'         => 'Padding Top',
        'instructions'  => 'Set the top padding in rem.',
        'min'           => 0,
        'max'           => 20,
        'step'          => 0.1,
        'append'        => 'rem',
        'default_value' => 5,
    ])
    ->addNumber('padding_bottom', [
        'label'         => 'Padding Bottom',
        'instructions'  => 'Set the bottom padding in rem.',
        'min'           => 0,
        'max'           => 20,
        'step'          => 0.1,
        'append'        => 'rem',
        'default_value' => 5,
    ])
  ->endRepeater();

return $testimonial_002;

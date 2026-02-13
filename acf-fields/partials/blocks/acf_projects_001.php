<?php
use StoutLogic\AcfBuilder\FieldsBuilder;

$projects_001 = new FieldsBuilder('projects_001', [
    'label' => 'Projects 001',
]);

$projects_001

  // =========================
  // Content Tab
  // =========================
  ->addTab('Content', ['placement' => 'top'])

    // Headline/content
    ->addText('title', [
        'label'         => 'Title',
        'default_value' => 'Latest Projects',
        'wrapper'       => ['width' => 50],
    ])
    ->addTextarea('description', [
        'label'         => 'Description',
        'new_lines'     => 'br',
        'default_value' => 'Lorem ipsum dolor sit amet consectetur. Suspendisse laoreet tincidunt et sit malesuada vivamus. Blandit netus in orci vulputate.',
        'wrapper'       => ['width' => 50],
    ])
    ->addLink('button', [
        'label'         => 'Button (ACF Link)',
        'return_format' => 'array',
        'default_value' => [
            'url'    => '/projects/',
            'title'  => 'Projects',
            'target' => '_self',
        ],
        'wrapper'       => ['width' => 50],
    ])

    // Source control
    ->addSelect('project_source', [
        'label'         => 'Project Source',
        'instructions'  => 'Choose how to populate the project cards.',
        'choices'       => [
            'latest'   => 'Latest Projects (default)',
            'related'  => 'Related to Current Post',
            'selected' => 'Select Projects',
            'manual'   => 'Manual Cards',
        ],
        'default_value' => 'latest',
        'return_format' => 'value',
        'wrapper'       => ['width' => 50],
    ])
    ->addNumber('max_projects', [
        'label'            => 'Max Projects',
        'instructions'     => 'How many projects to show (1–6). Default is 3.',
        'min'              => 1,
        'max'              => 6,
        'step'             => 1,
        'default_value'    => 3,
        'wrapper'          => ['width' => 50],
        'conditional_logic'=> [
            [
                [
                    'field'    => 'project_source',
                    'operator' => '!=',
                    'value'    => 'manual',
                ],
            ],
        ],
    ])

    // Related mode options
    ->addSelect('related_taxonomy', [
        'label'            => 'Related Taxonomy',
        'choices'          => [
            'project_category' => 'project_category',
            'category'         => 'category',
            'post_tag'         => 'post_tag',
        ],
        'default_value'     => 'project_category',
        'wrapper'           => ['width' => 50],
        'conditional_logic' => [
            [
                [
                    'field'    => 'project_source',
                    'operator' => '==',
                    'value'    => 'related',
                ],
            ],
        ],
    ])

    // Selected mode options
    ->addRelationship('selected_projects', [
        'label'            => 'Select Projects',
        'post_type'        => ['projects'],
        'filters'          => ['search', 'taxonomy'],
        'elements'         => ['featured_image'],
        'return_format'    => 'id',
        'min'              => 1,
        'max'              => 2,
        'conditional_logic'=> [
            [
                [
                    'field'    => 'project_source',
                    'operator' => '==',
                    'value'    => 'selected',
                ],
            ],
        ],
    ])

    // Manual mode: 3 cards (only for manual)
    ->addGroup('project_1', [
        'label'             => 'Project 1',
        'conditional_logic' => [[['field' => 'project_source','operator' => '==','value' => 'manual']]],
    ])
        ->addText('label', ['label' => 'Label (e.g. PROJECT)'])
        ->addText('title', ['label' => 'Title'])
        ->addImage('image', [
            'label'        => 'Image',
            'return_format'=> 'array',
            'preview_size' => 'medium',
        ])
        ->addLink('link', [
            'label'         => 'Link (ACF Link)',
            'return_format' => 'array',
        ])
    ->endGroup()
    ->addGroup('project_2', [
        'label'             => 'Project 2',
        'conditional_logic' => [[['field' => 'project_source','operator' => '==','value' => 'manual']]],
    ])
        ->addText('label', ['label' => 'Label'])
        ->addText('title', ['label' => 'Title'])
        ->addImage('image', [
            'label'        => 'Image',
            'return_format'=> 'array',
            'preview_size' => 'medium',
        ])
        ->addLink('link', [
            'label'         => 'Link (ACF Link)',
            'return_format' => 'array',
        ])
    ->endGroup()
    ->addGroup('project_3', [
        'label'             => 'Project 3',
        'conditional_logic' => [[['field' => 'project_source','operator' => '==','value' => 'manual']]],
    ])
        ->addText('label', ['label' => 'Label'])
        ->addText('title', ['label' => 'Title'])
        ->addImage('image', [
            'label'        => 'Image',
            'return_format'=> 'array',
            'preview_size' => 'medium',
        ])
        ->addLink('link', [
            'label'         => 'Link (ACF Link)',
            'return_format' => 'array',
        ])
    ->endGroup()

  // =========================
  // Design Tab
  // =========================
  ->addTab('Design', ['placement' => 'top'])

    // Visual / style controls
    ->addImage('background_image', [
        'label'        => 'Background Image',
        'return_format'=> 'array',
        'preview_size' => 'medium',
        'wrapper'      => ['width' => 50],
        // (Optional) If you want a true default: uncomment and set an attachment ID:
        // 'default_value' => 256,
    ])
    ->addImage('title_icon', [
        'label'        => 'Optional Title Icon',
        'return_format'=> 'array',
        'preview_size' => 'medium',
        'wrapper'      => ['width' => 33],
    ])
    ->addText('title_color', [
        'label'         => 'Title Color (CSS value)',
        'placeholder'   => '#ffffff',
        'default_value' => '#ffffff',
        'wrapper'       => ['width' => 33],
    ])
    ->addTrueFalse('bg_full_height', [
        'label'   => 'Background Full Height',
        'ui'      => 1,
        'wrapper' => ['width' => 33],
    ])
    ->addNumber('bg_fixed_height', [
        'label'   => 'Background Fixed Height (px)',
        'min'     => 0,
        'step'    => 1,
        'wrapper' => ['width' => 33],
    ])
    ->addSelect('bg_object_fit', [
        'label'         => 'Background Object Fit',
        'choices'       => [
            'object-cover'   => 'Cover',
            'object-contain' => 'Contain',
            'object-fill'    => 'Fill',
            'object-none'    => 'None',
        ],
        'default_value' => 'object-cover',
        'wrapper'       => ['width' => 33],
    ])

    // Spacing (kept with design)
    ->addRepeater('padding_settings', [
        'label'         => 'Padding Settings',
        'instructions'  => 'Customize padding for different screen sizes.',
        'button_label'  => 'Add Screen Size Padding',
    ])
      ->addSelect('screen_size', [
          'label'   => 'Screen Size',
          'choices' => [
              'xxs' => 'xxs', 'xs' => 'xs', 'mob' => 'mob', 'sm' => 'sm',
              'md' => 'md', 'lg' => 'lg', 'xl' => 'xl', 'xxl' => 'xxl', 'ultrawide' => 'ultrawide',
          ],
      ])
      ->addNumber('padding_top', [
          'label'        => 'Padding Top',
          'min'          => 0,
          'max'          => 20,
          'step'         => 0.1,
          'append'       => 'rem',
      ])
      ->addNumber('padding_bottom', [
          'label'        => 'Padding Bottom',
          'min'          => 0,
          'max'          => 20,
          'step'         => 0.1,
          'append'       => 'rem',
      ])
    ->endRepeater();

return $projects_001;

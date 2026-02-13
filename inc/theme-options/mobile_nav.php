<?php
// File: inc/acf/options/theme-options/mobile_nav.php
use StoutLogic\AcfBuilder\FieldsBuilder;

$fields = new FieldsBuilder('mobile_nav', [
  'label' => 'Mobile Navigation',
]);

$fields
  ->addTrueFalse('enable_hamburger', [
    'label'         => 'Enable Hamburger Menu',
    'instructions'  => 'Toggle to enable or disable the hamburger menu in mobile navigation.',
    'ui'            => 1,
    'default_value' => 1,
  ])

  ->addSelect('hamburger_style', [
    'label'        => 'Hamburger Style',
    'instructions' => 'Select the hamburger menu style.',
    'choices'      => [
      'hamburger--3dx' => '3DX', 'hamburger--3dx-r' => '3DX Reverse',
      'hamburger--3dy' => '3DY', 'hamburger--3dy-r' => '3DY Reverse',
      'hamburger--3dxy' => '3DXY', 'hamburger--3dxy-r' => '3DXY Reverse',
      'hamburger--arrow' => 'Arrow', 'hamburger--arrow-r' => 'Arrow Reverse',
      'hamburger--arrowalt' => 'Arrow Alternative', 'hamburger--arrowalt-r' => 'Arrow Alternative Reverse',
      'hamburger--arrowturn' => 'Arrow Turn', 'hamburger--arrowturn-r' => 'Arrow Turn Reverse',
      'hamburger--boring' => 'Boring',
      'hamburger--collapse' => 'Collapse', 'hamburger--collapse-r' => 'Collapse Reverse',
      'hamburger--elastic' => 'Elastic', 'hamburger--elastic-r' => 'Elastic Reverse',
      'hamburger--emphatic' => 'Emphatic', 'hamburger--emphatic-r' => 'Emphatic Reverse',
      'hamburger--minus' => 'Minus',
      'hamburger--slider' => 'Slider', 'hamburger--slider-r' => 'Slider Reverse',
      'hamburger--spin' => 'Spin', 'hamburger--spin-r' => 'Spin Reverse',
      'hamburger--spring' => 'Spring', 'hamburger--spring-r' => 'Spring Reverse',
      'hamburger--stand' => 'Stand', 'hamburger--stand-r' => 'Stand Reverse',
      'hamburger--squeeze' => 'Squeeze',
      'hamburger--vortex' => 'Vortex', 'hamburger--vortex-r' => 'Vortex Reverse',
    ],
    'default_value' => 'hamburger--spin',
    'ui'            => 1,
    'return_format' => 'value',
    'conditional_logic' => [
      [
        [
          'field'    => 'enable_hamburger',
          'operator' => '==',
          'value'    => '1',
        ]
      ]
    ],
  ])

  ->addSelect('mobile_menu_effect', [
    'label'        => 'Mobile Menu Open Effect',
    'instructions' => 'Choose the animation effect for the mobile menu.',
    'choices'      => [
      'slide_up'    => 'Slide Up',
      'slide_left'  => 'Slide In from Left',
      'slide_right' => 'Slide In from Right',
      'fullscreen'  => 'Full Screen',
    ],
    'default_value' => 'slide_up',
    'ui'            => 1,
    'conditional_logic' => [
      [
        [
          'field'    => 'enable_hamburger',
          'operator' => '==',
          'value'    => '1',
        ]
      ]
    ],
  ])

  ->addNumber('mobile_menu_width', [
    'label'         => 'Mobile Menu Width (%)',
    'instructions'  => 'Enter width as a percentage (e.g., 80 for 80%).',
    'default_value' => 100,
    'append'        => '%',
    'conditional_logic' => [
      [
        [
          'field'    => 'mobile_menu_effect',
          'operator' => '!=',
          'value'    => 'fullscreen',
        ],
        [
          'field'    => 'enable_hamburger',
          'operator' => '==',
          'value'    => '1',
        ]
      ],
    ],
  ])

  ->addColorPicker('mobile_menu_background', [
    'label'         => 'Mobile Menu Background Color',
    'default_value' => '#FFFFFF',
    'conditional_logic' => [
      [
        [
          'field'    => 'enable_hamburger',
          'operator' => '==',
          'value'    => '1',
        ]
      ]
    ],
  ])

  /* Contact card options */
  ->addTrueFalse('mobile_contact_enable', [
    'label'         => 'Show Contact Card',
    'instructions'  => 'Toggle to display the contact card at the bottom of the mobile menu.',
    'ui'            => 1,
    'default_value' => 1,
    'conditional_logic' => [
      [
        [
          'field'    => 'enable_hamburger',
          'operator' => '==',
          'value'    => '1',
        ]
      ]
    ],
  ])

  ->addText('mobile_contact_phone', [
    'label'         => 'Phone Number',
    'instructions'  => 'Shown beside the phone button. Clicking the icon will call this number.',
    'default_value' => '+353 1 283 2967',
    'conditional_logic' => [
      [
        [
          'field'    => 'mobile_contact_enable',
          'operator' => '==',
          'value'    => '1',
        ]
      ]
    ],
  ])

  ->addImage('mobile_contact_icon', [
    'label'         => 'Phone Icon (optional)',
    'instructions'  => 'Optional custom icon for the phone button. If empty, a Font Awesome phone icon is used.',
    'return_format' => 'array',
    'preview_size'  => 'thumbnail',
    'conditional_logic' => [
      [
        [
          'field'    => 'mobile_contact_enable',
          'operator' => '==',
          'value'    => '1',
        ]
      ]
    ],
  ])

  ->addLink('mobile_contact_link', [
    'label'        => 'Contact Button Link',
    'instructions' => 'Destination for the “Contact us” button.',
    'return_format'=> 'array',
    'conditional_logic' => [
      [
        [
          'field'    => 'mobile_contact_enable',
          'operator' => '==',
          'value'    => '1',
        ]
      ]
    ],
  ])

  ->addText('mobile_contact_label', [
    'label'         => 'Contact Button Label',
    'default_value' => 'Contact us',
    'conditional_logic' => [
      [
        [
          'field'    => 'mobile_contact_enable',
          'operator' => '==',
          'value'    => '1',
        ]
      ]
    ],
  ])

  ->addColorPicker('mobile_contact_box_bg', [
    'label'         => 'Contact Card Background',
    'default_value' => '#F9FAFB',
    'conditional_logic' => [
      [
        [
          'field'    => 'mobile_contact_enable',
          'operator' => '==',
          'value'    => '1',
        ]
      ]
    ],
  ]);

return $fields;

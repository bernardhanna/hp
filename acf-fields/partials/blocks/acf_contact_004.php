<?php
use StoutLogic\AcfBuilder\FieldsBuilder;

$contact_004 = new FieldsBuilder('contact_004', [
    'label' => 'Contact 004',
]);

$contact_004
    ->addTab('Content')
        ->addText('subheading', ['label' => 'Subheading'])
        ->addText('heading',    ['label' => 'Heading'])
        ->addSelect('heading_tag', [
            'label' => 'Heading Tag',
            'choices' => [
                'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3',
                'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6',
                'p' => 'Paragraph', 'span' => 'Span'
            ],
            'default_value' => 'h2',
        ])
        ->addWysiwyg('description', [
            'label' => 'Description',
            'wrapper' => ['class' => 'wp_editor'],
            'media_upload' => 0,
            'tabs' => 'visual',
        ])
        ->addText('phone', ['label' => 'Phone Number'])
        ->addImage('phone_icon', [
            'label'         => 'Phone Icon',
            'return_format' => 'array',
            'preview_size'  => 'thumbnail',
        ])
        ->addText('fax', ['label' => 'Fax Number'])
        ->addImage('fax_icon', [
            'label'         => 'Fax Icon',
            'return_format' => 'array',
            'preview_size'  => 'thumbnail',
        ])
        ->addEmail('email', ['label' => 'Email Address'])
        ->addImage('email_icon', [
            'label'         => 'Email Icon',
            'return_format' => 'array',
            'preview_size'  => 'thumbnail',
        ])
        ->addText('address', ['label' => 'Address'])
        ->addImage('address_icon', [
            'label'         => 'Address Icon',
            'return_format' => 'array',
            'preview_size'  => 'thumbnail',
        ])
        ->addWysiwyg('hours', [
            'label' => 'Opening Hours (WYSIWYG)',
            'wrapper' => ['class' => 'wp_editor'],
            'media_upload' => 0,
            'tabs' => 'visual',
        ])
        ->addImage('hours_icon', [
            'label'         => 'Hours Icon',
            'return_format' => 'array',
            'preview_size'  => 'thumbnail',
        ])
        ->addText('form_heading', [
            'label' => 'Form Heading',
            'default_value' => 'Send us a message'
        ])
        ->addSelect('form_heading_tag', [
            'label' => 'Form Heading Tag',
            'choices' => [
                'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3',
                'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6',
                'p' => 'Paragraph', 'span' => 'Span'
            ],
            'default_value' => 'h2',
        ])
        ->addWysiwyg('form_markup', [
            'label' => 'Form HTML (paste static form here)',
            'instructions' => 'Paste the static HTML form code here. Leave empty to use the default form design.',
            'toolbar' => 'basic',
            'media_upload' => 0,
            'wrapper' => ['class' => 'wp_editor'],
        ])
        ->addUrl('privacy_policy_url', [
            'label' => 'Privacy Policy URL',
            'instructions' => 'URL for the privacy policy link in the form',
            'default_value' => '#'
        ])
       ->addRepeater('social_links', [
            'label' => 'Social Media Links',
            'layout' => 'table',
            'button_label' => 'Add Social Link',
        ])
            ->addText('label', ['label' => 'Platform Name (e.g., LinkedIn)'])
            ->addUrl('url', ['label' => 'Social Media URL'])
            ->addImage('icon_image', [
                'label'         => 'Icon Image',
                'return_format' => 'array',
                'preview_size'  => 'thumbnail',
                'instructions'  => 'Upload icon image. Takes priority over SVG below.',
            ])
            ->addTextarea('icon_svg', [
                'label' => 'SVG Icon Code',
                'rows' => 5,
                'instructions' => 'Paste inline SVG code. If image is set above, image will be used.',
            ])
        ->endRepeater()

 ->addTab('Email')
        ->addText('form_name', [
            'label' => 'Internal Form Name',
            'instructions' => 'A label saved with each entry & used in email subject. Optional.',
            'default_value' => 'Contact Form'
        ])
        ->addEmail('email_to', ['label' => 'Send To'])
        ->addText('email_bcc', ['label' => 'BCC'])
        ->addText('email_subject', [
            'label' => 'Subject',
            'default_value' => 'Website contact form enquiry'
        ])
        ->addTrueFalse('save_entries_to_db', [
            'label' => 'Save to DB?',
            'ui' => 1,
            'default_value' => 1
        ])

    ->addTab('Autoresponder')
        ->addTrueFalse('enable_autoresponder', [
            'label' => 'Enable?',
            'ui' => 1
        ])
        ->addText('autoresponder_subject', [
            'label' => 'Autoresponder Subject',
            'conditional_logic' => [
                [
                    [
                        'field' => 'enable_autoresponder',
                        'operator' => '==',
                        'value' => 1
                    ]
                ]
            ],
            'default_value' => 'Thank you for your message'
        ])
        ->addWysiwyg('autoresponder_message', [
            'label' => 'Autoresponder Message',
            'conditional_logic' => [
                [
                    [
                        'field' => 'enable_autoresponder',
                        'operator' => '==',
                        'value' => 1
                    ]
                ]
            ],
            'wrapper' => ['class' => 'wp_editor'],
            'default_value' => '<p>Thank you for contacting us. We have received your message and will get back to you as soon as possible.</p>'
        ])
        
    ->addTab('Design')
        ->addColorPicker('background_color', ['label' => 'Background Color'])
        ->addColorPicker('text_color', ['label' => 'Text Color'])
    ->addTab('Layout')
        ->addRepeater('padding_settings', [
            'label' => 'Padding Settings',
            'instructions' => 'Customize padding for different screen sizes.',
            'button_label' => 'Add Padding',
        ])
            ->addSelect('screen_size', [
                'label' => 'Screen Size',
                'choices' => [
                    'xxs' => 'xxs', 'xs' => 'xs', 'mob' => 'mob',
                    'sm' => 'sm', 'md' => 'md', 'lg' => 'lg',
                    'xl' => 'xl', 'xxl' => 'xxl', 'ultrawide' => 'ultrawide',
                ],
            ])
            ->addNumber('padding_top', [
                'label' => 'Padding Top',
                'min' => 0, 'max' => 20, 'step' => 0.1, 'append' => 'rem',
            ])
            ->addNumber('padding_bottom', [
                'label' => 'Padding Bottom',
                'min' => 0, 'max' => 20, 'step' => 0.1, 'append' => 'rem',
            ])
        ->endRepeater();

return $contact_004;

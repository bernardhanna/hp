<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$clients_002 = new FieldsBuilder('clients_002', [
    'label' => 'Clients 002',
]);

$clients_002

// Content Tab
->addTab('Content', ['placement' => 'top'])
->addSelect('heading_tag', [
    'label' => 'Heading Tag',
    'choices' => [
        'h1' => 'H1',
        'h2' => 'H2',
        'h3' => 'H3',
        'h4' => 'H4',
        'h5' => 'H5',
        'h6' => 'H6',
        'span' => 'Span',
        'p' => 'Paragraph',
    ],
    'default_value' => 'h2',
    'instructions' => 'Select the HTML tag for the main heading.',
])
->addText('heading_text', [
    'label' => 'Heading Text',
    'placeholder' => 'Enter your heading text...',
    'default_value' => 'Our clients',
    'instructions' => 'Enter the main heading for the clients section.',
])
->addRepeater('clients', [
    'label' => 'Clients',
    'instructions' => 'Add client cards to display in the grid.',
    'button_label' => 'Add Client',
    'min' => 1,
    'max' => 12,
    'layout' => 'block',
])
    ->addImage('image', [
        'label' => 'Client Image',
        'return_format' => 'array',
        'instructions' => 'Upload an image for this client card.',
        'required' => 1,
    ])
    ->addText('subtitle', [
        'label' => 'Subtitle',
        'placeholder' => 'e.g., PROJECTS, SERVICES, etc.',
        'default_value' => 'SUBTITLE',
        'instructions' => 'Small text that appears above the client name.',
    ])
    ->addText('client_name', [
        'label' => 'Client Name',
        'placeholder' => 'Enter client name...',
        'default_value' => 'Client name',
        'instructions' => 'The main client name or title.',
        'required' => 1,
    ])
    ->addLink('link', [
        'label' => 'Client Link',
        'return_format' => 'array',
        'instructions' => 'Link to client details or external site.',
        'default_value' => [
            'url' => '#',
            'title' => 'View Client',
            'target' => '_self',
        ],
    ])
->endRepeater()

// Design Tab
->addTab('Design', ['placement' => 'top'])
->addColorPicker('background_color', [
    'label' => 'Section Background Color',
    'default_value' => '#FFFFFF',
    'instructions' => 'Set the background color for the entire section.',
])
->addColorPicker('heading_color', [
    'label' => 'Heading Text Color',
    'default_value' => '#64748B',
    'instructions' => 'Set the color for the main heading text.',
])

// Layout Tab
->addTab('Layout', ['placement' => 'top'])
->addRepeater('padding_settings', [
    'label' => 'Padding Settings',
    'instructions' => 'Customize padding for different screen sizes.',
    'button_label' => 'Add Screen Size Padding',
    'layout' => 'table',
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
        'instructions' => 'Select the screen size for this padding setting.',
    ])
    ->addNumber('padding_top', [
        'label' => 'Padding Top',
        'instructions' => 'Set the top padding in rem.',
        'min' => 0,
        'max' => 20,
        'step' => 0.1,
        'append' => 'rem',
        'default_value' => 3.5,
    ])
    ->addNumber('padding_bottom', [
        'label' => 'Padding Bottom',
        'instructions' => 'Set the bottom padding in rem.',
        'min' => 0,
        'max' => 20,
        'step' => 0.1,
        'append' => 'rem',
        'default_value' => 5,
    ])
->endRepeater();

return $clients_002;

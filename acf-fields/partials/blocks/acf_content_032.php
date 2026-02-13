<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$content_032 = new FieldsBuilder('content_032', [
    'label' => 'Bullet List & Image',
]);

$content_032
    ->addTab('Content')
        ->addText('subheading', [
            'label' => 'Subheading',
        ])
        ->addText('heading', [
            'label' => 'Heading Text',
        ])
        ->addSelect('heading_tag', [
            'label' => 'Heading Tag',
            'instructions' => 'Choose HTML tag for heading.',
            'choices' => [
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'h4' => 'H4',
                'h5' => 'H5',
                'h6' => 'H6',
                'p' => 'Paragraph',
                'span' => 'Span',
            ],
            'default_value' => 'h2',
        ])
        ->addWysiwyg('description', [
            'label' => 'Description',
            'media_upload' => false,
            'tabs' => 'visual',
        ])
        ->addRepeater('list_items', [
            'label' => 'List Items',
            'button_label' => 'Add List Item',
            'layout' => 'block',
        ])
            ->addText('item', [
                'label' => 'Item Text',
                'required' => 1,
            ])
        ->endRepeater()
        ->addImage('image', [
            'label' => 'Image',
            'return_format' => 'array',
            'preview_size' => 'medium',
        ])
        ->addText('image_border_radius', [
            'label' => 'Image Border Radius Class',
            'instructions' => 'Enter Tailwind class for border radius (e.g. rounded-xl)',
        ])

    ->addTab('Design')
        ->addColorPicker('text_color', [
            'label' => 'Text Color',
        ])
        ->addColorPicker('background_color', [
            'label' => 'Background Color',
        ])

    ->addTab('Layout')
        ->addTrueFalse('reverse_layout', [
        'label' => 'Reverse Layout',
        'ui' => 1,
        'instructions' => 'Toggle to reverse the image and text layout.',
    ])
        ->addRepeater('padding_settings', [
            'label' => 'Padding Settings',
            'instructions' => 'Customize padding for different screen sizes.',
            'button_label' => 'Add Padding Setting',
        ])
            ->addSelect('screen_size', [
                'label' => 'Screen Size',
                'choices' => [
                    'xxs' => 'xxs', 'xs' => 'xs', 'mob' => 'mob', 'sm' => 'sm',
                    'md' => 'md', 'lg' => 'lg', 'xl' => 'xl', 'xxl' => 'xxl', 'ultrawide' => 'ultrawide',
                ],
                'default_value' => 'md',
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

return $content_032;

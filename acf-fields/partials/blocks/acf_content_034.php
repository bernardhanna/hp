<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$content_034 = new FieldsBuilder('content_034', [
    'label' => 'Content 034',
]);

$content_034
    ->addTab('Content')
        ->addImage('image', [
            'label' => 'Image',
            'return_format' => 'array',
            'preview_size' => 'medium',
        ])
        ->addText('heading', [
            'label' => 'Heading',
        ])
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
            'default_value' => 'h2',
        ])
        ->addWysiwyg('content', [
            'label' => 'Content',
            'media_upload' => 0,
            'tabs' => 'visual',
            'wrapper' => ['class' => 'wp_editor'],
        ])
        ->addLink('button_link', [
            'label' => 'Button Link',
            'instructions' => 'Add link text and URL.',
        ])
        ->addRadio('show_icon', [
            'label' => 'Show Button Icon',
            'choices' => [
                'yes' => 'Yes',
                'no' => 'No',
            ],
            'default_value' => 'yes',
            'layout' => 'horizontal',
        ])

    ->addTab('Design')
        ->addColorPicker('text_color', [
            'label' => 'Text Color',
        ])
        ->addColorPicker('background_color', [
            'label' => 'Background Color',
        ])
        ->addColorPicker('button_color', [
            'label' => 'Button Background Color',
        ])
        ->addColorPicker('button_hover_color', [
            'label' => 'Button Hover Background Color',
        ])
        ->addSelect('image_radius', [
            'label' => 'Image Border Radius',
            'choices' => [
                'rounded-none' => 'None',
                'rounded-sm' => 'Small',
                'rounded-md' => 'Medium',
                'rounded-lg' => 'Large',
                'rounded-xl' => 'Extra Large',
                'rounded-full' => 'Full',
            ],
            'default_value' => 'rounded-none',
        ])

    ->addTab('Layout')
        ->addRepeater('padding_settings', [
            'label' => 'Padding Settings',
            'instructions' => 'Customize top and bottom padding for different screen sizes.',
            'button_label' => 'Add Padding Setting',
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

return $content_034;

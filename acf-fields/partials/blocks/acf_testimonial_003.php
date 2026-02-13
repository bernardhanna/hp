<?php
use StoutLogic\AcfBuilder\FieldsBuilder;

$testimonial_003 = new FieldsBuilder('testimonial_003', [
    'label' => 'Testimonial',
]);

$testimonial_003
    ->addTab('Content')
        ->addImage('image', [
            'label' => 'Background Image (Left)',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'instructions' => 'Upload the testimonial-related image.',
        ])
        ->addTextarea('quote', [
            'label' => 'Main Quote Text',
            'rows' => 4,
            'instructions' => 'Enter the quote/testimonial text shown on the right.',
        ])
    ->addLink('button_link', [
            'label' => 'Button Link',
        ])
        ->addTrueFalse('show_svg', [
            'label' => 'Show SVG Icon in Button?',
            'ui' => 1,
            'default_value' => 1,
        ])
    ->addTab('Layout')
        ->addRepeater('padding_settings', [
            'label' => 'Padding Settings',
            'instructions' => 'Customize padding for different screen sizes.',
            'button_label' => 'Add Screen Size Padding',
        ])
            ->addSelect('screen_size', [
                'label' => 'Screen Size',
                'choices' => [
                    'xxs' => 'xxs', 'xs' => 'xs', 'mob' => 'mob', 'sm' => 'sm',
                    'md' => 'md', 'lg' => 'lg', 'xl' => 'xl', 'xxl' => 'xxl', 'ultrawide' => 'ultrawide',
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

return $testimonial_003;

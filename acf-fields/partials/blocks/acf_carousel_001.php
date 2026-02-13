<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$carousel_001 = new FieldsBuilder('carousel_001', [
    'label' => 'Carousel',
]);

$carousel_001
    ->addTab('Content')
        ->addRepeater('carousel_slides', [
            'label' => 'Carousel Slides',
            'button_label' => 'Add Slide',
            'layout' => 'block',
        ])
            ->addImage('slide_image', [
                'label' => 'Slide Image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Upload an image for the slide.',
            ])
            ->addTrueFalse('slide_decorative', [
                'label' => 'Mark Image as Decorative',
                'instructions' => 'If checked, this image will be decorative and not read by screen readers.',
                'ui' => 1,
                'default_value' => 0,
            ])
            ->addSelect('slide_heading_tag', [
                'label' => 'Heading Tag',
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
            ->addText('slide_heading', [
                'label' => 'Heading Text',
                'instructions' => 'Enter the heading for this slide.',
            ])
            ->addText('slide_description', [
                'label' => 'Slide Description',
                'instructions' => 'Optional short description for the slide.',
            ])
        ->endRepeater()
    ->addTab('Layout')
        ->addRepeater('padding_settings', [
            'label' => 'Padding Settings',
            'instructions' => 'Customize top and bottom padding for devices.',
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
                'label' => 'Padding Top (rem)',
                'min' => 0,
                'max' => 20,
                'step' => 0.1,
            ])
            ->addNumber('padding_bottom', [
                'label' => 'Padding Bottom (rem)',
                'min' => 0,
                'max' => 20,
                'step' => 0.1,
            ])
        ->endRepeater();

return $carousel_001;
?>

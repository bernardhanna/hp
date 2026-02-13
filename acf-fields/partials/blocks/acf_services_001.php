<?php
use StoutLogic\AcfBuilder\FieldsBuilder;

$services_001 = new FieldsBuilder('services_001', [
    'label' => 'Services Slider',
]);

$services_001
    ->addTab('Content')
        ->addRepeater('slides', [
            'label' => 'Slides',
            'layout' => 'row',
            'button_label' => 'Add Slide',
        ])
            ->addLink('link', [
                'label' => 'Link',
                'required' => 1,
            ])
            ->addImage('background_image', [
                'label' => 'Background Image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ])
            ->addWysiwyg('description', [
                'label' => 'Description Text',
                'media_upload' => 0,
                'delay' => 1,
                'tabs' => 'visual',
                'wrapper' => ['class' => 'wp_editor'],
            ])
        ->endRepeater()
        ->addSelect('heading_tag', [
            'label' => 'Heading Tag',
            'default_value' => 'h2',
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
        ])
        ->addText('heading_text', [
            'label' => 'Heading Text',
            'default_value' => 'Our Services',
        ])
    ->addTab('Design')
        ->addColorPicker('text_color', ['label' => 'Text Color'])
        ->addColorPicker('hover_text_color', ['label' => 'Hover Text Color'])
        ->addColorPicker('hover_bg_color', ['label' => 'Hover Background Color'])
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
                'append' => 'rem',
                'min' => 0, 'max' => 20, 'step' => 0.1,
            ])
            ->addNumber('padding_bottom', [
                'label' => 'Padding Bottom',
                'append' => 'rem',
                'min' => 0, 'max' => 20, 'step' => 0.1,
            ])
        ->endRepeater();

return $services_001;
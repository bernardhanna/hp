<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$content_029 = new FieldsBuilder('content_029', [
    'label' => 'Content Block 029',
]);

$content_029
    ->addTab('Content')
        ->addSelect('content_029_heading_tag', [
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
        ])
        ->addText('content_029_heading_text', [
            'label' => 'Heading Text',
            'default_value' => 'Engineering excellence realised',
        ])
        ->addWysiwyg('content_029_paragraph_text', [
            'label' => 'Paragraph Text',
            'tabs' => 'all',
            'toolbar' => 'basic',
            'media_upload' => 0,
            'default_value' => '<p>Since 1985 Hanley Pepper delivers Structural Engineering with a client focused service based on quality and aesthetic solutions. Our project referrals are testament to the service we provide.</p>',
        ])
        ->addLink('content_029_button_link', [
            'label' => 'Button Link',
        ])
        ->addTrueFalse('content_029_show_svg', [
            'label' => 'Show SVG Icon in Button?',
            'ui' => 1,
            'default_value' => 1,
        ])
    ->addTab('Design')
        ->addColorPicker('paragraph_text_color', [
            'label' => 'Paragraph Text Color',
        ])
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

return $content_029;
?>

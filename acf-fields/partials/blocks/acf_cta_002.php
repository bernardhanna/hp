<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$cta_002 = new FieldsBuilder('cta_002', [
    'label' => 'CTA 002',
]);

$cta_002
    ->addTab('Content')
        ->addImage('image', [
            'label'         => 'Image',
            'return_format' => 'array',
            'preview_size'  => 'medium',
        ])
        ->addSelect('heading_tag', [
            'label'        => 'Heading Tag',
            'choices'      => [
                'h1'   => 'H1',
                'h2'   => 'H2',
                'h3'   => 'H3',
                'h4'   => 'H4',
                'h5'   => 'H5',
                'h6'   => 'H6',
                'p'    => 'Paragraph',
                'span' => 'Span',
            ],
            'default_value' => 'h2',
        ])
        ->addText('heading', [
            'label' => 'Heading Text',
        ])
        ->addText('subheading', [
            'label' => 'Subheading Text',
        ])
        ->addLink('button', [
            'label'         => 'CTA Button',
            'return_format' => 'array',
        ])
    ->addTab('Layout')
        ->addRepeater('padding_settings', [
            'label'        => 'Padding Settings',
            'button_label' => 'Add Padding',
        ])
            ->addSelect('screen_size', [
                'label'   => 'Screen Size',
                'choices' => [
                    'xxs'       => 'xxs',
                    'xs'        => 'xs',
                    'mob'       => 'mob',
                    'sm'        => 'sm',
                    'md'        => 'md',
                    'lg'        => 'lg',
                    'xl'        => 'xl',
                    'xxl'       => 'xxl',
                    'ultrawide' => 'ultrawide',
                ],
            ])
            ->addNumber('padding_top', [
                'label'   => 'Padding Top',
                'min'     => 0,
                'max'     => 20,
                'step'    => 0.1,
                'append'  => 'rem',
            ])
            ->addNumber('padding_bottom', [
                'label'   => 'Padding Bottom',
                'min'     => 0,
                'max'     => 20,
                'step'    => 0.1,
                'append'  => 'rem',
            ])
        ->endRepeater();

return $cta_002;

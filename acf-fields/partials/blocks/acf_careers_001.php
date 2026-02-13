<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$careers_001 = new FieldsBuilder('careers_001', ['label' => 'Careers 001']);

$careers_001
    ->addTab('Content')
        ->addRepeater('careers', [
            'label' => 'Job Positions',
            'layout' => 'block',
            'button_label' => 'Add Job',
        ])
            ->addText('title', ['label' => 'Job Title'])
            ->addText('type', ['label' => 'Position Type'])
            ->addText('experience', ['label' => 'Experience'])
            ->addText('location', ['label' => 'Location'])
            ->addLink('apply_link', ['label' => 'Apply Link'])
        ->endRepeater()

    ->addTab('Design')
        ->addColorPicker('text_color', ['label' => 'Text Color'])
        ->addColorPicker('background_color', ['label' => 'Background Color'])

    ->addTab('Layout')
        ->addRepeater('padding_settings', [
            'label' => 'Padding Settings',
            'instructions' => 'Customize padding for different screen sizes.',
            'button_label' => 'Add Padding',
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

return $careers_001;

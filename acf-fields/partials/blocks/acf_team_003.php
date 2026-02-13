<?php
use StoutLogic\AcfBuilder\FieldsBuilder;

$team_003 = new FieldsBuilder('team_003', ['label' => 'Team 003']);

$team_003
    ->addTab('Content')
        ->addText('heading', [
            'label' => 'Heading',
            'default_value' => 'Your dedicated team',
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
                'span' => 'Span',
                'p' => 'Paragraph',
            ],
            'default_value' => 'h2',
        ])
        ->addRepeater('team_members', [
            'label' => 'Team Members',
            'layout' => 'block',
        ])
            ->addImage('image', [
                'label' => 'Image',
                'return_format' => 'array',
            ])
            ->addText('name', ['label' => 'Name'])
            ->addText('role', ['label' => 'Role'])
        ->endRepeater()
    ->addTab('Design')
        ->addColorPicker('text_color', [
            'label' => 'Heading Text Color',
            'default_value' => '#334155',
        ])
        ->addColorPicker('caption_text_color', [
            'label' => 'Name Text Color',
            'default_value' => '#334155',
        ])
        ->addColorPicker('role_text_color', [
            'label' => 'Role Text Color',
            'default_value' => '#64748b',
        ])
        ->addColorPicker('bg_color', [
            'label' => 'Card Background Color',
            'default_value' => '#ffffff',
        ])
        ->addSelect('border_radius', [
            'label' => 'Image Border Radius',
            'choices' => [
                'rounded-none' => 'None',
                'rounded-sm' => 'Small',
                'rounded' => 'Default',
                'rounded-lg' => 'Large',
                'rounded-xl' => 'XL',
                'rounded-2xl' => '2XL',
            ],
            'default_value' => 'rounded-2xl',
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
                'min' => 0, 'max' => 20, 'step' => 0.1, 'append' => 'rem',
            ])
            ->addNumber('padding_bottom', [
                'label' => 'Padding Bottom',
                'min' => 0, 'max' => 20, 'step' => 0.1, 'append' => 'rem',
            ])
        ->endRepeater();
return $team_003;

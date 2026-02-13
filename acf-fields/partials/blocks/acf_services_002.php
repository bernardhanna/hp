<?php
use StoutLogic\AcfBuilder\FieldsBuilder;

$services_002 = new FieldsBuilder('services_002', [
    'label' => 'Services Repeater',
]);

$services_002
    ->addTab('Content')
        ->addText('section_heading', [
            'label' => 'Section Heading',
            'instructions' => 'Enter the main heading for this section.',
        ])
        ->addRepeater('services', [
            'label' => 'Service Cards',
            'layout' => 'block',
            'button_label' => 'Add Service Card',
        ])
            ->addImage('icon', [
                'label' => 'Icon',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
                'instructions' => 'Upload the icon image.',
            ])
            ->addText('title', [
                'label' => 'Title',
                'required' => 1,
            ])
            ->addTextArea('description', [
                'label' => 'Description',
                'instructions' => 'Enter the service description.',
            ])
             ->addLink('link', [
                'label' => 'Card Link',
                'instructions' => 'Optional. Add a link for the service card.',
            ])
        ->endRepeater()

    ->addTab('Layout')
        ->addRepeater('padding_settings', [
            'label' => 'Padding Settings',
            'instructions' => 'Customize top/bottom padding per screen size.',
            'button_label' => 'Add Padding',
        ])
            ->addSelect('screen_size', [
                'label' => 'Screen Size',
                'choices' => [
                    'xxs' => 'xxs', 'xs' => 'xs', 'mob' => 'mob', 'sm' => 'sm',
                    'md' => 'md', 'lg' => 'lg', 'xl' => 'xl', 'xxl' => 'xxl', 'ultrawide' => 'ultrawide',
                ],
            ])
            ->addNumber('padding_top', [
                'label' => 'Padding Top', 'min' => 0, 'max' => 20, 'step' => 0.1, 'append' => 'rem',
            ])
            ->addNumber('padding_bottom', [
                'label' => 'Padding Bottom', 'min' => 0, 'max' => 20, 'step' => 0.1, 'append' => 'rem',
            ])
        ->endRepeater();

return $services_002;

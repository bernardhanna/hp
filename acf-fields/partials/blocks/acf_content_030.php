<?php
use StoutLogic\AcfBuilder\FieldsBuilder;

$content_030 = new FieldsBuilder('content_030', [
    'label' => 'Why Hanley Pepper',
]);

$content_030
    ->addTab('Content')
        ->addText('section_heading', ['label' => 'Section Heading', 'default_value' => 'Why Hanley Pepper'])
        ->addTextarea('section_intro', ['label' => 'Intro Text', 'rows' => 3])
        ->addRepeater('features', [
            'label' => 'Features',
            'button_label' => 'Add Feature',
        ])
            ->addLink('link', ['label' => 'Nav Link', 'required' => 0])
            ->addImage('bg_image', [
                'label' => 'Background Image',
                'return_format' => 'array',
            ])
            ->addText('heading', ['label' => 'Card Heading', 'required' => 0])
            ->addText('description', ['label' => 'Card Description', 'required' => 0])
        ->endRepeater()
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
            ->addNumber('padding_top', ['label' => 'Padding Top', 'min' => 0, 'max' => 20, 'step' => 0.1, 'append' => 'rem'])
            ->addNumber('padding_bottom', ['label' => 'Padding Bottom', 'min' => 0, 'max' => 20, 'step' => 0.1, 'append' => 'rem'])
        ->endRepeater();

return $content_030;


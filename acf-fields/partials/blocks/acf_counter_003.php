<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$counter_003 = new FieldsBuilder('counter_003', [
    'label' => 'Counter 003',
]);

$counter_003
    ->addTab('Content')
        ->addImage('image', [
            'label' => 'Left Circle Image',
            'return_format' => 'array',
            'preview_size' => 'medium',
        ])
        ->addText('heading_text', ['label' => 'Heading Text', 'default_value' => 'Our stats'])
        ->addSelect('heading_tag', [
            'label' => 'Heading Tag',
            'choices' => [
                'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6',
                'p' => 'Paragraph', 'span' => 'Span',
            ],
            'default_value' => 'h2',
        ])
        ->addNumber('projects_value', ['label' => 'Projects Stat Value', 'step' => 0.1])
        ->addText('projects_description', ['label' => 'Projects Description'])
        ->addNumber('energy_value', ['label' => 'Energy Stat Value', 'step' => 0.1])
        ->addText('energy_description', ['label' => 'Energy Description'])
        ->addNumber('clients_value', ['label' => 'Clients Stat Value', 'step' => 0.1])
        ->addText('clients_description', ['label' => 'Clients Description'])
        ->addNumber('incidents_value', ['label' => 'Incidents Stat Value', 'step' => 0.1])
        ->addText('incidents_description', ['label' => 'Incidents Description']);

return $counter_003;
?>

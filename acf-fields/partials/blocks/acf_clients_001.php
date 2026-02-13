<?php
use StoutLogic\AcfBuilder\FieldsBuilder;

$clients_001 = new FieldsBuilder('clients_001', [
    'label' => 'Clients 001',
]);

$clients_001
    ->addTab('Content')
        ->addRepeater('clients', [
            'label'        => 'Client Cards',
            'layout'       => 'block',
            'button_label' => 'Add Client',
        ])
            ->addImage('background_image', [
                'label'         => 'Background Image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
            ])
            ->addText('subtitle', [
                'label'    => 'Subtitle',
                'required' => 1,
            ])
            ->addText('client_name', [
                'label'    => 'Client Name',
                'required' => 1,
            ])
            ->addLink('client_link', [
                'label'         => 'Client Link',
                'return_format' => 'array',
            ])
            ->addImage('cta_icon', [
                'label'         => 'CTA Icon',
                'return_format' => 'array',
                'preview_size'  => 'thumbnail',
                'instructions'  => 'Arrow icon for the CTA button.',
            ])
        ->endRepeater()

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

return $clients_001;


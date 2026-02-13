<?php
use StoutLogic\AcfBuilder\FieldsBuilder;

$related_001 = new FieldsBuilder('related_001', [
    'label' => 'Related Services',
]);

$related_001
    ->addTab('Content')
        ->addText('heading', [
            'label' => 'Section Heading',
            'default_value' => 'Related services',
        ])
        ->addSelect('heading_tag', [
            'label' => 'Heading Tag',
            'choices' => [
                'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3',
                'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6',
                'span' => 'Span', 'p' => 'Paragraph',
            ],
            'default_value' => 'h2',
        ])
        ->addSelect('link_source', [
            'label' => 'Link Source',
            'choices' => [
                'auto_terms' => 'Automated (attached taxonomy terms)',
                'manual' => 'Manual (repeater links)',
            ],
            'default_value' => 'auto_terms',
        ])
        ->addText('taxonomy', [
            'label' => 'Taxonomy Slug',
            'instructions' => 'Defaults to "project_category".',
            'default_value' => 'project_category',
            'conditional_logic' => [[['field' => 'link_source', 'operator' => '==', 'value' => 'auto_terms']]],
        ])
        ->addTrueFalse('only_current_post_terms', [
            'label' => 'Only Terms Attached To This Post',
            'default_value' => 1,
            'ui' => 1,
            'conditional_logic' => [[['field' => 'link_source', 'operator' => '==', 'value' => 'auto_terms']]],
        ])
        ->addTaxonomy('selected_terms', [
            'label' => 'Select Specific Terms (optional)',
            'instructions' => 'Used if "Only Terms Attached" is off.',
            'taxonomy' => 'project_category',
            'field_type' => 'multi_select',
            'add_term' => 0,
            'save_terms' => 0,
            'load_terms' => 0,
            'return_format' => 'id',
            'conditional_logic' => [
                [
                    ['field' => 'link_source', 'operator' => '==', 'value' => 'auto_terms'],
                    ['field' => 'only_current_post_terms', 'operator' => '==', 'value' => '0'],
                ]
            ],
        ])
        ->addNumber('max_items', [
            'label' => 'Max Links (0 = no limit)',
            'min' => 0, 'max' => 50, 'step' => 1,
            'default_value' => 0,
            'conditional_logic' => [[['field' => 'link_source', 'operator' => '==', 'value' => 'auto_terms']]],
        ])
        ->addSelect('term_orderby', [
            'label' => 'Order Terms By',
            'choices' => [
                'name' => 'Name',
                'slug' => 'Slug',
                'count' => 'Count',
                'term_id' => 'Term ID',
                'none' => 'None',
            ],
            'default_value' => 'name',
            'conditional_logic' => [[['field' => 'link_source', 'operator' => '==', 'value' => 'auto_terms']]],
        ])
        ->addSelect('term_order', [
            'label' => 'Order',
            'choices' => ['ASC' => 'ASC', 'DESC' => 'DESC'],
            'default_value' => 'ASC',
            'conditional_logic' => [[['field' => 'link_source', 'operator' => '==', 'value' => 'auto_terms']]],
        ])

        // Manual
        ->addRepeater('services', [
            'label' => 'Related Services (Manual)',
            'layout' => 'table',
            'button_label' => 'Add Service',
            'conditional_logic' => [[['field' => 'link_source', 'operator' => '==', 'value' => 'manual']]],
        ])
            ->addLink('link', [
                'label' => 'Service Link',
                'return_format' => 'array',
            ])
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
                'instructions' => 'Set the top padding in rem.',
                'min' => 0, 'max' => 20, 'step' => 0.1, 'append' => 'rem',
            ])
            ->addNumber('padding_bottom', [
                'label' => 'Padding Bottom',
                'instructions' => 'Set the bottom padding in rem.',
                'min' => 0, 'max' => 20, 'step' => 0.1, 'append' => 'rem',
            ])
        ->endRepeater();

return $related_001;

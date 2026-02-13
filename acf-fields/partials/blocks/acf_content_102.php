<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$content_102 = new FieldsBuilder('content_102', [
    'label' => 'Content 102 - Company About Section',
]);

$content_102

// Content Tab
->addTab('Content', ['placement' => 'top'])
->addSelect('heading_tag', [
    'label' => 'Heading Tag',
    'instructions' => 'Select the appropriate heading level for SEO and accessibility.',
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
->addText('heading_text', [
    'label' => 'Heading Text',
    'instructions' => 'Enter the main heading text.',
    'placeholder' => 'Enter your heading text...',
    'default_value' => 'Established in 1987',
])
->addWysiwyg('paragraph_text', [
    'label' => 'Paragraph Content',
    'instructions' => 'Enter the main content paragraphs. Use the editor to format text and add line breaks.',
    'default_value' => '<p>Hanley Pepper is a private limited company established in 1987, by Kevin Pepper and Denis Hanley. The current Directors, Joe Ryan (Managing) and Michael Jackson together with Kevin Pepper as consultant, have guided the company through phased expansion which has realised the design and completion of projects nationally and internationally.</p><p>Hanley Pepper is also the Republic of Ireland members of MERGE. This is European network of Established and Experienced Consulting Engineers. Members collaborate to offer the engineering design and advisory services to clients across national and international borders.</p>',
    'tabs' => 'all',
    'toolbar' => 'full',
])
->addLink('button_link', [
    'label' => 'Button Link',
    'instructions' => 'Configure the call-to-action button link.',
    'return_format' => 'array',
    'default_value' => [
        'url' => '#',
        'title' => 'More about our team',
        'target' => '_self',
    ],
])
->addTrueFalse('show_button_icon', [
    'label' => 'Show Button Icon',
    'instructions' => 'Display an arrow icon next to the button text.',
    'ui' => 1,
    'default_value' => 1,
])

// Design Tab
->addTab('Design', ['placement' => 'top'])
->addColorPicker('background_color', [
    'label' => 'Section Background Color',
    'instructions' => 'Set the background color for the entire section.',
    'default_value' => '#FFFFFF',
])
->addColorPicker('heading_color', [
    'label' => 'Heading Text Color',
    'instructions' => 'Set the color for the main heading.',
    'default_value' => '#14532d',
])
->addColorPicker('text_color', [
    'label' => 'Paragraph Text Color',
    'instructions' => 'Set the color for the paragraph text.',
    'default_value' => '#475569',
])
->addColorPicker('button_bg_color', [
    'label' => 'Button Background Color',
    'instructions' => 'Set the button background color.',
    'default_value' => 'transparent',
])
->addColorPicker('button_text_color', [
    'label' => 'Button Text Color',
    'instructions' => 'Set the button text color.',
    'default_value' => '#475569',
])
->addColorPicker('button_border_color', [
    'label' => 'Button Border Color',
    'instructions' => 'Set the button border color.',
    'default_value' => '#d97706',
])
->addColorPicker('button_hover_bg_color', [
    'label' => 'Button Hover Background Color',
    'instructions' => 'Set the button background color on hover.',
    'default_value' => '#d97706',
])
->addColorPicker('button_hover_text_color', [
    'label' => 'Button Hover Text Color',
    'instructions' => 'Set the button text color on hover.',
    'default_value' => '#FFFFFF',
])
->addColorPicker('button_hover_border_color', [
    'label' => 'Button Hover Border Color',
    'instructions' => 'Set the button border color on hover.',
    'default_value' => '#d97706',
])

// Layout Tab
->addTab('Layout', ['placement' => 'top'])
->addRepeater('padding_settings', [
    'label' => 'Padding Settings',
    'instructions' => 'Customize padding for different screen sizes.',
    'button_label' => 'Add Screen Size Padding',
    'layout' => 'table',
])
->addSelect('screen_size', [
    'label' => 'Screen Size',
    'instructions' => 'Select the screen size for this padding setting.',
    'choices' => [
        'xxs' => 'XXS (Extra Extra Small)',
        'xs' => 'XS (Extra Small)',
        'mob' => 'Mobile',
        'sm' => 'SM (Small)',
        'md' => 'MD (Medium)',
        'lg' => 'LG (Large)',
        'xl' => 'XL (Extra Large)',
        'xxl' => 'XXL (Extra Extra Large)',
        'ultrawide' => 'Ultrawide',
    ],
    'default_value' => 'lg',
])
->addNumber('padding_top', [
    'label' => 'Padding Top',
    'instructions' => 'Set the top padding in rem.',
    'min' => 0,
    'max' => 20,
    'step' => 0.1,
    'append' => 'rem',
    'default_value' => 5,
])
->addNumber('padding_bottom', [
    'label' => 'Padding Bottom',
    'instructions' => 'Set the bottom padding in rem.',
    'min' => 0,
    'max' => 20,
    'step' => 0.1,
    'append' => 'rem',
    'default_value' => 5,
])
->endRepeater();

return $content_102;

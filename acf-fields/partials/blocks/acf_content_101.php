<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$content_101 = new FieldsBuilder('content_101', [
    'label' => 'Content 101 - Image + Text',
]);

$content_101

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
    'default_value' => 'Proactive approach',
])
->addImage('main_image', [
    'label' => 'Main Image',
    'instructions' => 'Upload the main image for this section. Recommended size: 896x540px.',
    'return_format' => 'array',
    'preview_size' => 'medium',
])
->addWysiwyg('paragraph_text', [
    'label' => 'Paragraph Text',
    'instructions' => 'Enter the descriptive text content.',
    'toolbar' => 'basic',
    'media_upload' => 0,
    'default_value' => '<p>Our project referrals are testament to the extra service we provide on project. Our reputation is based on a proactive approach to project delivery and problem solving on challenges faced by design team and building contractor. At Hanley Pepper your project is our pride and we deliver the management and energised team you need to realise your project on time, on budget and beyond expectation.</p>',
])

// Design Tab
->addTab('Design', ['placement' => 'top'])
->addColorPicker('background_color', [
    'label' => 'Background Color',
    'instructions' => 'Set the background color for the section.',
    'default_value' => '#FFFFFF',
])
->addColorPicker('heading_color', [
    'label' => 'Heading Text Color',
    'instructions' => 'Set the color for the heading text.',
    'default_value' => '#475569', // slate-600
])
->addColorPicker('text_color', [
    'label' => 'Paragraph Text Color',
    'instructions' => 'Set the color for the paragraph text.',
    'default_value' => '#334155', // slate-700
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
    'min' => 0,
    'max' => 20,
    'step' => 0.1,
    'append' => 'rem',
    'default_value' => 3.5, // 14 * 0.25rem = 3.5rem
])
->addNumber('padding_bottom', [
    'label' => 'Padding Bottom',
    'instructions' => 'Set the bottom padding in rem.',
    'min' => 0,
    'max' => 20,
    'step' => 0.1,
    'append' => 'rem',
    'default_value' => 3.5, // 14 * 0.25rem = 3.5rem
])
->endRepeater();

return $content_101;

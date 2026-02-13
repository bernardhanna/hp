<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$content_100 = new FieldsBuilder('content_100', [
    'label' => 'Content 100',
]);

$content_100

// Content Tab
->addTab('Content', ['placement' => 'top'])
->addImage('main_image', [
    'label' => 'Main Image',
    'instructions' => 'Upload the main image for this section.',
    'return_format' => 'array',
])
->addSelect('subheading_tag', [
    'label' => 'Subheading Tag',
    'instructions' => 'Select the HTML tag for the subheading.',
    'choices' => [
        'h1' => 'H1',
        'h2' => 'H2',
        'h3' => 'H3',
        'h4' => 'H4',
        'h5' => 'H5',
        'h6' => 'H6',
        'span' => 'Span',
        'p' => 'Paragraph',
        'div' => 'Div',
    ],
    'default_value' => 'div',
])
->addText('subheading_text', [
    'label' => 'Subheading Text',
    'instructions' => 'Enter the subheading text.',
    'placeholder' => 'Subheading',
    'default_value' => 'Subheading',
])
->addSelect('heading_tag', [
    'label' => 'Main Heading Tag',
    'instructions' => 'Select the HTML tag for the main heading.',
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
    'label' => 'Main Heading Text',
    'instructions' => 'Enter the main heading text.',
    'placeholder' => 'Member of Merge Consultants',
    'default_value' => 'Member of Merge Consultants',
])
->addWysiwyg('description_text', [
    'label' => 'Description Text',
    'instructions' => 'Enter the description text content.',
    'default_value' => '<p>Lorem ipsum dolor sit amet consectetur. Feugiat vitae cursus tempus nibh. Amet odio malesuada id pharetra turpis tellus purus non facilisis. Varius est quis auctor.</p>',
    'media_upload' => 0,
    'toolbar' => 'basic',
])
->addRepeater('bullet_items', [
    'label' => 'Bullet List Items',
    'instructions' => 'Add bullet point items for the list.',
    'button_label' => 'Add Bullet Item',
    'min' => 0,
    'max' => 10,
])
->addText('bullet_text', [
    'label' => 'Bullet Text',
    'instructions' => 'Enter the text for this bullet point.',
    'placeholder' => 'Lorem ipsum id pharetra turpis tellus purus',
])
->endRepeater()
->addLink('button_link', [
    'label' => 'CTA Button Link',
    'instructions' => 'Configure the call-to-action button.',
    'return_format' => 'array',
    'default_value' => [
        'url' => '#',
        'title' => 'CTA button',
        'target' => '_self',
    ],
])
->addTrueFalse('button_icon_toggle', [
    'label' => 'Show Button Icon',
    'instructions' => 'Toggle to show/hide the arrow icon on the button.',
    'ui' => 1,
    'default_value' => 1,
])

// Design Tab
->addTab('Design', ['placement' => 'top'])
->addColorPicker('background_color', [
    'label' => 'Section Background Color',
    'instructions' => 'Choose the background color for the section.',
    'default_value' => '#f9fafb',
])
->addColorPicker('subheading_color', [
    'label' => 'Subheading Text Color',
    'instructions' => 'Choose the color for the subheading text.',
    'default_value' => '#64748b',
])
->addColorPicker('heading_color', [
    'label' => 'Main Heading Text Color',
    'instructions' => 'Choose the color for the main heading text.',
    'default_value' => '#64748b',
])
->addColorPicker('description_color', [
    'label' => 'Description Text Color',
    'instructions' => 'Choose the color for the description and bullet text.',
    'default_value' => '#334155',
])
->addColorPicker('bullet_color', [
    'label' => 'Bullet Point Color',
    'instructions' => 'Choose the color for the bullet points.',
    'default_value' => '#064e3b',
])
->addColorPicker('button_bg_color', [
    'label' => 'Button Background Color',
    'instructions' => 'Choose the background color for the button.',
    'default_value' => '#ffffff',
])
->addColorPicker('button_text_color', [
    'label' => 'Button Text Color',
    'instructions' => 'Choose the text color for the button.',
    'default_value' => '#334155',
])
->addColorPicker('button_border_color', [
    'label' => 'Button Border Color',
    'instructions' => 'Choose the border color for the button.',
    'default_value' => '#d97706',
])
->addColorPicker('button_hover_bg_color', [
    'label' => 'Button Hover Background Color',
    'instructions' => 'Choose the background color for the button on hover.',
    'default_value' => '#d97706',
])
->addColorPicker('button_hover_text_color', [
    'label' => 'Button Hover Text Color',
    'instructions' => 'Choose the text color for the button on hover.',
    'default_value' => '#ffffff',
])
->addColorPicker('button_hover_border_color', [
    'label' => 'Button Hover Border Color',
    'instructions' => 'Choose the border color for the button on hover.',
    'default_value' => '#d97706',
])

// Layout Tab
->addTab('Layout', ['placement' => 'top'])
->addRepeater('padding_settings', [
    'label' => 'Padding Settings',
    'instructions' => 'Customize padding for different screen sizes.',
    'button_label' => 'Add Screen Size Padding',
    'min' => 0,
    'max' => 10,
])
->addSelect('screen_size', [
    'label' => 'Screen Size',
    'instructions' => 'Select the screen size for this padding setting.',
    'choices' => [
        'xxs' => 'XXS',
        'xs' => 'XS',
        'mob' => 'Mobile',
        'sm' => 'Small',
        'md' => 'Medium',
        'lg' => 'Large',
        'xl' => 'Extra Large',
        'xxl' => 'XXL',
        'ultrawide' => 'Ultrawide',
    ],
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

return $content_100;

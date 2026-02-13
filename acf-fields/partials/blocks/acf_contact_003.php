<?php
use StoutLogic\AcfBuilder\FieldsBuilder;

$contact_003 = new FieldsBuilder('contact_003', [
    'label' => 'Contact 003',
]);

$contact_003
    ->addTab('Content')
        ->addText('subheading', ['label' => 'Subheading'])
        ->addText('heading', ['label' => 'Heading'])
        ->addSelect('heading_tag', [
            'label' => 'Heading Tag',
            'choices' => [
                'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3',
                'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6',
                'p' => 'Paragraph', 'span' => 'Span'
            ],
            'default_value' => 'h1',
        ])
        ->addWysiwyg('description', [
            'label' => 'Description',
            'media_upload' => 0,
            'tabs' => 'visual',
            'wrapper' => ['class' => 'wp_editor']
        ])
        ->addText('form_heading', ['label' => 'Form Heading'])
        ->addSelect('form_heading_tag', [
            'label' => 'Form Heading Tag',
            'choices' => [
                'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3',
                'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6',
                'p' => 'Paragraph', 'span' => 'Span'
            ],
            'default_value' => 'h2',
        ])
       ->addWysiwyg( 'form_markup', [
			'label'         => 'Form HTML (paste static form here)',
			'toolbar'       => 'basic',
			'media_upload'  => 0,
			'wrapper'       => [ 'class' => 'wp_editor' ],
		] )
    ->addTab( 'Email' )
        ->addText( 'form_name', [
            'label'       => 'Internal Form Name',
            'instructions'=> 'A label saved with each entry & used in email subject. Optional.',
        ] )
		->addEmail( 'email_to',     [ 'label' => 'Send To' ] )
		->addText(  'email_bcc',    [ 'label' => 'BCC' ] )
		->addText(  'email_subject',[ 'label' => 'Subject', 'default_value'=>'Website enquiry' ] )
		->addTrueFalse( 'save_entries_to_db', [ 'label'=>'Save to DB?', 'ui'=>1 ] )

	->addTab( 'Autoresponder' )
		->addTrueFalse( 'enable_autoresponder', [ 'label'=>'Enable?', 'ui'=>1 ] )
		->addText( 'autoresponder_subject', [
			'conditional_logic' => [ [ [ 'field'=>'enable_autoresponder','operator'=>'==','value'=>1 ] ] ],
		] )
		->addWysiwyg( 'autoresponder_message', [
			'conditional_logic' => [ [ [ 'field'=>'enable_autoresponder','operator'=>'==','value'=>1 ] ] ],
			'wrapper' => [ 'class' => 'wp_editor' ],
		] )
    ->addTab('Design')
        ->addColorPicker('background_color', ['label' => 'Background Color'])
        ->addColorPicker('text_color', ['label' => 'Text Color'])

    ->addTab('Layout')
        ->addRepeater('padding_settings', [
            'label' => 'Padding Settings',
            'button_label' => 'Add Padding',
        ])
            ->addSelect('screen_size', [
                'label' => 'Screen Size',
                'choices' => [
                    'xxs' => 'xxs', 'xs' => 'xs', 'mob' => 'mob',
                    'sm' => 'sm', 'md' => 'md', 'lg' => 'lg',
                    'xl' => 'xl', 'xxl' => 'xxl', 'ultrawide' => 'ultrawide',
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

return $contact_003;



<?php
use StoutLogic\AcfBuilder\FieldsBuilder;

add_action('acf/init', function () {
    acf_add_options_page([
        'page_title'    => get_bloginfo('name') . ' Theme Options',
        'menu_title'    => 'Theme Options',
        'menu_slug'     => 'theme-options',
        'capability'    => 'edit_theme_options',
        'position'      => 999,
        'autoload'      => true,
        'update_button' => 'Update Options',
    ]);

    $dir    = __DIR__ . '/theme-options/';
    $files  = glob($dir . '*.php');

    $options = new FieldsBuilder('theme_options', ['style' => 'seamless']);
    $options->setLocation('options_page', '==', 'theme-options');

    foreach ($files as $path) {
        $fields = require $path;                    // include & capture return
        if ( ! is_array($fields) && ! $fields instanceof FieldsBuilder ) {
            continue;                               // skip if the file didn’t return a field group
        }

        $file  = basename($path, '.php');
        $label = str_replace(['-', '_'], ' ', $file);
        $label = $file === '404' ? '404 Page' : ucwords($label);

        $options
            ->addTab($label, ['placement' => 'left'])
            ->addFields($fields);
    }

    acf_add_local_field_group($options->build());
});
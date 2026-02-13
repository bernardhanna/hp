<?php
/**
 * When a Projects post is opened for the first time
 * pre-populate the flexible-content field with one
 * “hero_project” row so editors don’t have to add it.
 */
add_filter(
    'acf/load_value/name=hero_content_blocks',
    function ( $value, $post_id ) {

        if ( empty( $value ) && get_post_type( $post_id ) === 'projects' ) {
            $value = [
                [ 'acf_fc_layout' => 'hero_project' ],   // layout slug
            ];
        }
        return $value;
    },
    10,
    2
);

/**
 * Pre-populate the first flexi block for new Projects
 */
add_filter('acf/load_value/name=flexible_content_blocks', function( $value, $post_id, $field ) {
    if ( empty( $value ) && get_post_type( $post_id ) === 'projects' ) {
        $value = [
            [ 'acf_fc_layout' => 'related_001' ],
            [ 'acf_fc_layout' => 'projects_001' ],
        ];
    }
    return $value;
}, 10, 3);
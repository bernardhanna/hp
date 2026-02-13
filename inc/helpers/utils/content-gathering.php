<?php
function mcc_url_to_image_id($url) {
    global $wpdb;
    if (!$url) return null;

    $upload_dir_paths = wp_upload_dir();
    if (strpos($url, $upload_dir_paths['baseurl']) !== false) {
        $relative_path = str_replace($upload_dir_paths['baseurl'] . '/', '', $url);
        $id = $wpdb->get_var($wpdb->prepare(
            "SELECT ID FROM $wpdb->posts WHERE guid LIKE %s AND post_type = 'attachment'",
            '%' . $wpdb->esc_like($relative_path)
        ));
        return (int) $id;
    }
    return null;
}
<?php

function san_spe_is_expired($post_id = 0) {
    $expires = get_post_meta($post_id, 'san_spe_expiration', true);
    if (!empty($expires)) {
        $current_time = current_time('timestamp');
        $expires = strtotime($expires, $current_time);
        if ($current_time >= $expires) return true;
    }
    return false;
}

function san_spe_title($title = '', $post_id = 0) {
    if (san_spe_is_expired($post_id)) {
        $prefix = get_option('san_spe_prefix', __('Expired', 'san-spe'));
        $title = $prefix.'&nbsp;'.$title;
    }
    return $title;
}
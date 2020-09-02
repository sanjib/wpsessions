<?php

function san_spe_shortcodes_expires($attrs, $content = null) {
    $attrs = shortcode_atts([
        'expires_on' => __('This item will expire on %s!', 'san-spe'),
        'expired_on' => __('This item has already expired on %s!', 'san-spe'),
        'date_format' => get_option('date_format', 'F j, Y'),
        'class' => 'san-spe-post-expiration',
        'id' => 'san-spe-post-expiration-%d',
    ], $attrs, 'san_spe');

    $post_id = get_the_ID();
    $div_id = esc_attr(sprintf($attrs['id'], $post_id));
    $div_class = esc_attr($attrs['class']);

    $expires = get_post_meta($post_id, 'san_spe_expiration', true);
    $expires_formatted = date_i18n($attrs['date_format'], strtotime($expires));

    $expired_text = san_spe_is_expired($post_id) ? $attrs['expired_on'] : $attrs['expires_on'];
    $expired_text = sprintf($expired_text, $expires_formatted);

    return "<div id='$div_id' class='$div_class'>$expired_text</div>";
}

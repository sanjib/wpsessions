<?php

function san_spe_settings_init() {
    register_setting('reading', 'san_spe_prefix', 'sanitize_text_field');
    add_settings_field('san_spe_prefix',
        __('Prefix Text for Expired Posts', 'san-spe'),
        'san_spe_settings_field',
        'reading',
        'default');
}

function san_spe_settings_field() {
    $prefix = get_option('san_spe_prefix', __('Expired', 'san-spe'));
    $prefix = esc_attr($prefix);
    echo "<input name='san_spe_prefix' type='text' value='$prefix' class='regular-text' />";
    echo "<p class='description'>".
        __("Enter text that will be prefixed to the title of expired posts", 'san-spe').
        ".</p>";
}

<?php

function san_spe_settings_init() {
    register_setting('reading', 'san_spe_prefix', 'sanitize_text_field');
    add_settings_field('san_spe_prefix', 'Prefix Text for Expired Posts', 'san_spe_settings_field', 'reading', 'default');
}

function san_spe_settings_field() {
    $prefix = get_option('san_spe_prefix', 'EXPIRED');
    $prefix = esc_attr($prefix);
    echo "<input name='san_spe_prefix' type='text' value='$prefix' class='regular-text' />";
    echo "<p class='description'>Enter text that will be prefixed to the title of expired posts.</p>";
}

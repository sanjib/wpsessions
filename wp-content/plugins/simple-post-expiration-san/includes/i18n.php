<?php

function san_spe_i18n_text_domain() {
    load_plugin_textdomain( 'san-spe',
        false,
        dirname(plugin_basename(__FILE__)).'/../languages');
}
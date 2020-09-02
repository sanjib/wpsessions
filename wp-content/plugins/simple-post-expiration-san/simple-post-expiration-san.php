<?php
/*
 * Plugin Name: Simple Post Expiration
 * Version: 1.0.1
 * Author: Sanjib Ahmad
 * Author URI: https://virtual-apps.com
 * Description: A simple plugin that allows you to set an expiration date on posts. Requires "Classic Editor" plugin.
 * Text Domain: san-spe
 * Domain Path: languages
 * License: Apache License, Version 2.0
 * License URI: http://www.apache.org/licenses/LICENSE-2.0
 *
 * Copyright 2020 Sanjib Ahmad
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

// DEFINES && REQUIRES
define('SAN_SPE_ASSETS_URL', plugin_dir_url(__FILE__).'assets');

require_once dirname(__FILE__).'/includes/common.php';
require_once dirname(__FILE__).'/includes/shortcodes.php';
require_once dirname(__FILE__).'/includes/widgets.php';

if (is_admin()) {
    require_once dirname(__FILE__) . '/includes/metabox.php';
    require_once dirname(__FILE__) . '/includes/settings.php';
}

//------------------- HOOKS: FILTERS & ACTIONS --------------------//

// COMMON
add_filter('the_title', 'san_spe_title', 100, 2);

// SHORTCODES
add_shortcode('expires', 'san_spe_shortcodes_expires');

// WIDGETS
add_action('widgets_init', 'san_spe_widgets_register');

if (is_admin()) {
    // METABOX
    add_action('post_submitbox_misc_actions', 'san_spe_metabox');
    add_action('save_post', 'san_spe_metabox_save');
    add_action('load-post-new.php', 'san_spe_metabox_scripts');
    add_action('load-post.php', 'san_spe_metabox_scripts');

    // SETTINGS
    add_action('admin_init', 'san_spe_settings_init');
}


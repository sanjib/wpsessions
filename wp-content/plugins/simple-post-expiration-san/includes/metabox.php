<?php

function san_spe_metabox() {
    global $post;
    if (!empty($post->ID)) {
        $expires = get_post_meta($post->ID, 'san_spe_expiration', true);
    }
    $label = !empty($expires) ? date_i18n('Y-n-d', strtotime($expires)) : __('never', 'san-spe');
    $date  = !empty($expires) ? date_i18n('Y-n-d', strtotime($expires)) : '';
    ?>
    <div id="san-spe-expiration-wrap" class="misc-pub-section">
        <span>
            <span class="wp-media-buttons-icon dashicons dashicons-calendar"></span>&nbsp;
            <?php _e( 'Expires', 'san-spe' ); ?>:
            <b id="san-spe-expiration-label"><?php echo $label; ?></b>
        </span>
        <a href="#" id="san-spe-edit-expiration" class="san-spe-edit-expiration hide-if-no-js">
            <span aria-hidden="true"><?php _e( 'Edit', 'san-spe' ); ?></span>
            <span class="screen-reader-text"><?php _e( 'Edit date and time', 'san-spe' ); ?></span>
        </a>
        <div id="san-spe-expiration-field" class="hide-if-js">
            <p>
                <input type="text"
                       name="san_spe_expiration"
                       id="san_spe_expiration"
                       autocomplete="off"
                       value="<?php echo esc_attr( $date ); ?>"
                       placeholder="yyyy-mm-dd"/>
            </p>
            <p>
                <a href="#" class="san-spe-hide-expiration button secondary"><?php _e( 'OK', 'san-spe' ); ?></a>
                <a href="#" class="san-spe-hide-expiration cancel"><?php _e( 'Cancel', 'san-spe' ); ?></a>
            </p>
        </div>
        <?php wp_nonce_field( 'san_spe_edit_expiration', 'san_spe_expiration_nonce' ); ?>
    </div>
    <?php
}

function san_spe_metabox_save($post_id = 0) {
    //-- GUARDS START
    if (
        (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) ||
        (defined('DOING_AJAX') && DOING_AJAX) ||
        isset($_REQUEST['bulk_edit'])
    ) {
        return;
    }
    if (!empty($_POST['san_spe_edit_expiration'])) return;
    if (!wp_verify_nonce($_POST['san_spe_expiration_nonce'], 'san_spe_edit_expiration')) return;
    if (!current_user_can('edit_post', $post_id)) return;
    //-- GUARDS END

    $expiration = !empty($_POST['san_spe_expiration']) ? sanitize_text_field($_POST['san_spe_expiration']) : false;
    if ($expiration) {
        // SAVE THE EXPIRATION DATE
        update_post_meta($post_id, 'san_spe_expiration', $expiration);
    } else {
        // REMOVE ANY EXISTING EXPIRATION DATE
        delete_post_meta($post_id, 'san_spe_expiration');
    }
}

function san_spe_metabox_scripts() {
    wp_enqueue_style('jquery-ui-css', SAN_SPE_ASSETS_URL.'/css/jquery-ui-fresh.min.css');

    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_script('jquery-ui-slider');
    wp_enqueue_script('san_spe_expiration', SAN_SPE_ASSETS_URL.'/js/edit.js');
}

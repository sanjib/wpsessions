<?php

function san_spe_widgets_register() {
    register_widget('SanSpeWidget');
}

class SanSpeWidget extends WP_Widget {
    function SanSpeWidget() {
        parent::__construct(false,
            __('Expired / Expiring Posts', 'san-spe'),
            [
                'description' => __('Display a list of expired or expiring posts', 'san-spe'),
            ]
        );
    }

    function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title'], $instance);
        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'].$title.$args['after_title'];
        }

        $query_args = [
            'post_type' => 'any',
            'orderby' => 'meta_value',
            'meta_key' => 'san_spe_expiration',
            'posts_per_page' => $instance['number'],
            'meta_query' => [
                [
                    'key' => 'san_spe_expiration',
                    'value' => date('Y-n-d', current_time('timestamp')),
                    'compare' => 'expiring' == $instance['type'] ? '>=' : '<',
                    'type' => 'DATETIME',
                ],
            ],
        ];
        $items = get_posts($query_args);
        if($items) {
            remove_filter( 'the_title', 'san_spe_title', 100 );
            echo '<ul class="pw-spe-items">';
            foreach($items as $item) {
                echo '<li>';
                echo '<a href="'.
                    esc_url(get_permalink($item->ID)).
                    '" title="'.esc_attr(get_the_title($item->ID)).'">'.
                    get_the_title($item->ID).'</a>';
                echo '</li>';
            }
            echo '</ul>';
            add_filter('the_title', 'san_spe_title', 100, 2);
        }

        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['type'] = strip_tags($new_instance['type']);
        $instance['number'] = absint($new_instance['number']);

        return $instance;
    }

    function form($instance) {
        $title = isset($instance['title']) ? $instance['title'] : '';
        $type = isset($instance['type']) ? $instance['type'] : 'expiring';
        $number = isset($instance['number']) ? $instance['number'] : 5;
        ?>
        <p>
            <label for="<?= esc_attr($this->get_field_id('title')) ?>">
                <?= __('Title', 'san-spe') ?>:
            </label>
            <input class="widefat"
                   name="<?= esc_attr($this->get_field_name('title')) ?>"
                   id="<?= esc_attr($this->get_field_id('title')) ?>"
                   value="<?= esc_attr($title) ?>"
                   type="text" />
        </p>

        <span>
            <?= __('Type', 'san-spe') ?>:
        </span> &nbsp;
        <label>
            <input name="<?= esc_attr($this->get_field_name('type')) ?>"
                   value="expiring" <?= checked("expiring", $type) ?>
                   type="radio" />
            <?php _e('Expiring soon', 'san-spe') ?>
        </label>
        &nbsp;&nbsp;&nbsp;
        <label>
            <input name="<?= esc_attr($this->get_field_name('type')) ?>"
                   value="expired" <?= checked("expired", $type) ?>
                   type="radio" />
            <?php _e('Expired', 'san-spe') ?>
        </label>

        <p>
            <label for="<?= esc_attr($this->get_field_id('number')) ?>">
                <?= __('Number of Posts to Show', 'san-spe') ?>:
            </label>
            <input class="tinytext"
                   name="<?= esc_attr($this->get_field_name('number')) ?>"
                   id="<?= esc_attr($this->get_field_id('number')) ?>"
                   value="<?= esc_attr($number) ?>"
                   type="text" />
        </p>

        <?php
    }
}
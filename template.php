add_action('widgets_init', 'register_info_about_widgets');
function register_info_about_widgets() {
    register_widget( 'our_contacts_widget' );
}
 
// Enqueue additional admin scripts
add_action('admin_enqueue_scripts', 'ctup_wdscript');
function ctup_wdscript() {
    wp_enqueue_media();
    wp_enqueue_script('ads_script', get_template_directory_uri() . '/assets/js/widget.js', false, '1.0.0', true);
}
 
class info_about_widget extends WP_Widget {

    function info_about_widget() {
        //$widget_ops = array('classname' => 'ctUp-ads');
        $this->WP_Widget('info-about-widget', 'Лого и текст'/*, $widget_ops*/);
    }

    function widget($args, $instance) {
        ?>
        <a class="footer__logo" href="/"><img class="img-fluid" src="<?php echo esc_url($instance['image_uri']); ?>" alt="Logo"></a>
        <div class="footer-info"><?php echo apply_filters('widget_title', $instance['text'] ); ?></div>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['text'] = strip_tags( $new_instance['text'] );
        $instance['image_uri'] = strip_tags( $new_instance['image_uri'] );
        return $instance;
    }

    function form($instance) {
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('text'); ?>">Произвольный текст о нас</label><br />
            <textarea name="<?php echo $this->get_field_name('text'); ?>" id="<?php echo $this->get_field_id('text'); ?>" class="widefat" rows="4"><?php echo $instance['text']; ?></textarea>
        </p>
        <p>
            <label for="<?= $this->get_field_id( 'image_uri' ); ?>">Лого</label>
            <img class="<?= $this->id ?>_img" src="<?= (!empty($instance['image_uri'])) ? $instance['image_uri'] : ''; ?>" style="margin:0;padding:0;max-width:100%;display:block"/>
            <input type="text" class="widefat <?= $this->id ?>_url" name="<?= $this->get_field_name( 'image_uri' ); ?>" value="<?= $instance['image_uri']; ?>" style="margin-top:5px;" />
            <input type="button" id="<?= $this->id ?>" class="button button-primary js_custom_upload_media" value="Выбрать лого" style="margin-top:5px;" />
        </p>

        <?php
    }
}

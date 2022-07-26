<?php

?>

<div class="ga-tst-form">
<!-- Testimonial role field -->
<div class="ga-tst-form__input ga-tst-form__input-role">
        <label class="ga-tst-form__input-role__label" for="tst_role"><?php _e( 'Nationality', 'yith-clubs-cristian' ); ?></label>
        <input type="text" class="ga-tst-form__input-role__input" name="_yith_cr_nationality" id="tst_role"
               value="<?php echo esc_html( get_post_meta( $post->ID, '_yith_cr_nationality', true ) ); ?>">
               <label class="ga-tst-form__input-role__label" for="tst_role"><?php _e( 'Number shirt', 'yith-clubs-cristian' ); ?></label>
        <input type="text" class="ga-tst-form__input-role__input" name="_yith_cr_number" id="tst_role"
               value="<?php echo esc_html( get_post_meta( $post->ID, '_yith_cr_number', true ) ); ?>">
    </div>
</div>
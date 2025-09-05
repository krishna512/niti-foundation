<?php

/**
 * =========================================================
 * One button component for all the button types
 * =========================================================
 *
 */

function button_layout($args = [])
{
    // Get the button type - primary, secondary or tertiary.
    $button_type = (isset($args['button_type'])) ? $args['button_type'] : 'secondary';
    $text = (isset($args['text'])) ? $args['text'] : "Apply Now!";
    $link = (isset($args['link'])) ? $args['link'] : "#";
    $class_name = (isset($args['class_name'])) ? $args['class_name'] : "";
    ob_start();
    ?>

    <button class='xs:max-w-fit bg-transparent<?php echo $class_name; ?>'>
        <a href="<?php echo $link; ?>">
            <div class="button button--<?php echo $button_type; ?>">
                <span class="block xs:min-w-[135px]"> <?php echo $text ?> </span>
            </div>
        </a>
    </button>
    <?php $button_layout = ob_get_contents();
    ob_end_clean();

    return $button_layout;
}

function btn_layout_1($btn, $btn_link)
{
    ob_start();
    ?>
    <a href="<?php echo $btn_link; ?> " class="view-all-btn" <?php echo (get_post_type() == 'consultancy') ? 'target="_blank"' : ''; ?>>
        <?php echo $btn; ?>
        <span class="text-sm view-icon">
            <?php echo useSvg('right-arrow'); ?>
        </span>
    </a>
    <?php
    $btn_layout_1_return = ob_get_contents();
    ob_end_clean();

    return $btn_layout_1_return;
}
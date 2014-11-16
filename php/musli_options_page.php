<div class="wrap">

    <h2>Musli - Settings</h2>
    
    <noscript>
        <div class="error message">
            <p><?php _e('This plugin require enebled JavaScript to work properly.', 'musli'); ?></p>
        </div>
    </noscript>

    <?php if (!empty($notice)): ?>
    <div id="notice" class="error"><p><?php echo $notice ?></p></div>
    <?php endif;?>
    <?php if (!empty($message)): ?>
    <div id="message" class="updated"><p><?php echo $message ?></p></div>
    <?php endif;?>

<form action="options.php" method="POST">

    <?php settings_fields('musli_config_group'); ?>
    <?php $options = get_option('musli_config'); ?>

    <div class="musli-options-section">
        <?php _e('<h3>Position on screen</h3>', 'musli'); ?>
        <ul id="musli-position">
            <li>
                <label title="Musli position">
                    <input type='radio' name='musli_config[position]' value='right' <?php checked( $options['position'], 'right' ); ?> />
                    <?php _e('right', 'musli'); ?><br />
                    <img src="<?php echo MUSLI_URL . '/img/musli-position-right.png'; ?>" alt="Musli position RIGHT" />
                </label>
            </li>

            <li>
                <label>
                    <input type='radio' name='musli_config[position]' value='top' <?php checked( $options['position'], 'top' ); ?> />
                    <?php _e('top', 'musli'); ?><br />
                    <img src="<?php echo MUSLI_URL . '/img/musli-position-top.png'; ?>" alt="Musli position TOP" />
                </label>
            </li>

            <li>
                <label>
                    <input type='radio' name='musli_config[position]' value='bottom' <?php checked( $options['position'], 'bottom' ); ?> />
                    <?php _e('bottom', 'musli'); ?><br />
                    <img src="<?php echo MUSLI_URL . '/img/musli-position-bottom.png'; ?>" alt="Musli position BOTTOM" />
                </label>
            </li>

            <li>
                <label>
                    <input type='radio' name='musli_config[position]' value='left' <?php checked( $options['position'], 'left' ); ?> />
                    <?php _e('left', 'musli'); ?><br />
                    <img src="<?php echo MUSLI_URL . '/img/musli-position-left.png'; ?>" alt="Musli position LEFT" />
                </label>
            </li>
        </ul>

    </div> <!-- end musli-options-section -->


    <div class="musli-options-section">
        <?php _e('<h3>Global CSS settings</h3>', 'musli'); ?>

        <table>

            <tr valign="top">
                <th><?php _e('Margin from browser\'s edge: ', 'musli'); ?></th>
                <td>
                    <input type="text" class="small-text code" name="musli_config[margin_b_edge]" value="<?php echo $options['margin_b_edge']; ?>" /> [%]
                </td>
            </tr>

            <tr valign="top">
                <th><?php _e('Margin between tabs: ', 'musli'); ?></th>
                <td>
                    <input type="text" class="small-text code" name="musli_config[margin_b_tabs]" value="<?php echo $options['margin_b_tabs']; ?>" /> [px]
                </td>
            </tr>

            <tr valign="top">
                <th><?php _e('Padding: ', 'musli'); ?></th>
                <td>
                    <input type="text" class="small-text code" name="musli_config[padding]" value="<?php echo $options['padding']; ?>" /> [px]
                </td>
            </tr>

            <tr valign="top">
                <th><?php _e('Tab\'s width: ', 'musli'); ?></th>
                <td>
                    <input type="text" class="small-text code" name="musli_config[width]" value="<?php echo $options['width']; ?>" /> [px]
                </td>
            </tr>

            <tr valign="top">
                <th><?php _e('Tab\'s height:  ', 'musli'); ?></th>
                <td>
                    <input type="text" class="small-text code" name="musli_config[height]" value="<?php echo $options['height']; ?>" /> [px]
                </td>
            </tr>

            <tr valign="top">
                <th><?php _e('Hide MUSLI on page width:  ', 'musli'); ?></th>
                <td>
                    <input type="text" class="small-text code" name="musli_config[hide_on_width]" value="<?php echo $options['hide_on_width']; ?>" /> [px]
                    <?php _e('<p class="musli-desc">Enter 0 value for no hidding.</p>', 'musli'); ?>
                </td>
            </tr>

            <tr valign="top">
                <th><?php _e('Tab\'s border color:  ', 'musli'); ?></th>
                <td>
                    <input type="text" name="musli_config[border_color]" value="<?php echo $options['border_color']; ?>" class="musli-border-color" />
                </td>
            </tr>

            <tr valign="top">
                <th><?php _e('Tab\'s border thickness: ', 'musli'); ?></th>
                <td>
                    <input type="text" class="small-text code" name="musli_config[border_width]" value="<?php echo $options['border_width']; ?>" /> [px]
                </td>
            </tr>

            <tr valign="top">
                <th><?php _e('Tab\'s background color:  ', 'musli'); ?></th>
                <td>
                    <input type="text" name="musli_config[background_color]" value="<?php echo $options['background_color']; ?>" class="musli-background-color" />
                </td>
            </tr>

            <tr valign="top">
                <th><?php _e('Tab\'s icon width: ', 'musli'); ?></th>
                <td>
                    <input type="text" class="small-text code" name="musli_config[icon_width]" value="<?php echo $options['icon_width']; ?>" /> [px]
                </td>
            </tr>

            <tr valign="top">
                <th><?php _e('Tab\'s icon height:  ', 'musli'); ?></th>
                <td>
                    <input type="text" class="small-text code" name="musli_config[icon_height]" value="<?php echo $options['icon_height']; ?>" /> [px]
                </td>
            </tr>

            <tr valign="top">
                <th><?php _e('Rounded corners:  ', 'musli'); ?></th>
                <td>
                    <input type="checkbox" name="musli_config[rounded_corners]" value="on" <?php checked( $options['rounded_corners'], 'on' ); ?> />
                </td>
            </tr>

        </table>
        
        <?php _e('<p class="musli-desc"><strong>NOTE: </strong>Some global CSS settings might be overwritten by individual tab settings.</p>', 'musli'); ?>

    </div> <!-- end musli-options-section -->

    <div class="musli-options-section">
        <?php _e('<h3>Animation settings</h3>', 'musli'); ?>
        <table>

            <tr valign="top">
                <th><?php _e('Animation after: ', 'musli'); ?></th>
                <td>
                    <fieldset>
                        <label title='Animation after'>
                            <input type='radio' name='musli_config[animation_after]' value='hover' <?php checked( $options['animation_after'], 'hover' ); ?> /> <span><?php _e('Hover', 'musli'); ?></span>
                        </label><br />
                        <label title='Animation after'>
                            <input type='radio' name='musli_config[animation_after]' value='click' <?php checked( $options['animation_after'], 'click' ); ?> /> <span><?php _e('Click', 'musli'); ?></span>
                        </label><br />
                    </fieldset>
                </td>
            </tr>

            <tr valign="top">
                <th><?php _e('Animation speed: ', 'musli'); ?></th>
                <td>
                    <select name="musli_config[animation_speed]">
                        <option value="300"  <?php selected( $options['animation_speed'], '300' ); ?>>300</option>
                        <option value="500"  <?php selected( $options['animation_speed'], '500' ); ?>>500</option>
                        <option value="700"  <?php selected( $options['animation_speed'], '700' ); ?>>700</option>
                        <option value="800"  <?php selected( $options['animation_speed'], '800' ); ?>>800</option>
                        <option value="1000" <?php selected( $options['animation_speed'], '1000' ); ?>>1000</option>
                        <option value="1200" <?php selected( $options['animation_speed'], '1200' ); ?>>1200</option>
                    </select> [ms]
                </td>
            </tr>

        </table>
    </div> <!-- end musli-options-section -->

    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />

</form>

</div><!-- end wrap -->


<script>
jQuery(function(){
    jQuery('.musli-border-color, .musli-background-color').wpColorPicker();
});
</script>
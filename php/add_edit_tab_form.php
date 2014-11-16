<div class="wrap">

    <h2>Musli - Settings</h2>

    <noscript>
        <div class="error message">
            <p><?php _e('JavaScript is required!', 'musli') ?></p>
        </div>
    </noscript>

    <?php if (!empty($notice)): ?>
    <div id="notice" class="error"><p><?php echo $notice ?></p></div>
    <?php endif;?>
    <?php if (!empty($message)): ?>
    <div id="message" class="updated"><p><?php echo $message ?></p></div>
    <?php endif;?>

<!-- <pre>
    <?php //print_r($tab_options); ?>
</pre> -->

<?php if($status != 'inserted'): ?>

<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    
    <?php wp_nonce_field('add-edit-tab-form','musli-validate-form'); ?>

    <div class="musli-options-section">
        <?php _e('<h3>General tab option</h3>', 'musli'); ?>
        
        <table>

            <tr>
                <th><?php _e('Tab name: ', 'musli'); ?></th>
                <td>
                    <input type="text" class="code" name="name" value="<?php echo htmlspecialchars($tab_options['name']); ?>" size="36" placeholder="My tab name" required />
                </td>
            </tr>

             <tr>
                <th><?php _e('Tab type: ', 'musli'); ?></th>
                <td>
                    <select name="type" id="tab_preset">
                        <option value="facebook" <?php selected( $tab_options['type'], 'facebook' ); ?>><?php _e('Facebook Likebox', 'musli'); ?></option>
                        <option value="google" <?php selected( $tab_options['type'], 'google' ); ?>><?php _e('Google+ Badge', 'musli'); ?></option>
                        <option value="twitter" <?php selected( $tab_options['type'], 'twitter' ); ?>><?php _e('Twitter Timeline', 'musli'); ?></option>
                        <option value="widget" <?php selected( $tab_options['type'], 'widget' ); ?>><?php _e('Widget area', 'musli'); ?></option>
                        <option value="custom" <?php selected( $tab_options['type'], 'custom' ); ?>><?php _e('Custom', 'musli'); ?></option>
                    </select>
                </td>
            </tr>

        </table>

    </div> <!-- end musli-options-section -->



<!-- CUSTOM tab form -->
    <div class="musli-options-section" id="tab_form_custom">
        <?php _e('<h3>Tab type specific options - Custom</h3>', 'musli'); ?>
        
        <table>

            <tr>
                <th valign="top"><?php _e('Content: ', 'musli'); ?></th>
                <td>
                    <textarea name="custom_content" id="" cols="50" rows="8" placeholder="Paste here your custom content."><?php echo urldecode(stripslashes($tab_options['custom_content'])); ?></textarea>
                    <?php _e('<p class="musli-desc">In most cases it is better to use widget tab instead.</p>', 'musli'); ?>
                </td>
            </tr>

        </table>

    </div> <!-- end musli-options-section -->




<!-- FACEBOOK form -->
    <div class="musli-options-section" id="tab_form_facebook">
        <?php _e('<h3>Tab type specific options - Facebook LikeBox</h3>', 'musli'); ?>
        
        <table>

            <tr>
                <th valign="top"><?php _e('Facebook Page URL: ', 'musli'); ?></th>
                <td>
                    <input type="text" size="36" name="fb_url" value="<?php echo urldecode($tab_options['fb_url']); ?>" />
                    <?php _e('<p class="musli-desc">Example: https://www.facebook.com/NewDividepl</p>', 'musli'); ?>
                </td>
            </tr>

            <tr>
                <th valign="top"><?php _e('LikeBox width: ', 'musli'); ?></th>
                <td>
                    <input type="text" class="small-text code" name="fb_width" value="<?php echo $tab_options['fb_width']; ?>" /> [px]
                </td>
            </tr>
            <tr>
                <th valign="top"><?php _e('LikeBox height: ', 'musli'); ?></th>
                <td>
                    <input type="text" class="small-text code" name="fb_height" value="<?php echo $tab_options['fb_height']; ?>" /> [px]
                </td>
            </tr>
            <tr>
                <th valign="top"><?php _e('Color Scheme: ', 'musli'); ?></th>
                <td>
                    <select name="fb_color_scheme">
                        <option value="light" <?php selected( $tab_options['fb_color_scheme'], 'light' ); ?>><?php _e('light', 'musli'); ?></option>
                        <option value="dark"  <?php selected( $tab_options['fb_color_scheme'], 'dark' ); ?>><?php _e('dark', 'musli'); ?></option>
                    </select>                    
                </td>
            </tr>
            <tr>
                <th valign="top"><?php _e('Show Friends\' Faces: ', 'musli'); ?></th>
                <td>
                    <input type="checkbox" name="fb_show_faces" value="true" <?php checked( $tab_options['fb_show_faces'], 'true' ); ?> />
                </td>
            </tr>
            <tr>
                <th valign="top"><?php _e('Show Header: ', 'musli'); ?></th>
                <td>
                    <input type="checkbox" name="fb_show_header" value="true" <?php checked( $tab_options['fb_show_header'], 'true' ); ?> />
                </td>
            </tr>
            <tr>
                <th valign="top"><?php _e('Show Posts: ', 'musli'); ?></th>
                <td>
                    <input type="checkbox" name="fb_show_posts" value="true" <?php checked( $tab_options['fb_show_posts'], 'true' ); ?> />
                </td>
            </tr>
            <tr>
                <th valign="top"><?php _e('Show Border: ', 'musli'); ?></th>
                <td>
                    <input type="checkbox" name="fb_show_border" value="true" <?php checked( $tab_options['fb_show_border'], 'true' ); ?> />
                </td>
            </tr>
        </table>

    </div> <!-- end musli-options-section -->



<!-- google form  -->
<!-- https://developers.google.com/+/web/badge/ -->

    <div class="musli-options-section" id="tab_form_google">
        <?php _e('<h3>Tab type specific options - Google+</h3>', 'musli'); ?>
        
        <table>

            <tr>
                <th valign="top"><?php _e('Google+ ID: ', 'musli'); ?></th>
                <td>
                    <input type="text" size="36" name="gp_id" value="<?php echo $tab_options['gp_id']; ?>" />
                    <?php _e('<p class="musli-desc">Example: 105865537512501982443</p>', 'musli'); ?>
                </td>
            </tr>

            <tr>
                <th valign="top"><?php _e('Width: ', 'musli'); ?></th>
                <td>
                    <input type="text" class="small-text code" name="gp_width" value="<?php echo $tab_options['gp_width']; ?>" /> [px]
                </td>
            </tr>

            <tr>
                <th valign="top"><?php _e('Color Theme: ', 'musli'); ?></th>
                <td>
                    <select name="gp_color_scheme">
                        <option value="light" <?php selected( $tab_options['gp_color_scheme'], 'light' ); ?>><?php _e('light', 'musli'); ?></option>
                        <option value="dark"  <?php selected( $tab_options['gp_color_scheme'], 'dark' ); ?>><?php _e('dark', 'musli'); ?></option>
                    </select>                    
                </td>
            </tr>

            <tr>
                <th valign="top"><?php _e('Cover photo: ', 'musli'); ?></th>
                <td>
                    <input type="checkbox" name="gp_cover_photo" value="true" <?php checked( $tab_options['gp_cover_photo'], 'true' ); ?> />
                </td>
            </tr>

            <tr>
                <th valign="top"><?php _e('Tagline: ', 'musli'); ?></th>
                <td>
                    <input type="checkbox" name="gp_tagline" value="true" <?php checked( $tab_options['gp_tagline'], 'true' ); ?> />
                </td>
            </tr>

        </table>

    </div> <!-- end musli-options-section -->


<!-- twitter form -->
    <div class="musli-options-section" id="tab_form_twitter">
        <?php _e('<h3>Tab type specific options - Twitter</h3>', 'musli'); ?>
        
        <table>
            <tr>
                <th valign="top"><?php _e('User name: ', 'musli'); ?></th>
                <td>
                    <input type="text" size="36" name="tw_user_name" value="<?php echo $tab_options['tw_user_name']; ?>" />
                    <?php _e('<p class="musli-desc">Example: ziemekpr0</p>', 'musli'); ?>
                </td>
            </tr>


            <tr>
                <th valign="top"><?php _e('Widget ID: ', 'musli'); ?></th>
                <td>
                    <input type="text" size="36" name="tw_widget_id" value="<?php echo $tab_options['tw_widget_id']; ?>" />
                    <?php _e('<p class="musli-desc">Example: 351349730481160192</p>', 'musli'); ?>
                </td>
            </tr>

        </table>
        <?php _e('<p class="musli-desc">Please visit <a href="https://twitter.com/settings/widgets/">https://twitter.com/settings/widgets/</a> for more information.</p>', 'musli'); ?>
    </div> <!-- end musli-options-section -->



<!-- widget form -->
    <div class="musli-options-section" id="tab_form_widget">
        <?php _e('<h3>Tab type specific options - widget area</h3>', 'musli'); ?>

        <table>

            <tr>
                <th valign="top"><?php _e('Sidebar CSS ID: ', 'musli'); ?></th>
                <td>
                    <input type="text" size="36" name="widget_id" value="<?php echo $tab_options['widget_id']; ?>" />
                    <?php _e('<p class="musli-desc">You can use this id, to add CSS styles to your widget. Example: my-sidebar</p>', 'musli'); ?>
                </td>
            </tr>

        </table>
        <?php _e('<p class="musli-desc">After saving, go to your Dashboard menu, Apperiance &rarr; Widget, and drop some widget on your new widget area.</p>', 'musli'); ?>
    </div> <!-- end musli-options-section -->



    <div class="musli-options-section">
        <?php _e('<h3>Icon image</h3>', 'musli'); ?>
        
        <table>
            <tr valign="top">
                <th><?php _e('Upload your image: ', 'musli'); ?></th>
                <td>
                    <label for="upload_image">
                        <input id="upload_image" type="text" size="36" name="img_url" value="<?php echo $tab_options['img_url']; ?>" />
                        <input id="upload_image_button" class="button" type="button" value="Upload Image" />
                        <?php _e('<p class="musli-desc">Enter URL or upload image</p>', 'musli'); ?>
                    </label>
                </td>
            </tr>
        </table>

    </div> <!-- end musli-options-section -->

    <div class="musli-options-section">
        <?php _e('<h3>Custom CSS options</h3>', 'musli'); ?>


        <table>
            <tr valign="top">
                <th><?php _e('Use custom CSS for this tab: ', 'musli'); ?></th>
                <td>
                    <input type="checkbox" name="custom_css_on" value="on" <?php checked( $tab_options['custom_css_on'], 'on' ); ?> />
                </td>
            </tr>

            <tr valign="top">
                <th><?php _e('Tab width: ', 'musli'); ?></th>
                <td>
                    <input type="text" class="small-text code" name="tab_width" value="<?php echo $tab_options['tab_width']; ?>" /> [px]
                </td>
            </tr>

            <tr valign="top">
                <th><?php _e('Tab height: ', 'musli'); ?></th>
                <td>
                    <input type="text" class="small-text code" name="tab_height" value="<?php echo $tab_options['tab_height']; ?>" /> [px]
                </td>
            </tr>

            <tr valign="top">
                <th><?php _e('Tab border color: ', 'musli'); ?></th>
                <td>
                    <input type="text" name="tab_border_color" value="<?php echo $tab_options['tab_border_color']; ?>" class="musli-color-picker" />
                </td>
            </tr>

            <tr valign="top">
                <th><?php _e('Tab background color: ', 'musli'); ?></th>
                <td>
                    <input type="text" name="tab_bg" value="<?php echo $tab_options['tab_bg']; ?>" class="musli-color-picker" />
                </td>
            </tr>

        </table>

        <?php _e('<p class="musli-desc">Global CSS settings will be overwritten by individual tab settings.</p>', 'musli'); ?>
        
    </div> <!-- end musli-options-section -->


    <input type="submit" name="submit_data" class="button-primary" value="<?php _e('Save Changes') ?>" />

</form>

<?php else: ?>


    <div class="musli-options-section">
        <?php _e('<h3>What\'s next?</h3>', 'musli'); ?>
        <ul>
            <li><a href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=musli-form'); ?>"><?php _e('Add another tab', 'musli'); ?></a></li>
            <li><a href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=musli'); ?>"><?php _e('Manage your tabs (change order, edit or delete)', 'musli'); ?></a></li>
            <li><a href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=musli-options'); ?>"><?php _e('View global options', 'musli'); ?></a></li>
        </ul>
        <?php _e('<p class="musli-desc">Or go back to your page view, and check out current result.</p>', 'musli'); ?>
    </div> <!-- end musli-options-section -->


<?php endif; ?>

</div><!-- end wrap -->


<script>
jQuery(function(){
    jQuery('.musli-color-picker').wpColorPicker();

    var custom_uploader;
    jQuery('#upload_image_button').click(function(e) {
        e.preventDefault();
 
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
 
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            jQuery('#upload_image').val(attachment.url);
        });
        
        custom_uploader.open();
    });

    var current_form = '#tab_form_' + jQuery('#tab_preset option:selected').val();
    jQuery(current_form).show();

    jQuery('#tab_preset').change(function(){
        var tab_form = '#tab_form_' + jQuery(this).val();

        jQuery("div[id^='tab_form_']").slideUp();
        jQuery(tab_form).slideDown();

    });

});
</script>
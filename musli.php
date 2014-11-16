<?php
/*
Plugin Name: Musli
Text Domain: musli
Plugin URI: http://musli.newdivide.pl/
Description: Musli is a small, flexible tabs slider. This plugin creates a set of animated tabs attached to one side of browser's window (you decide which one). You can add as many tabs as you need, and place on them anything you like. Using built in presets you can quickly configure for example Facebook LikeBox plugin, or Google+ Badge, other than that you can even use your widgets.
Version: 1.0
Author: ziemekpr0@gmail.com
Author URI: http://newdivide.pl
License: GPLv2 or later
*/

/* SECURITY - BLOCK DIRECT ACCESS */

if (!defined('ABSPATH')) exit('No direct script access allowed');

/* GLOBAL PATHS AND CONSTANTS */

if (!defined('MUSLI_DIR_NAME'))
    define('MUSLI_DIR_NAME', 'musli');

if (!defined('MUSLI_DIR_PATH'))
    define('MUSLI_DIR_PATH', plugin_dir_path( __FILE__ ));

if (!defined('MUSLI_URL'))
    define('MUSLI_URL', WP_PLUGIN_URL . '/' . MUSLI_DIR_NAME);

if (!defined('MUSLI_VERSION'))
    define('MUSLI_VERSION', '1.0');

class Musli
{
    // default options
    private static $musli_defaults = array(
        'position'          => 'right',
        'margin_b_edge'     => 20,
        'margin_b_tabs'     => 2,
        'width'             => 300,
        'height'            => 300,
        'border_color'      => '#1e73be',
        'border_width'      => 3,
        'background_color'  => '#ffffff',
        'padding'           => 5,
        'icon_width'        => 35,
        'icon_height'       => 35,
        'rounded_corners'   => 'off',
        'hide_on_width'     => 1200,
        'use_fa'            => 'on',
        'use_jq_effects'    => 'off',
        'animation_after'   => 'hover',
        'animation_speed'   => 700,
        'animation_easing'  => 'linear',
        'start_with_opened' => 'off',
        'start_tab_id'      => 1,
        'autohide_tab'      => 'off',
        'autohide_after'    => 5000,
        'autoopen'          => 'off',
        'autoopen_tab_id'   => 1,
        'autoopen_after'    => 5000
    );

    public function __construct()
    {
        add_action('admin_init', array(&$this, 'admin_init'));
        add_action('admin_menu', array(&$this, 'admin_menu'));
        add_action('admin_enqueue_scripts', array(&$this, 'admin_scripts'));
        add_action('wp_enqueue_scripts', array(&$this, 'user_scripts'));
        add_action('wp_ajax_update_tabs_order', array(&$this, 'update_tabs_order'));
        add_action('wp_footer', array(&$this, 'echo_musli'));
        add_action('widgets_init', array(&$this, 'register_sidebars'));
        // messages
        add_action('admin_notices', array(&$this, 'options_error'));
        // enable shortcodes on text widget
        add_filter('widget_text', 'do_shortcode');
        // activation deactivation hooks
        register_activation_hook(__FILE__, array('Musli', 'activate'));
        register_deactivation_hook(__FILE__, array('Musli', 'deactivate'));
    }

    // ADD MENU OPTIONS TO DASHBOARD
    public function admin_menu()
    {
        add_menu_page('Musli', 'Musli', 'manage_options', 'musli', array(&$this, 'view_tabs_list'), 'dashicons-exerpt-view');
            add_submenu_page('musli', 'Musli', 'Musli', 'manage_options', 'musli', array(&$this, 'view_tabs_list'));
            add_submenu_page('musli', 'Add new tab', 'Add new tab', 'manage_options', 'musli-form', array(&$this, 'view_add_edit_tab_form'));
            add_submenu_page('musli', 'Options', 'Options', 'manage_options', 'musli-options', array(&$this, 'view_options_form'));
        
        //add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
        //add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
    }

    public function admin_init()
    {
        // needed for plugin translations
        load_plugin_textdomain('musli', FALSE, MUSLI_DIR_PATH . '/lang/' );

        register_setting( 'musli_config_group', 'musli_config', array( $this, 'sanitize_global_options' ) );
    }

    public function sanitize_global_options($options)
    {
        $sanitized_options = array(
            'position'          => (isset($options['position'])) ? sanitize_text_field($options['position']) : '',
            'margin_b_edge'     => (isset($options['margin_b_edge'])) ? absint($options['margin_b_edge']) : '',
            'margin_b_tabs'     => (isset($options['margin_b_tabs'])) ? absint($options['margin_b_tabs']) : '',
            'width'             => (isset($options['width'])) ? absint($options['width']) : '',
            'height'            => (isset($options['height'])) ? absint($options['height']) : '',
            'border_color'      => (isset($options['border_color'])) ? sanitize_text_field($options['border_color']) : '',
            'border_width'      => (isset($options['border_width'])) ? absint($options['border_width']) : '',
            'background_color'  => (isset($options['background_color'])) ? sanitize_text_field($options['background_color']) : '',
            'padding'           => (isset($options['padding'])) ? absint($options['padding']) : '',
            'icon_width'        => (isset($options['icon_width'])) ? absint($options['icon_width']) : '',
            'icon_height'       => (isset($options['icon_height'])) ? absint($options['icon_height']) : '',
            'rounded_corners'   => (isset($options['rounded_corners'])) ? sanitize_text_field($options['rounded_corners']) : '',
            'hide_on_width'     => (isset($options['hide_on_width'])) ? absint($options['hide_on_width']) : '',
            'use_fa'            => (isset($options['use_fa'])) ? sanitize_text_field($options['use_fa']) : 'off',
            'use_jq_effects'    => (isset($options['use_jq_effects'])) ? sanitize_text_field($options['use_jq_effects']) : '',
            'animation_after'   => (isset($options['animation_after'])) ? sanitize_text_field($options['animation_after']) : '',
            'animation_speed'   => (isset($options['animation_speed'])) ? absint($options['animation_speed']) : '',
            'animation_easing'  => (isset($options['animation_easing'])) ? sanitize_text_field($options['animation_easing']) : '',
            'start_with_opened' => (isset($options['start_with_opened'])) ? sanitize_text_field($options['start_with_opened']) : '',
            'start_tab_id'      => (isset($options['start_tab_id'])) ? absint($options['start_tab_id']) : '',
            'autohide_tab'      => (isset($options['autohide_tab'])) ? sanitize_text_field($options['autohide_tab']) : '',
            'autohide_after'    => (isset($options['autohide_after'])) ? absint($options['autohide_after']) : '',
            'autoopen'          => (isset($options['autoopen'])) ? sanitize_text_field($options['autoopen']) : '',
            'autoopen_tab_id'   => (isset($options['autoopen_tab_id'])) ? absint($options['autoopen_tab_id']) : '',
            'autoopen_after'    => (isset($options['autoopen_after'])) ? absint($options['autoopen_after']) : ''
        );
        
        // array_filter(array, 'strlen') removes all NULLs, FALSEs and Empty Strings but leaves 0 (zero) values
        $sanitized_options = wp_parse_args(array_filter($sanitized_options, 'strlen'), Musli::$musli_defaults);

        // UPDATE STYLESHEET WITH GIVEN OPTIONS
        $this->update_global_stylesheet($sanitized_options);
        add_settings_error( 'options_error',  '',  __('Your settings has been updated.', 'musli'), 'updated' );
        return $sanitized_options;
    }

    // LOAD ADMIN PAGE STYLES AND SCRIPTS
    public function admin_scripts($hook)
    {
        // LOAD SCRIPTS ONLY ON MUSLI PAGES
        if( strpos($hook, 'musli') === false )
        {
            return;
        }

        //scripts
        wp_enqueue_media();
        wp_enqueue_script( 'jQuery' );
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_script( 'wp-color-picker' );

        //stylesheets
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style( 'musli-admin', MUSLI_URL . '/css/musli-admin.css', array(), null );
    }

    // LOAD FRONTEND JAVASCRIPT SCRIPTS
    public function user_scripts()
    {
        wp_enqueue_style( 'musli', MUSLI_URL . '/css/musli.css', array(), null );

        $musli_options = get_option('musli_config');

        // include font awesome, only when its needed
        if($musli_options['use_fa'] == 'on')
            wp_enqueue_style( 'font-awesome', MUSLI_URL . '/fa/css/font-awesome.min.css', array(), null );

        wp_enqueue_script( 'jquery');
    
        $musli_options['animation_easing'] = Musli::$musli_defaults['animation_easing'];
        wp_enqueue_script( 'musli', MUSLI_URL . '/js/musli.js', array('jquery') );

        wp_localize_script('musli', 'musli_jq_params', array(
            'musliPosition'     => $musli_options['position'], 
            'animationAction'   => $musli_options['animation_after'], 
            'animationSpeed'    => $musli_options['animation_speed'],
            'animationEasing'   => $musli_options['animation_easing'],
            'autohide'          => $musli_options['autohide_tab'],
            'autohideAfter'     => $musli_options['autohide_after'],
            'autoopenAfter'     => $musli_options['autoopen_after']
        ));
    }

    // AJAX UPDATE TABS ORDER
    public function update_tabs_order()
    {
        //SECURITY CHECK
        if ( ! check_ajax_referer( 'tabs-order-nonce', 'ajax_nonce' ) )
            wp_die( __( 'You do not have sufficient permissions to access this page.', 'musli' ) );

        global $wpdb;
        $musli_table = $wpdb->prefix . "musli";

        $order = array();
        parse_str($_POST['order'], $order);

        if (is_array($order))
            foreach ( $order['musli'] as $key => $id )
            {
                $sql = $wpdb->prepare( "UPDATE $musli_table SET tab_order = %d WHERE id = %d", $key+1, $id );
                $wpdb->query( $sql );
            }

        die(); // this is required to return a proper result
    }

    public function view_tabs_list()
    {
        if ( !current_user_can( 'manage_options') )
        {
            wp_die( __( 'You do not have sufficient permissions to access this page.', 'musli' ) );
        }

        require_once('php/musli_list_table.php');
    }

    public function view_add_edit_tab_form()
    {
        if ( !current_user_can( 'manage_options') ) 
        {
            wp_die( __( 'You do not have sufficient permissions to access this page.', 'musli' ) );
        }

        $status = '';

        global $wpdb;
        $musli_table = $wpdb->prefix . "musli";

        $tab_defaults = array(
            'name'              => 'Default name',
            'type'              => 'facebook',
            'img_url'           => 'http://',
            'fa_on'             => 'off',
            'fa_class'          => 'fa-picture-o',
            'fa_bg'             => '#0170cf',
            'fa_font_color'     => '#ffffff',
            'fa_font_size'      => 14,
            'fa_spin'           => 'off',
            'custom_css_on'     => 'off',
            'tab_width'         => 300,
            'tab_height'        => 300,
            'tab_border_color'  => '#0170cf',
            'tab_bg'            => '#ffffff',
            'fb_url'            => '',
            'fb_width'          => 290,
            'fb_height'         => 290,
            'fb_color_scheme'   => 'light',
            'fb_show_faces'     => 'false',
            'fb_show_header'    => 'false',
            'fb_show_posts'     => 'false',
            'fb_show_border'    => 'false',
            'gp_id'             => '',
            'gp_width'          => 300,
            'gp_color_scheme'   => 'light',
            'gp_cover_photo'    => 'false',
            'gp_tagline'        => 'false',
            'tw_user_name'      => '',
            'tw_widget_id'      => '',
            'content'           => '',
            'widget_id'         => 'my-musli-sidebar',
            'custom_content'    => ''
        );

        $tab_options = array();

        // IF SO check if update or insert
        // ELSE check if editing and load data
        if (isset($_POST['submit_data']))
        {
            // SECURITY - NONCE CHECK
            if ( ! check_admin_referer( 'add-edit-tab-form', 'musli-validate-form' ) ) die( 'Failed security check.' );

            $tab_options = $this->sanitize_tab_options(wp_parse_args($_POST, $tab_defaults));
            //$insert = $this->sanitize_tab_options($tab_options);

            //update or insert
            if( isset($_REQUEST['tab_id']) && is_numeric($_REQUEST['tab_id']) )
            {
                $result = $wpdb->update( $musli_table, $tab_options, array('id'=>$_REQUEST['tab_id']) );
                
                if ( ! $result )
                    $notice = "There was an error while updating item.";
                else
                    $message = "Item was successfully updated.";
            }
            else
            {
                $result = $wpdb->insert( $musli_table, $tab_options );
                
                if ( ! $result )
                    $notice = "There was an error while inserting item.";
                else
                {
                    $message = "Item was successfully inserted.";
                    $status = "inserted";
                }
            }
        }

        // FILL UP FORM WITH DATABASE SETTINGS
        if(isset($_REQUEST['tab_id']))
        {
            $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $musli_table WHERE id = %d",$_REQUEST['tab_id']), ARRAY_A);

            if ( empty($row) )
            {
                wp_die(__('Database error. Could not find row with selected id.', 'musli') );
            }
            else
            {
                $tab_options = $tab_defaults;

                if(is_serialized($row['options']))
                {
                    $row_options = unserialize($row['options']);
                    $tab_options = wp_parse_args($row_options, $tab_options);
                }

                if(is_serialized($row['content']))
                {
                    $row_content = unserialize($row['content']);
                    $tab_options = wp_parse_args($row_content, $tab_options);
                }

                $tab_options = wp_parse_args($row, $tab_options);

            }
        }
        // FILL UP FORM WITH DEFAULT VALUES
        else
        {
            $tab_options = $tab_defaults;
        }


        require_once('php/add_edit_tab_form.php');
    }

    // ADD EDIT TAB FORM VALIDATION

    public function sanitize_tab_options($options)
    {
        $tab_type = sanitize_text_field($_POST['type']);

        $tab_options = array(
            'name'              => sanitize_text_field($options['name']),
            'type'              => $tab_type
        );

        $css_options = array(
            'img_url'           => esc_url($options['img_url']),
            'fa_on'             => sanitize_text_field($options['fa_on']),
            'fa_class'          => sanitize_text_field($options['fa_class']),
            'fa_bg'             => sanitize_text_field($options['fa_bg']),
            'fa_font_color'     => sanitize_text_field($options['fa_font_color']),
            'fa_font_size'      => absint($options['fa_font_size']),
            'fa_spin'           => sanitize_text_field($options['fa_spin']),
            'custom_css_on'     => sanitize_text_field($options['custom_css_on']),
            'tab_width'         => absint($options['tab_width']),
            'tab_height'        => absint($options['tab_height']),
            'tab_border_color'  => sanitize_text_field($options['tab_border_color']),
            'tab_bg'            => sanitize_text_field($options['tab_bg'])
        );

        //facebook, twitter, google, widget, custom
        switch($tab_type)
        {
            case 'facebook':
                $content = array(
                    'fb_url'            => esc_url($options['fb_url']),
                    'fb_width'          => absint($options['fb_width']),
                    'fb_height'         => absint($options['fb_height']),
                    'fb_color_scheme'   => sanitize_text_field($options['fb_color_scheme']),
                    'fb_show_faces'     => sanitize_text_field($options['fb_show_faces']),
                    'fb_show_header'    => sanitize_text_field($options['fb_show_header']),
                    'fb_show_posts'     => sanitize_text_field($options['fb_show_posts']),
                    'fb_show_border'    => sanitize_text_field($options['fb_show_border']),
                );
            break;
            
            case 'google':
                $content = array(
                    'gp_id'             => sanitize_text_field($options['gp_id']),
                    'gp_width'          => absint($options['gp_width']),
                    'gp_color_scheme'   => sanitize_text_field($options['gp_color_scheme']),
                    'gp_cover_photo'    => sanitize_text_field($options['gp_cover_photo']),
                    'gp_tagline'        => sanitize_text_field($options['gp_tagline']),
                );
            break;

            case 'twitter':
                $content = array(
                    'tw_user_name'      => sanitize_text_field($options['tw_user_name']),
                    'tw_widget_id'      => sanitize_text_field($options['tw_widget_id'])
                );
            break;

            case 'widget':
                $content = array( 
                    'widget_id'         => sanitize_text_field($options['widget_id'])
                );
            break;

            case 'custom':
                $content = array( 
                    'custom_content'    => $options['custom_content']
                );
            break;

        }

        $tab_options['content'] = serialize($content);
        $tab_options['options'] = serialize($css_options);

        return $tab_options;
    }



    // GLOBAL SETTINGS FORM
    public function view_options_form()
    {
        // SECURITY - CHECK PERMISSIONS
        if ( !current_user_can( 'manage_options') )
        {
            wp_die( __( 'You do not have sufficient permissions to access this page.', 'musli' ) );
        }

        global $wpdb;
        $musli_table = $wpdb->prefix . "musli";
        $musli_tabs = $wpdb->get_results("SELECT id, name from $musli_table ORDER BY name;");

        require_once('php/musli_options_page.php');
    }

    public function echo_musli()
    {
        $musli_options = get_option('musli_config');
        
        global $wpdb;
        $table_name = $wpdb->prefix . "musli";
        $tabs = $wpdb->get_results("SELECT id, name, type, content, options FROM $table_name ORDER BY tab_order", ARRAY_A);

        ob_start();
        
        if(!empty($tabs))
        {
            echo '<ul id="musli" class="musli musli-' . $musli_options['position'] . '">';

            foreach ($tabs as $tab)
            {
                // DETERMINE IF THIS TAB SHOULD BE OPENED ON START UP
                $start_with_opened = ( ($musli_options['start_with_opened'] == 'on' ) && ($tab['id'] == $musli_options['start_tab_id']) ) ? ' musli-open' : '';
                
                // DETERMINE IF THIS TAB SHOULD BE AUTOOPEN-ED
                $autoopen = ( ($musli_options['autoopen'] == 'on' ) && ($tab['id'] == $musli_options['autoopen_tab_id']) ) ? ' musli-autoopen' : '';

                echo '<li class="'.$start_with_opened.$autoopen.'">';

                // GENERATE NEEDED INLINE CSS
                $tab_inline_css = $this->generate_inline_css($tab['options']);

                // GENERATE TAB ICON
                echo $this->generate_tab_icon($tab['options']);

                if(is_serialized($tab['content']))
                    $content = unserialize($tab['content']);

                if($tab['type'] == 'custom')
                {
                    echo '<div'.$tab_inline_css.'>' . do_shortcode(urldecode(stripslashes($content['custom_content']))) . '</div>';
                }

                if($tab['type'] == 'facebook')
                {
                    $frame_code = '<iframe src="https://www.facebook.com/plugins/likebox.php?href=%1$s&amp;width=%2$d&amp;height=%3$d&amp;colorscheme=%4$s&amp;show_faces=%5$s&amp;header=%6$s&amp;stream=%7$s&amp;show_border=%8$s" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:%2$dpx; height:%3$dpx;" allowTransparency="true"></iframe>';

                    echo '<div'.$tab_inline_css.'>';

                        echo sprintf( $frame_code, 
                            /* %1$s */ urlencode($content['fb_url']),
                            /* %2$d */ $content['fb_width'],
                            /* %3$d */ $content['fb_height'],
                            /* %4$s */ $content['fb_color_scheme'],
                            /* %5$d */ $content['fb_show_faces'],
                            /* %6$d */ $content['fb_show_header'],
                            /* %7$s */ $content['fb_show_posts'],
                            /* %8$d */ $content['fb_show_border']
                        );

                    echo '</div>';
                }

                if($tab['type'] == 'widget')
                {
                    echo '<div'.$tab_inline_css.'>';

                        $this->generate_sidebar($tab['id']);
          
                    echo '</div>';
                }

                if($tab['type'] == 'google')
                {
                    $frame_code = '<div class="g-page" data-width="%2$d" data-href="//plus.google.com/%1$s" data-theme="%3$s" data-showtagline="%4$s" data-showcoverphoto="%5$s" data-rel="publisher"></div>
                    <script type="text/javascript">(function() { var po = document.createElement("script"); po.type = "text/javascript"; po.async = true; po.src = "https://apis.google.com/js/platform.js"; var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s); })();</script>';

                    echo '<div'.$tab_inline_css.'>';

                        echo sprintf( $frame_code, 
                            /* %1$s */ $content['gp_id'],
                            /* %2$d */ $content['gp_width'],
                            /* %3$d */ $content['gp_color_scheme'],
                            /* %4$s */ $content['gp_tagline'],
                            /* %5$d */ $content['gp_cover_photo']
                        );

                    echo '</div>';
                }

                if($tab['type'] == 'twitter')
                {
                    $frame_code = '<a class="twitter-timeline" data-dnt="true" href="https://twitter.com/%1$s"  data-widget-id="%2$s">Tweety na temat @%1$s</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';

                    echo '<div'.$tab_inline_css.'>';

                        echo sprintf( $frame_code, 
                            /* %1$s */ $content['tw_user_name'],
                            /* %2$d */ $content['tw_widget_id']
                        );

                    echo '</div>';
                }

                echo '</li>';
            } //end foreach

            echo '</ul>';
        }

        echo ob_get_clean();
    }

    private function generate_inline_css($options)
    {
        $output = '';

        if(is_serialized($options))
        {
            $options = unserialize($options);
        }
        else
        {
            return $output;
        }

        if($options['custom_css_on'] == 'on')
            $output = ' style="width:'.$options['tab_width'].'px;height:'.$options['tab_height'].'px;border-color:'.$options['tab_border_color'].';background:'.$options['tab_bg'].';"';

        return $output;
    }

    public static function generate_tab_icon($options, $is_admin_preview = FALSE)
    {
        $output = '';

        if(! is_serialized($options))
            return $output;
        
        $options = unserialize($options);
        
        if($options['fa_on'] == 'on')
        {
            $fa_spin = $options['fa_spin'] == 'on' ? ' fa-spin' : '';

            //
            if($is_admin_preview)
            {                   
                $output = sprintf('
                    <span class="admin-area-icon" style="background:%1$s;width:40px;height:40px;">
                        <i style="color:%2$s;font-size:%3$dpx;line-height:40px;" class="fa %4$s %5$s"></i>
                    </span>',
                    /* %1$s */  $options['fa_bg'],
                    /* %2$s */  $options['fa_font_color'],
                    /* %3$d */  $options['fa_font_size'],
                    /* %4$s */  $options['fa_class'],
                    /* %5$s */  $fa_spin
                );
            }
            else
            {
                $output = sprintf('
                    <span style="background:%1$s;"><i style="color:%2$s;font-size:%3$dpx;" class="fa %4$s %5$s"></i></span>',
                    /* %1$s */  $options['fa_bg'],
                    /* %2$s */  $options['fa_font_color'],
                    /* %3$d */  $options['fa_font_size'],
                    /* %4$s */  $options['fa_class'],
                    /* %5$s */  $fa_spin
                );
            }

            return $output;
        }

        if($options['img_url'] == 'http://' || $options['img_url'] == '')
        {
            $output = '<span style="background:none;"><img src="' . MUSLI_URL . '/img/default-icon.png" alt="" /></span>';
        }
        else
        {
            $output = '<span style="background:none;"><img src="' . $options['img_url'] . '" alt="" /></span>';
        }

        if($is_admin_preview)
            $output = '<div style="width:40px;height:40px;overflow:hidden">'.$output.'</div>';

        return $output;
    }

    public function generate_sidebar($id)
    {
        if ( is_active_sidebar( 'musli-sidebar-'.$id ) ){
            dynamic_sidebar( 'musli-sidebar-'.$id );
        }
        else
        {
            _e('<p>Now visit your Widgets Managment page and add widgets.</p>', 'musli');
        }
    }

    public function register_sidebars()
    {
        global $wpdb;
        $musli_table = $wpdb->prefix . 'musli';

        $sidebars = $wpdb->get_results("SELECT name, id, content FROM $musli_table WHERE type='widget' ORDER BY tab_order;", ARRAY_A);
        
        if ( !empty($sidebars) && function_exists ('register_sidebar') )

            foreach($sidebars as $sidebar)
            {
                $content = unserialize($sidebar['content']);
                register_sidebar( array(
                  'name' => $sidebar['name'],
                  'id' => 'musli-sidebar-'.$sidebar['id'],
                  'description' => __( 'Widget area created with MUSLI. Now you can drop here some widgets...' ,  'musli' ),
                  'before_widget' => '<div id="'.$content['widget_id'].'" class="%2$s">',
                  'after_widget' => '</div>',
                  'before_title' => '<h3>',
                  'after_title' => '</h3>',
                ) );
            }
    }
    private function update_global_stylesheet($css_options)
    {
        ob_start();
            require_once('php/css.php');
        $generated_css = ob_get_clean();

        file_put_contents(MUSLI_DIR_PATH . '/css/musli.css', $generated_css, LOCK_EX);
        return TRUE;
    }
    public function options_error() {
         settings_errors( 'options_error' );
    }
    private function musli_database_update()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'musli';

        $sql = "CREATE TABLE " . $table . " (
          id int(11) NOT NULL AUTO_INCREMENT,
          name varchar(45) NOT NULL,
          tab_order smallint(5) unsigned NOT NULL DEFAULT '0',
          type varchar(20) NOT NULL,
          content text DEFAULT NULL,
          options text DEFAULT NULL,
          PRIMARY KEY  (id)
        ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);
    }

    public static function activate()
    {
        // check if we are dealing with current version
        if ( !get_option( 'musli_version' ) || get_option('musli_version') != MUSLI_VERSION )
        {
            // database table update
            Musli::musli_database_update();

            // save defaults in database
            update_option('musli_config', Musli::$musli_defaults);
            update_option('musli_version', MUSLI_VERSION);

            // update global CSS file with defaults
            Musli::update_global_stylesheet(Musli::$musli_defaults);
        }
    }

    public static function deactivate()
    {

    }

} // END MUSLI CLASS

$musli = new Musli;
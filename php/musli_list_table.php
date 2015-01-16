<?php 

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Musli_list_table extends WP_List_Table {

    function __construct(){
        global $status, $page;
                
        parent::__construct( array(
            'singular'  => 'tab',
            'plural'    => 'tabs',
            'ajax'      => false
        ) );
    }
    
    function column_default($item, $column_name){
        switch($column_name){
            case 'icon_url':
            case 'type':
                return $item[$column_name];
            default:
                return print_r($item,true);
        }
    }
    
    
    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ 'tab_id',
            /*$2%s*/ $item['id']
        );
    }

    function column_name($item){
        $actions = array(
            'edit'      => sprintf('<a href="?page=musli-form&tab_id=%s">Edit</a>',$item['id'],'edit'),
            'delete'    => sprintf('<a href="?page=%s&action=%s&tab_id=%s">Delete</a>',$_REQUEST['page'],'delete',$item['id']),
        );
        
        //Return the title contents
        return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
            /*$1%s*/ $item['name'],
            /*$2%s*/ $item['id'],
            /*$3%s*/ $this->row_actions($actions)
        );
    }

    function column_icon($item)
    {
        //if($item['icon_url'] == 'http://' || $item['icon_url'] == '')
        $item['icon_url'] = MUSLI_URL . '/img/default-icon.png';
        
        $icon = Musli::generate_tab_icon($item['options'], TRUE);

        return sprintf('%1$s<span class="tabs_order" id="musli_%3$s"></span>',
            /*$1%s*/ $icon,
            /*$2%s*/ $item['name'],
            /*$3%s*/ $item['id']
        );
    }

    function get_columns(){
        $columns = array(
            'cb'            => '<input type="checkbox" />',
            'name'          => 'Name',
            'icon'          => 'Icon',
            //'icon_url'      => 'Icon URL',
            'type'          => 'Type'
        );
        return $columns;
    }
    
    function get_bulk_actions() {
        $actions = array(
            'delete'    => 'Delete'
        );
        return $actions;
    }
    
    function process_bulk_action() {
        if( 'delete'===$this->current_action() ) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'musli';

            $ids = isset($_REQUEST['tab_id']) ? $_REQUEST['tab_id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
            }
        }
    }
    
    function prepare_items() {
        global $wpdb;

        $per_page = 20;

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $this->process_bulk_action();

        $current_page = $this->get_pagenum();
        
        $table_name = $wpdb->prefix . "musli";
        $total_items = $wpdb->get_var( "SELECT COUNT(id) FROM $table_name" );
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;

        $this->items = $wpdb->get_results($wpdb->prepare("SELECT id, name, type, options FROM $table_name ORDER BY tab_order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
        
        $this->set_pagination_args( array(
            'total_items' => $total_items,
            'per_page'    => $per_page,
            'total_pages' => ceil($total_items/$per_page)
        ) );
    }
    
}

//END of wp-list-table class

    //Create an instance of our package class...
    $my_list_table = new Musli_list_table();

    //Fetch, prepare, sort, and filter our data...
    $my_list_table->prepare_items();
?>

<div class="wrap">

    <h2>Musli <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page='.$_REQUEST['page'].'-form');?>"><?php _e('Add new tab', 'musli')?></a></h2>

    <noscript>
        <div class="error message">
            <p><?php _e('This plugin require enebled JavaScript to work properly.', 'musli') ?></p>
        </div>
    </noscript>

     <form method="GET">
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <?php $my_list_table->display(); ?>
    </form>
        
    <div class="note">
        <p><strong>NOTE: </strong>You can easily change your tabs order using 'drag & drop' method. Simply click (and hold) on choosen row in above table, then drag it verticaly until its shadow jumps on desired place, then drop.</p>
    </div>


    <div class="note">
        <p>Thank you for using MUSLI. If you like this plugin, maybe you would be interested in pr0 version? Visit plugin's home page and find out what features it has.</p>
        <a style="float:left;" href="http://musli.wpadmin.pl/"><img src="<?php echo MUSLI_URL . '/img/musli-pr0.png'; ?>" alt="Musli pr0 icon" /></a>
        <table>
            <tr>
                <td><a href="http://musli.wpadmin.pl/">&larr; Plugin's home page</a></td>
            </tr>
            <tr>
                <td><iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FNewDividepl&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=18&amp;appId=283077631817635" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:18px;" allowTransparency="true"></iframe></td>
            </tr>
            <tr>
                <td><!-- Place this tag where you want the +1 button to render. -->
<div class="g-plusone" data-size="medium" data-annotation="inline" data-width="300" data-href="http://newdivide.pl"></div>
<!-- Place this tag after the last +1 button tag. -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/platform.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script></td>
            </tr>
        </table>
        

    </div><!-- end note -->


</div><!-- end wrap -->


<?php $ajax_nonce = wp_create_nonce( "tabs-order-nonce" ); ?>

<script>
jQuery(function(){

    jQuery('td, th', '.tabs').each(function () {
        var cell = jQuery(this);
        cell.width(cell.width());
    });

    jQuery("tbody").sortable({
        axis: "y", 
        cursor: "n-resize",
        forcePlaceholderSize: true,
        placeholder: "drop-highlight", 
        opacity: 0.8,
        create: function( event, ui ) {
            jQuery('tbody tr').each(function(){
                var rowid = jQuery(this).find('.tabs_order').attr('id');
                jQuery(this).attr('id', rowid);
            });
        },
        update: function(event, ui) {
            
            var data = {
                action: "update_tabs_order",
                ajax_nonce: "<?php echo $ajax_nonce; ?>",
                order: jQuery(this).sortable("serialize")
            };

            jQuery.post(ajaxurl, data);
       }
    });

    jQuery(".wp-list-table tbody").disableSelection();
});
</script>
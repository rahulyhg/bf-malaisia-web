<?php

if ( ! class_exists( 'WP_List_Table' ) )
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

class Custom_site_List_Table extends WP_List_Table {
    /** Class constructor */
    public $table_name;
    public $columns;
    public $sql;
    public function __construct() {
        parent::__construct( array(
                'singular' => __( 'Custom site', 'custom' ), //singular name of the listed records
                'plural'   => __( 'Custom site', 'custom' ), //plural name of the listed records
                'ajax'     => false, //should this table support ajax?
        ));
        global $wpdb;
        $keyword = isset($_REQUEST['s'])?$_REQUEST['s']:null;
        switch ($_REQUEST['page']){
            case 'newsletter':
            default:
                $this->table_name = 'newsletter';
                $this->columns = array(
                    'cb' => 'ID',
                    'created'      => 'Submitted',
                    'email' => 'Email',
                    'action' => 'Actions'
                );
                $this->sql = "SELECT n.ID, n.created,n.email FROM {$wpdb->prefix}{$this->table_name} n";
                if($keyword){
                    $this->sql .= " WHERE n.email LIKE '%$keyword%'";
                }
                if ( empty( $_REQUEST['orderby'] ) ) {
                    $_REQUEST['orderby'] = 'created';
                    $_REQUEST['order'] = 'desc';
                } 
        }
        /** Process bulk action */
        $this->process_bulk_action();
    }
    public function get_data( $per_page = 5, $page_number = 1 ) {
        global $wpdb;

        $sql = $this->sql;

        if ( ! empty( $_REQUEST['orderby'] ) ) {
            $sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
            $sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
        }

        $sql .= " LIMIT $per_page";

        $sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;
        $result = $wpdb->get_results( $sql, 'ARRAY_A' );

        return $result;
    }
    public function get_all_data() {
        global $wpdb;
        $sql = $this->sql;
    
        if ( ! empty( $_REQUEST['orderby'] ) ) {
            $sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
            $sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
        }
        $result = $wpdb->get_results( $sql, 'ARRAY_A' );
    
        return $result;
    }
    function record_count() {
        global $wpdb;
        $sql = $this->sql;
        $sql = 'SELECT COUNT(c.id) '.substr($sql, strpos($sql,'FROM'));
        return $wpdb->get_var( $sql );
    }
    public function no_items() {
        _e( 'No items avaliable.', 'custom' );
    }
    function get_columns(){
        return $this->columns;
    }
    public function column_cb( $item ) {
        return sprintf(
                '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['id']
        );
    }
    public function column_action( $item ) {
        $page = $_REQUEST['page'];
        $edit =  __('Edit','custom');
        $view = __('View','custom');
        $delete =  __('Delete','custom');
        $actions = array();
        $nonce = wp_create_nonce( 'libelis-nonce' );
        $url = admin_url( 'admin.php?page='.$page);
        $delete_link = add_query_arg( array( 'action' => 'delete','_wpnonce' => $nonce,'id' => absint( $item['id'])), $url );
        switch ($page){
            case 'newsletter':
                $actions['delete'] = sprintf('<a class="delete" href="%1$s" title="%2$s">%3$s</a>',esc_url( $delete_link ),esc_attr($delete),esc_html($delete));
                break;
        }
        return $this->row_actions( $actions ); ;
    }
    public function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'created':
                return mysql2date('d/m/Y', $item[$column_name] );
            /* case 'created':
                return get_date_from_gmt($item[$column_name],'Y-m-d H:i:s'); */
            default:
                return $item[ $column_name ];//Show the whole array for troubleshooting purposes
        }
    }

    public function get_sortable_columns() {
        $sortable_columns = array(
                'cb' => array( 'id', true ),
                'email' => array( 'email', false ),
                'created' => array( 'created', false )
        );

        return $sortable_columns;
    }
    public function get_bulk_actions() {
        $actions = array('bulk-delete' => 'Delete');
        return $actions;
    }
    protected function extra_tablenav( $which ) {
        if( $this->has_items()):
        ?>
        		<div class="alignleft actions bulkactions">
        <?php
        		if ( 'top' === $which && !is_singular()) {
                    submit_button( __('Export in csv') , 'button', 'download', false, array('id' => 'download-submit') );
        		}
        ?>
        		</div>
        <?php
        endif;
    }

    public function prepare_items() {
        $this->_column_headers = $this->get_column_info();
        $per_page     = $this->get_items_per_page( 'custom_site_per_page', 5 );
        $current_page = $this->get_pagenum();
        $total_items  = $this->record_count();
        $this->items = $this->get_data( $per_page, $current_page );
        $this->set_pagination_args( array(
                'total_items' => $total_items,
                'per_page'    => $per_page
        ));
    }
    function delete_item( $id ) {
        global $wpdb;
        $wpdb->delete("{$wpdb->prefix}{$this->table_name}",array( 'ID' => $id ),array('%d' ));
    }
    public function process_bulk_action() {
        $page = $_REQUEST['page'];
        if ( 'delete' === $this->current_action() ) {
           
            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr( $_REQUEST['_wpnonce'] );
            if ( ! wp_verify_nonce( $nonce, 'libelis-nonce' ) ) {
                die( 'Go get a life script kiddies' );
            }
            else {
                $this->delete_item( absint( $_GET['id'] ) );
                wp_redirect( admin_url( 'admin.php?page='.$page));
                exit;
            }
        }
        // If the delete bulk action is triggered
        if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
        || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
        ) {
            $delete_ids = esc_sql( $_POST['bulk-delete'] );
            // loop over the array of record IDs and delete them
            foreach ( $delete_ids as $id ) {
                $this->delete_item( $id );
            }
            wp_redirect( admin_url( 'admin.php?page='.$page));
            //wp_redirect( esc_url( add_query_arg() ) );
            exit;
        }
    }
}
<?php

namespace BFOX;

/**
 * Class Export_Users
 * @package BFOX
 *
 * @author Hoang Phan <hoang.phan@bfoxint.com>
 */
class Export_Users
{
	/**
	 * @param string $role
	 *
	 * @return array
	 */
	public function get_users($role='subscriber') {

        $res = [];

		$args = array(
			'blog_id' => $GLOBALS['blog_id'],
			'role'    => $role,
			'orderby' => 'ID',
			'order'   => 'DESC',
		);

        $users = get_users( $args );

        foreach ($users as $u) {
            $campaign_id = get_user_meta($u->ID, 'campaign_id', true);
            $first_name = get_user_meta($u->ID, 'first_name', true);
            $last_name = get_user_meta($u->ID, 'last_name', true);
            $phone = get_user_meta($u->ID, 'user_phone', true);
            $email = get_user_meta($u->ID, 'user_email', true);
            $dob = get_user_meta($u->ID, 'user_dob', true);
            $sb = get_user_meta($u->ID, 'wplc_subscribed', true);
            $subscribed = $sb == 0 ? 'No' : 'Yes';

	        $udata      = get_userdata( $u->ID );
	        $registered = $udata->user_registered;
	        $reg_date   = date( "d/m/Y H:i", strtotime( $registered ) );

            $user = [
	            'campaign_id' => $campaign_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'phone' => $phone,
                'email' => $email,
                'dob' => $dob,
                'subscribed' => $subscribed,
                'date_of_user_registration' => $reg_date
            ];

            $res[] = $user;
        }

        return $res;
    }

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
	    add_action( 'admin_post_nopriv_export_csv_users', [$this,'export_csv_users']  );
	    add_action( 'admin_post_export_csv_users', [$this,'export_csv_users'] );

    }

    public function export_csv_users() {
	    if ( isset( $_POST['_wpnonce-pp-eu-export-users-users-page_export'] ) ) {
		    $user_Arr = $this->get_users();

		    $sitename = sanitize_key( get_bloginfo( 'name' ) );
		    if ( ! empty( $sitename ) )
			    $sitename .= '.';
		    $filename = $sitename . 'users.' . date( 'Y-m-d-H-i-s' ) . '.csv';

		    $fields = ['campaign_ID','first_name','last_name','phone','email','dob','subscribed','date_of_user_registration'];
		    $headers = [];
		    foreach ( $fields as $field ) {
		        $field = str_replace('_', ' ', $field);
		        $field = ucfirst($field);
                $headers[] = '"' . $field . '"';
		    }
		    echo implode( ',', $headers ) . "\n";


		    header( 'Content-Description: File Transfer' );
		    header( 'Content-Disposition: attachment; filename=' . $filename );
		    header( 'Content-Type: text/csv; charset=' . get_option( 'blog_charset' ), true );

		    foreach ($user_Arr as $user){
		        $data = [];

		        foreach ($fields as $field) {
		            $field = strtolower($field);
		            $value = $user[$field];
		            $data[] = '"' . str_replace( '"', '""', $value ) . '"';
                }
			    echo implode( ',', $data ) . "\n";
            }

            exit;
	    }


    }

    public function add_admin_pages() {
        add_users_page( __( 'Export to CSV', 'export-users-to-csv' ), __( 'Export to CSV', 'export-users-to-csv' ), 'list_users', 'export-users-to-csv', array( $this, 'users_page' ) );
    }


    public function users_page() {
        if ( ! current_user_can( 'list_users' ) )
            wp_die( __( 'You do not have sufficient permissions to access this page.', 'export-users-to-csv' ) );
        ?>

        <div class="wrap">
        <h2><?php _e( 'Export users to a CSV file', 'export-users-to-csv' ); ?></h2>
        <?php
        if ( isset( $_GET['error'] ) ) {
            echo '<div class="updated"><p><strong>' . __( 'No user found.', 'export-users-to-csv' ) . '</strong></p></div>';
        }
        ?>
        <form method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" enctype="multipart/form-data">
            <?php wp_nonce_field( 'pp-eu-export-users-users-page_export', '_wpnonce-pp-eu-export-users-users-page_export' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for"pp_eu_users_role"><?php _e( 'Role', 'export-users-to-csv' ); ?></label></th>
                    <td>
                        <select name="role" id="pp_eu_users_role">
                            <?php
                           /* echo '<option value="">' . __( 'Every Role', 'export-users-to-csv' ) . '</option>';
                            global $wp_roles;
                            foreach ( $wp_roles->role_names as $role => $name ) {
                                echo "\n\t<option value='" . esc_attr( $role ) . "'>$name</option>";
                            }*/
                            ?>
                            <option value="subscriber">Subscriber</option>
                        </select>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="action" value="export_csv_users">
            <p class="submit">
                <input type="hidden" name="_wp_http_referer" value="<?php echo $_SERVER['REQUEST_URI'] ?>" />
                <input type="submit" class="button-primary" value="<?php _e( 'Export', 'export-users-to-csv' ); ?>" />
            </p>
        </form>
        <?php
    }
}
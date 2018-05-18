<?php
function download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    // header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");
    header('Content-Encoding: UTF-8');
    header('Content-type: text/csv; charset=utf-8');
    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header('Content-Transfer-Encoding: binary');
    header('Pragma: public');
}
function export_csv($data){
    ob_start();
    // ini_set("auto_detect_line_endings", true);
    if (empty($output_file)) {
        $df = fopen("php://output", 'w');
    }
    else {
        $df = fopen($output_file, 'w');
        chmod($output_file, 0755);
    }
    fprintf($df, chr(0xEF).chr(0xBB).chr(0xBF));
    switch ($_REQUEST['page']){
        case 'newsletter':
            $row = array('ID','Submitted','Email');
            break;
    }
    fputcsv($df, $row);
    $cols = count($row);
    foreach ($data as $row) {
        /* if(!empty($row['created'])){
            $row['created'] = get_date_from_gmt($row['created'],'Y-m-d H:i:s');
        } */
        if(!empty($row['created'])){
            $row['created'] = mysql2date( __( 'd/m/Y', 'bf' ),$row['created']);
        } 
        while (count($row) > $cols){
            array_pop($row);
        }
        fputcsv($df, $row);
    }
    fclose($df);
    $file_name = sanitize_title(get_admin_page_title());
    download_send_headers($file_name.'-' . date('Ymd') . ".csv");
    echo ob_get_clean();
}


function export_user_2_csv(){
    if(!empty($_REQUEST['btn_export'])){
        $data  =array();
        ob_start();
        if (empty($output_file)) {
            $df = fopen("php://output", 'w');
        }
        else {
            $df = fopen($output_file, 'w');
            chmod($output_file, 0755);
        }
        fprintf($df, chr(0xEF).chr(0xBB).chr(0xBF));
        $row = array('First name', 'Last name', 'Phone', 'Email','Date of birth', 'Has Subscribed');
        fputcsv($df, $row);
        global $wpdb;
        $sql = "SELECT u.ID,u.user_email, nl.email,um.meta_value FROM {$wpdb->prefix}users u LEFT JOIN  {$wpdb->prefix}newsletter nl ON  u.user_email = nl.email LEFT JOIN  {$wpdb->prefix}usermeta um ON u.ID = um.user_id AND um.meta_key ='user_dob';";
        $result = $wpdb->get_results( $sql, 'ARRAY_A' );
        foreach ($result as $item){
            $data = get_user_by('ID', $item['ID']);
            $row =  array($data->first_name, $data->last_name , $data->user_phone , $data->user_email,$item['meta_value'],($item['email']?'Yes':'No'));
            fputcsv($df, $row);
        }
        fclose($df);
        $file_name = 'List user';
        download_send_headers($file_name.'-' . date('Ymd') . ".csv");
        echo ob_get_clean();
        die;
    }
}
<?php
    ob_start();
    error_reporting(0);
    session_start();
    define('ABSPATH', dirname( __FILE__ ).'/');
    require(ABSPATH . 'el-includes/site_functions.php' );
    load_basic_conf();

    if(!chkInstall()) {
        header( 'location: el-admin/el_install.php' );
        exit;
    }

    $elyon = Elyon::getInstance();
    $elyon->initialize();
    ob_end_flush();
?>

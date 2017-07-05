<?php
    ob_start();
    session_start();
    define('ABSPATH', dirname(dirname( __FILE__ )).'/');
    require(ABSPATH . 'el-includes/el_functions.php' );
    load_basic_conf();

    if(!chkInstall() ) {
      header( 'location: el-admin/el_install.php' );
      exit;
    }

    if(!Session::check_session()) {
      header('location: ../el_login.php');
      exit;
    }
    $elyon = Elyon::getInstance();
    $elyon->initialize();
    ob_end_flush();
?>

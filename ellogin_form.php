<?php
    $errr = isset($GLOBALS['login_err']) ? $GLOBALS['login_err'] : '';
?>
<!Doctype html>
<html>
<head>
	<title><?=get_option('blogname').' &raquo; Login.'; ?></title>
	<link rel="stylesheet" type="text/css" id="theme" href="<?=get_theme_css(); ?>"/>
	<link rel="stylesheet" type="text/css" id="theme" href="<?=get_theme_font(); ?>"/>
  <link rel="icon" href="<?=INSTALL_DIR; ?>/logo.png"/>
	<script src="<?=load_jquery(); ?>"></script>
	<script src="<?=load_login(); ?>"></script>
</head>
<body>
    <div class="login-container" style="background:none;">
        <div class="login-box animated fadeInDown">
            <div class="loging-logo"><img style="position:relative;left:23%;margin-bottom:5px; max-width:200px;max-height:200px;" src="<?=INSTALL_DIR; ?>/logo.png"></div>
            <?=$errr; ?>
            <div class="login-body" style="background:#1B1E24;">
                <form action="<?=get_option('home').'/el_login.php'; ?>" class="form-horizontal" method="post">
                <div class="form-group">
                    <div class="col-md-12">
                        <input id="uname" name="uname" class="form-control" placeholder="Username" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <input id="pass" name="pass" class="form-control" placeholder="Password" type="password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <a href="#" class="btn btn-link btn-block">Forgot your password?</a>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-info btn-block">Log In</button>
                    </div>
                </div>
                </form>
            </div>
            <div class="login-footer" style="background:#1B1E24;">
                <div class="pull-left">
                   &copy; <?=get_date('Y', time()); ?> Elyon.
                </div>
                <div class="pull-right">
                    <a href="#">About</a> |
                    <a href="#">Privacy</a> |
                    <a href="#">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

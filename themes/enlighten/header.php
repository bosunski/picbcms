<!-- === BEGIN HEADER === -->
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="https://www.facebook.com/2008/fbml">
    <!--<![endif]-->
    <head>
        <!-- Title -->
        <title><?=isset($this->title) ? $this->get('title') : $this->blogname; ?></title>
        <!-- Meta -->
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

        <!-- META OG tags Begin -->
        <?=$this->get('seo_stuffs'); ?>
        <!-- META OG tags Ends -->

        <!-- Favicon -->
        <link href="logo.jpg" rel="shortcut icon">
        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="<?=$this->home.'/themes/'.$this->theme; ?>/assets/css/bootstrap.css" rel="stylesheet">
        <!-- Template CSS -->
        <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Alegreya+Sans">
        <link rel="stylesheet" href="<?=$this->home.'/themes/'.$this->theme; ?>/assets/css/animate.css" rel="stylesheet">
        <link rel="stylesheet" href="<?=$this->home.'/themes/'.$this->theme; ?>/assets/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="<?=$this->home.'/themes/'.$this->theme; ?>/assets/css/blueimp-gallery.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?=$this->home.'/themes/'.$this->theme; ?>/assets/css/nexus.css" rel="stylesheet">
        <link rel="stylesheet" href="<?=$this->home.'/themes/'.$this->theme; ?>/assets/css/responsive.css" rel="stylesheet">
        <link rel="stylesheet" href="<?=$this->home.'/themes/'.$this->theme; ?>/assets/css/custom.css" rel="stylesheet">



<script type='text/javascript' data-cfasync='false' src='//dsms0mj1bbhn4.cloudfront.net/assets/pub/shareaholic.js' data-shr-siteid='3ddaadbb0a2134c34bddd14960ea986a' async='async'></script>

    </head>
    <body>
        <div id="body_bg">
            <div id="pre_header" class="container">
                <div class="row margin-top-10 visible-lg">
                    <div class="col-md-6">
                        <p>
                            <strong>Phone:</strong>&nbsp;<?=$this->blog_phone; ?></p>
                    </div>
                    <div class="col-md-6 text-right">
                        <p>
                            <strong>Email:</strong>&nbsp;<?=$this->blog_email; ?></p>
                    </div>
                </div>
            </div>

            <div class="primary-container-group">
                <!-- Background -->
                <div class="primary-container-background">
                    <div class="primary-container"></div>
                    <div class="clearfix"></div>
                </div>
                <!--End Background -->
                <div class="primary-container">
                    <div id="header" class="container">
                        <div class="row">
                            <!-- Logo -->
                            <div class="logo">
                                <a href="<?=$this->home; ?>" title="">
                                    <img style="position: relative; top: -30px;" src="<?=$this->home; ?>/logo.png" alt="<?=$this->blogname; ?>" />
                                </a>
                            </div>
                            <!-- End Logo -->

                        </div>
                    </div>

                    <!-- Top Menu -->
                    <div id="hornav" class="container no-padding">
                        <div class="row">
                            <div class="col-md-12 no-padding">
                                <div style="margin-left:30px;" class="margin-left-30 pull-left">
                                    <!--<H2>Seun Speaks</h2>-->
                                </div>
                                <div class="pull-right visible-lg">
                                    <ul id="hornavmenu" class="nav navbar-nav">
                                        <li>
                                            <a href="<?=$this->home; ?>" class="">Home</a>
                                        </li>
                                        <!--<li>
                                            <a href="<?=$this->home; ?>/workers"><span class="">Executives</span></a>
                                        </li>-->
                                        <li>
                                            <a href="<?=$this->home; ?>/about"><span class="">About Me</span></a>
                                        </li>
                                        <!--<li>
                                            <a href="<?=$this->home; ?>/meme"><span class="">Shareable Memes</span></a>
                                        </li>-->

                                        <!--<li>
                                            <a href="<?=$this->home; ?>/resources" class="">Audio and Video Resources</a>
                                        </li>-->

                                        <li>
                                            <a href="<?=$this->home; ?>/blog"><span class="">Blog</span></a>
                                        </li>
                                        <li>
                                            <a href="<?=$this->home; ?>/contact" class="">Contact Us</a>
                                        </li>

                                        <?php if(!Session::check_session()): ?>
                                        <!--<li>
                                            <a href="<?=$this->home; ?>/login" class="">Sign In</a>
                                        </li>-->
                                      <?php else: ?>
                                        <!--<li>
                                            <a href="<?=$this->home; ?>/login?a=o" class="">Sign Out</a>
                                        </li>-->
                                      <?php endif; ?>


                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Top Menu -->

                    <!-- === END HEADER === -->

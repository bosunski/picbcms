<?php

?>

<!DOCTYPE html>
<html idmmzcc-ext-docid="578576384" lang="en">
    <head>
        <!-- META SECTION -->
        <title><?=isset($this->title) ? $this->get('title') : get_option('blogname'). ' &raquo; Dashboard'; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="<?=get_option('home'); ?>/el-admin/el-fav.png" type="image/png">
        <!-- END META SECTION -->

        <!-- CSS INCLUDE -->
        <link rel="stylesheet" type="text/css" id="theme" href="<?=get_option('home'); ?>/el-admin/themes/joli/css/theme-brown.css">
        <link rel="stylesheet" type="text/css" id="theme" href="<?=get_option('home'); ?>/css/font.css">
        <!-- EOF CSS INCLUDE -->
    </head>
    <body class="">

    	 <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>
                        <p>Press No if you want to continue. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="<?=get_option('home'); ?>/el_login.php?p=logout" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->
        <!-- START PAGE CONTAINER -->
        <div class="page-navigation-toggled page-container page-navigation-top-fixed">
            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar page-sidebar-fixed scroll mCustomScrollbar _mCS_1 mCS-autoHide mCS_no_scrollbar">
                <div tabindex="0" id="mCSB_1" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside">
                    <div id="mCSB_1_container" class="mCSB_container" style="position: relative; top: 0px; left: 0px;" dir="ltr">
                <!-- START X-NAVIGATION -->
                        <ul class="x-navigation">
                            <li class="xn-logo">
                                <a href="index.html">Admin</a>
                                <a href="#" class="x-navigation-control"></a>
                            </li>
                            <li class="xn-profile">
                                <a href="#" class="profile-mini">
                                    <img src="<?=get_option('home'); ?>/el-admin/themes/joli/img/avatar.png" alt="Admin">
                                </a>
                                <div class="profile">
                                    <div class="profile-image">
                                        <img src="<?=get_option('home'); ?>/el-admin/themes/joli/img/avatar.png" alt="Admin">
                                    </div>
                                    <div class="profile-data">
                                        <div class="profile-data-name"><?=$this->adminFullname; ?></div>
                                        <div class="profile-data-title"><?=$this->adminLevel; ?></div>
                                    </div>
                                    <div class="profile-controls">
                                        <a href="pages-profile.html" class="profile-control-left"><span class="fa fa-info"></span></a>
                                        <a href="pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                                    </div>
                                </div>
                            </li>
                            <li class="xn-title">Contents</li>
                            <li class="xn-openable">
                                <a href="#"><span class="fa fa-music"></span> <span class="xn-text">Media</span></a>
                                <ul>
                                    <li><a href="<?=get_option('home'); ?>/el-admin/media"><span class="fa fa-file-text-o"></span>Gallery</a></li>
                                    <li><a href="<?=get_option('home'); ?>/el-admin/media/slides"><span class="fa fa-file-text-o"></span>Slides</a></li>
                                </ul>
                            </li>
                            <li class="xn-openable">
                                <a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">Pages</span></a>
                                <ul>
                                    <li><a href="<?=get_option('home'); ?>/el-admin/pages"><span class="fa fa-image"></span>All Pages</a></li>
                                    <li><a href="<?=get_option('home'); ?>/el-admin/pages/newpage"><span class="fa fa-user"></span>Add New</a></li>
                                </ul>
                            </li>
                            <li class="xn-openable">
                                <a href="#"><span class="fa fa-file-text-o"></span> <span class="xn-text">Posts</span></a>
                                <ul>
                                    <li><a href="<?=get_option('home'); ?>/el-admin/post">All Posts</a></li>
                                    <li><a href="<?=get_option('home'); ?>/el-admin/post/newpost">Add New</a></li>
                                    <li><a href="<?=get_option('home'); ?>/el-admin/post/category">Category</a></li>
                                    <li><a href="<?=get_option('home'); ?>/el-admin/post/tags">Tags</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?=get_option('home'); ?>/el-admin/message"><span class="fa fa-comments"></span> <span class="xn-text">Messages</span></a>
                            </li>
                            <li class="xn-title">Settings</li>
                            <li class="xn-openable">
                                <a href="#"><span class="fa fa-cogs"></span> <span class="xn-text">Options</span></a>
                                <ul>
                                    <li><a href="<?=get_option('home'); ?>/el-admin/settings"><span class="fa fa-heart"></span> General Setting</a></li>
                                    <li><a href="<?=get_option('home'); ?>/el-admin/post/birthdays"><span class="fa fa-pencil"></span> Add birthdays of the week</a></li>
                                    <li><a href="<?=get_option('home'); ?>/el-admin/member"><span class="fa fa-book"></span> Member of the week</a></li>
                                    <li><a href="<?=get_option('home'); ?>/el-admin/post/frontmsg"><span class="fa fa-book"></span> Front Message</a></li>
                                </ul>
                            </li>
                            <li class="xn-openable">
                                <a href="#"><span class="fa fa-user"></span> <span class="xn-text">Users/Admin/Workers</span></a>
                                <ul>
                                    <li><a href="<?=get_option('home'); ?>/el-admin/user/admin"><span class="fa fa-file-text-o"></span>All Administrator</a></li>
                                    <li><a href="<?=get_option('home'); ?>/el-admin/user/newadmin"><span class="fa fa-list-alt"></span>Add New Admin</a></li>
                                    <li><a href="<?=get_option('home'); ?>/el-admin/user/workers"><span class="fa fa-arrow-right"></span>Workers</a></li>
                                    <li><a href="<?=get_option('home'); ?>/el-admin/user/workers?action=addnew"><span class="fa fa-arrow-right"></span>Add new worker</a></li>
                                </ul>
                            </li>
                        </ul>
                <!-- END X-NAVIGATION -->
                    </div>
                    <div style="display: block;" id="mCSB_1_scrollbar_vertical" class="mCSB_scrollTools mCSB_1_scrollbar mCS-light mCSB_scrollTools_vertical">
                        <div class="mCSB_draggerContainer">
                            <div id="mCSB_1_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; display: block; height: 129px; max-height: 411px; top: 0px;" oncontextmenu="return false;">
                                <div style="line-height: 30px;" class="mCSB_dragger_bar"></div>
                            </div>
                            <div class="mCSB_draggerRail"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE SIDEBAR -->

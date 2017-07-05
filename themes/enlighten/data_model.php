<?php
  $model = array(
              'latest_video' => '<div class="col-md-4 col-sm-4 person-details margin-bottom-30">
                  <figure>

<iframe width="100%" height="100%" src="[@view_link]" frameborder="0" allowfullscreen></iframe>
                      <figcaption>
                          <h5>[@post_title]</h5>
                      </figcaption>
                  </figure>
              </div>',


              'latest_audio' => '<h5 style="margin: 0;">
                <a href="[@download_link]">[@post_title]</a>
              </h5>
              <h4 style="margin: 0px 0px 2px 10px;">Added on <em>[@post_date]</em> </h4>',

              'that_latest_post' => '<h3 style="margin: 0;">
                <a href="[@permalink]">[@post_title]</a>
              </h3>
              <h4 style="margin: 0;">[@post_date] | Category: <a href="[@cat_link]">[@cat_name]</a></h4>
              <p>[@summary]</p>
              <a href="[@permalink]" class="btn btn-primary">
                  Read More
                  <i class="icon-chevron-right readmore-icon"></i>
              </a>',

              'home_page_latest_post2' => '<h3 style="margin: 0;">
                <a href="[@permalink]">[@post_title]</a>
              </h3>
              <h4 style="margin: 0;">[@post_date] | Category: <a href="[@cat_link]">[@cat_name]</a></h4>',

              'home_page_latest_post' => '<li class="portfolio-item col-sm-3 col-xs-6 no-padding">
                <a href="[@permalink]">
                    <figure class="animate fadeInLeft animated">
                        <img alt="" src="[@f_image]">
                    </figure>
                    <h3>[@post_title]</h3>
                </a>
                </li>',

                'author_link_viewpost' => '<a href="[@author_link]">[@author_name]</a>',

                'blog_tags' => '<li><a href="[@tag_link]" class="blog-tag"><span class="fa-tags"></span>[@tag_name]</a></li>',

                'side_bar_recent_post' => '<li>
                    <div class="recent-post">
                        <a href="">
                            <img class="pull-left" src="[@post_thumb]" alt="">
                        </a>
                        <a href="[@permalink]" class="posts-list-title">[@post_title]</a>
                        <br>
                        <span class="recent-post-date">
                            [@post_date]
                        </span>
                    </div>
                    <div class="clearfix"></div>
                </li>',
                'side_bar_category' => '<li>
                    <div class="recent-post">
                        <a href="[@permalink]" class="posts-list-title">[@cat_name]</a>
                        <span type="span" class="label label-info">[@post_count]</span>
                    </div>
                    <div class="clearfix"></div>
                </li>',

                'top_category' => '<a style="margin-right:5px;" class="btn btn-primary" href="[@permalink]">[@cat_name]([@post_count])</a>',

                'each_post' => '<div class="blog-post padding-bottom-20">
                    <!-- Blog Item Header -->
                    <div class="blog-item-header">
                        <!-- Title -->
                        <h3>
                            <a href="[@permalink]">
                                [@post_title]
                              </a>
                        </h3>
                        <div class="clearfix"></div>
                        <!-- End Title -->
                    </div>
                    <!-- End Blog Item Header -->
                    <!-- Blog Item Details -->
                    <div class="blog-post-details">
                        <!-- Author Name -->
                        <div class="blog-post-details-item blog-post-details-item-left">
                            <i class="fa fa-user color-gray-light"></i>
                            [@author]
                        </div>
                        <!-- End Author Name -->
                        <!-- Date -->
                        <div class="blog-post-details-item blog-post-details-item-left">
                            <i class="fa fa-calendar color-gray-light"></i>
                            [@post_date]
                        </div>
                        <div class="blog-post-details-item blog-post-details-item-left">
                            [@post_cat]
                        </div>
                        <!-- End Date -->

                        <!-- # of Comments -->
                        <div class="blog-post-details-item blog-post-details-item-left blog-post-details-item-last">

                                <i class="fa fa-comments color-gray-light"></i>
                                [@comments]

                        </div>
                        <!-- End # of Comments -->
                    </div>
                    <!-- End Blog Item Details -->
                    <!-- Blog Item Body -->
                    <div class="blog">
                        <div class="clearfix"></div>
                        <div class="blog-post-body row margin-top-15">
                            <!--<div class="col-md-5">
                                <img class="margin-bottom-20" src="[@f_image]" alt="">
                            </div>-->
                            <div class="col-md-12">
                                [@summary] ...
                                <!-- Read More -->
                                <br/><a href="[@permalink]" class="btn btn-primary">
                                    Read More
                                    <i class="icon-chevron-right readmore-icon"></i>
                                </a>
                                <!-- End Read More -->
                            </div>
                        </div>
                    </div>
                </div>',
                'each_post_comment' => '<div class="col-md-12">
                    <div class="testimonials">
                                <div class="">
                                    <div class="col-md-12">
                                        <p>
                                            [@comment_content]
                                        </p>
                                        <div class="testimonial-info">
                                            <img alt="" src="[@avatar]" class="img-circle img-responsive">
                                            <span class="testimonial-author">
                                                [@comment_author]
                                                <em>
                                                    [@comment_date]
                                                </em>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                        </div>
                    </div>',

                'no_comment' => '<li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-2 profile-thumb">
                                        </div>
                                        <div class="col-md-10">
                                            <h4>No comments yet.</h4>
                                        </div>
                                    </div>
                                </li>',

                                'each_slide' => '<div class="item [@class]">
                                    <img src="[@image]">
                                </div>',

                                'each_gallery_highlight' => '<a class="thumbBox" rel="lightbox-thumbs" href="[@image]">
                                    <img src="[@thumb]" alt="">
                                    <i></i>
                                </a>',

                                'each_gallery_image' => '<a class="gallery-item" href="[@image]" title="[@name]" data-gallery="">
            <div class="image">
                <img src="[@image]" alt="[@name]">
            </div>
            <!--<div class="meta">
                <strong>[@name]</strong>
                <span>[@description]</span>
            </div>-->
        </a>',

        //Each worker on the workers page(200x200 picturess)
        'each_worker' => '<div class="col-md-3">
        <div class="">
            <div class="panel-body profile">
                <div class="profile-image">
                    <img src="[@image]" alt="[@name]">
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">[@name]</div>
                    <div class="profile-data-title">[@office]</div>
                </div>

            </div>
            <div class="panel-body">
                <div class="contact-info">
                    <p><small>Mobile</small><br>[@mobile]</p>
                    <p><small>Email</small><br>[@email]</p>
                    <p><small>Address</small><br>[@address]</p>
                </div>
            </div>
        </div>
    </div>'

  );
?>

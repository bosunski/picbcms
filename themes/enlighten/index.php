<?php
   $this->getHeader();
?>



                    <!-- === BEGIN CONTENT === -->
                    <div id="content">
                        <div class="container no-padding">
                            <div class="row">
                                <!-- Carousel Slideshow -->
                                <div id="carousel-example" class="carousel slide" data-ride="carousel">
                                    <!-- Carousel Indicators -->
                                    <ol class="carousel-indicators">
                                        <li data-target="#carousel-example" data-slide-to="0" class="active"></li>
                                        <li data-target="#carousel-example" data-slide-to="1"></li>
                                        <li data-target="#carousel-example" data-slide-to="2"></li>
                                    </ol>
                                    <div class="clearfix"></div>
                                    <!-- End Carousel Indicators -->
                                    <!-- Carousel Images -->
                                    <div style="height:350px;" class="carousel-inner">
                                        <?=$this->slides; ?>
                                    </div>
                                    <!-- End Carousel Images -->
                                    <!-- Carousel Controls -->
                                    <a class="left carousel-control" href="#carousel-example" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                    </a>
                                    <a class="right carousel-control" href="#carousel-example" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                    </a>
                                    <!-- End Carousel Controls -->
                                </div>
                                <!-- End Carousel Slideshow -->
                            </div>
                        </div>
                        <div class="container background-gray-lighter">
                            <div class="row">
                                <h2 class="animate fadeIn text-center margin-top-50">Welcome to <?=get_option('blogname'); ?></h2>
                                <p class="animate fadeIn text-center"><?=get_option('blogdescription'); ?></p>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row margin-vert-30">
                                <!-- Main Text -->
                                <h2>Recent Posts</h2>
                                <div class="col-md-6">
                                    <!--<?=$this->front_message; ?>-->
                                    <?=$this->get('latest_post'); ?>
                                </div>
                                <!-- End Main Text -->
                                <!-- Side Column -->
                                <div class="col-md-6">
                                    <?=$this->get('other_latest_posts'); ?>
                                </div>
                                <!-- End Side Column -->
                            </div>
                            <div class="row margin-bottom-30">
                                        <div  class="col-md-4 animate fadeInLeft animated">
                                          <h2 style="margin-left:-20px;"> Recent Audio Resources</h2>
                                          <?=$this->get('latest_audios'); ?>
                                        </div>
                                        <div  class="col-md-8 animate fadeIn animated">
                                            <!-- Person Details -->
                                            <h2>Recent Video Resources</h2>
                                            <?=$this->get('latest_videos'); ?>
                                        </div>
                                    </div>
                            <h2> About Me</h2>
                            <div class="row margin-vert-30">
                                        <div class="col-md-6 animate fadeIn animated">
                                            <img src="http://localhost/cms_copy/themes/enlighten/assets/img/fillers/me.jpg" alt="about-me" class="margin-top-10">
                                            <!--<ul class="list-inline about-me-icons margin-vert-20">
                                                <li>
                                                    <a href="#">
                                                        <i class="fa-lg fa-border fa-linkedin"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <i class="fa-lg fa-border fa-facebook"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <i class="fa-lg fa-border fa-dribbble"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <i class="fa-lg fa-border fa-google-plus"></i>
                                                    </a>
                                                </li>
                                            </ul>-->
                                        </div>
                                        <div class="col-md-6 margin-bottom-10 animate fadeInRight animated">
                                            <h3 class="padding-top-10 pull-left">Olatunbosun Gabriel
                                                <small>- Developer</small>
                                            </h3>
                                            <div class="clearfix"></div>
                                            <h4>
                                                <em>“The greatest tragedy in life is not death, but a life without a purpose.”
― Myles Munroe</em>
                                            </h4>
                                            <p>Gabriel Bosun   is firstly an engineer, avid TECH lover and problem solver. He loves tackling problems in whatever form they choose to take, be it bugs in web scripts or challenging tasks involving Arduino. When he isn't coding or doing Computer Stuff, you might find him reading a good book (Spiritual or just good) ...
PROBLEMS TREMBLE AT HIS PRESENCE </p>

                                        </div>
                                    </div>
                        </div>
                        <div class="container background-gray-lighter">
                            <div class="row row-no-margin">
                                <!-- Portfolio -->
                                <ul class="portfolio-group">
                                    <!-- Portfolio Item -->
                                    <?=$this->get('posts'); ?>
                                    <!-- //Portfolio Item// -->

                                </ul>
                                <!-- End Portfolio -->
                            </div>
                        </div>
                    </div>
            <!-- === END CONTENT === -->

<?php
    $this->getFooter();
?>

</div></div>
<!-- === BEGIN FOOTER === -->
<div id="base">
    <div class="container padding-vert-30 margin-top-40">
        <div class="row">
            <!-- Sample Menu -->
            <div class="col-md-3 margin-bottom-10">
              <h5 style="color:#555555;" class="margin-bottom-10">Resources</h5>
              <h4><a class="" href="<?=$this->home; ?>/video">Audio Resources</a></h4>
                <h4><a class="" href="<?=$this->home; ?>/audio">Video Resources</a></h4>
                <div class="clearfix"></div>
            </div>
            <!-- End Sample Menu -->
            <!-- Contact Details -->
            <div class="col-md-3 margin-bottom-20">
                <h5 style="color:#555555;" class="margin-bottom-10">Contact Us</h5>
                <h4><a class="" href="<?=$this->home; ?>/contact">Countact Us</a></h4>

                <!--<p>
                    <span class="fa-phone">Telephone:</span><?=$this->blog_phone; ?>
                    <br>
                    <span class="fa-envelope">Email:</span>
                    <a href="mailto:<?=$this->blog_email; ?>"><?=$this->blog_email; ?></a>
                    <br>
                </p>
                    <?=$this->blog_address; ?>-->
                </p>
            </div>
            <!-- End Contact Details -->
            <!-- Thumbs Gallery -->
            <!--<div class="col-md-3 margin-bottom-20">
                <h3 class="margin-bottom-10">Gallery Highlights</h3>
                <div class="thumbs-gallery">
                    <?='';//$this->gallery_highlights; ?>
                </div>
                <div class="clearfix"></div>
            </div>-->
            <!-- End Thumbs Gallery -->
            <!-- Disclaimer -->
            <div class="col-md-3 margin-bottom-20">
                <h5 style="color:#555555;" class="margin-bottom-10">Follow <?=$this->blogname; ?></h5>
                <ul class="social-icons color no-padding">
                    <li class="social-facebook">
                        <a href="<?=$this->facebook_link; ?>" title="Facebook"></a>
                    </li>
                    <li class="social-twitter">
                        <a href="<?=$this->twitter_link; ?>" title="Twitter"></a>
                    </li>
                    <li class="social-googleplus">
                        <a href="<?=$this->gplus_link; ?>" title="Google+"></a>
                    </li>
                    <li class="social-youtube">
                        <a href="<?=$this->rss_link; ?>" title="Youtube"></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <!-- End Disclaimer -->

            <div class="col-md-3">
              <h5 style="color:#555555;" class="text-center animate fadeInUp margin-bottom-50 animated">
                Subscribe for our newsletter.<br>
                <form method="POST" action="http://localhost/lists/?p=subscribe">
                  <input style="margin-bottom:5px;background-color: rgb(255, 255, 255); background-image: none; border-radius: 5px; box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset; transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s; padding: 6px 12px; line-height: 1.42857; color: rgb(85, 85, 85); border: 1px solid rgb(204, 204, 204); width: 100%;" class="input-smd" placeholder="Input Your Email" name="email" type="text">
                  <br>
                  <input name="subscribe" value="Subscribe to Newsletter" class="btn btn-sm btn-primary" type="submit">
                </form>
              </h5>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- Footer Menu -->
<div id="footer">
    <div class="container">
        <div class="row">
            <div id="copyright" class="col-md-4">
                <p>&copy; <?=$this->footer_date; ?> <?=$this->blogname; ?></p>
            </div>
            <div id="footermenu" class="col-md-8">
                <ul class="list-unstyled list-inline pull-right">
                  <li>
                      Administrative <a href="<?=$this->home; ?>/el-admin" target="_blank">Login</a>
                  </li>
                    <li>
                        Powered by <a href="#" target="_blank">Elyon</a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Footer Menu -->
<!-- JS -->
<script type="text/javascript" src="<?=$this->home.'/themes/'.$this->theme; ?>/assets/js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$this->home.'/themes/'.$this->theme; ?>/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$this->home.'/themes/'.$this->theme; ?>/assets/js/scripts.js"></script>
<!-- Isotope - Portfolio Sorting -->
<script type="text/javascript" src="<?=$this->home.'/themes/'.$this->theme; ?>/assets/js/jquery.isotope.js" type="text/javascript"></script>
<!-- Mobile Menu - Slicknav -->
<script type="text/javascript" src="<?=$this->home.'/themes/'.$this->theme; ?>/assets/js/jquery.slicknav.js" type="text/javascript"></script>
<!-- Animate on Scroll-->
<script type="text/javascript" src="<?=$this->home.'/themes/'.$this->theme; ?>/assets/js/jquery.visible.js" charset="utf-8"></script>
<script type="text/javascript" src="<?=$this->home.'/themes/'.$this->theme; ?>/assets/js/jquery.blueimp-gallery.min.js" charset="utf-8"></script>
<!-- Sticky Div -->
<!-- Slimbox2-->
<script type="text/javascript" src="<?=$this->home.'/themes/'.$this->theme; ?>/assets/js/slimbox2.js" charset="utf-8"></script>
<!-- Modernizr -->
<script src="<?=$this->home.'/themes/'.$this->theme; ?>/assets/js/modernizr.custom.js" type="text/javascript"></script>

<script>
            document.getElementById('links').onclick = function (event) {
                event = event || window.event;
                var target = event.target || event.srcElement;
                var link = target.src ? target.parentNode : target;
                var options = {index: link, event: event,onclosed: function(){
                        setTimeout(function(){
                            $("body").css("overflow","");
                        },200);
                    }};
                var links = this.getElementsByTagName('a');
                blueimp.Gallery(links, options);
            };
        </script>
        <script id="dsq-count-scr" src="//seun-speaks.disqus.com/count.js" async></script>
<!-- End JS -->
</body>
</html>
<!-- === END FOOTER === -->

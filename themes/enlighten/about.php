<?php
   $this->getHeader();
?>

<div id="content">
  <div style="font-size:20px;" class="container background-gray-lighter">
      <div class="row">
          <p class="pull-right animate fadeIn text-center margin-bottom-10 margin-top-10"><?=$this->get('bread_crumb'); ?></p>
      </div>
  </div>
                      <div class="container">
                          <div class="row margin-vert-30">
                              <!--<div class="col-md-12">
                                  <h2 class="margin-vert-20">About <?=$this->blogname; ?></h2>
                                  <div class="row margin-bottom-30">
                                      <div class="col-md-12">
                                          <?=$this->about; ?>
                                      </div>
                                    </div>
                                  <hr class="margin-bottom-50">
                                </div>-->

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
                      </div>
                  </div>

<?php
   $this->getFooter();
?>

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
                              <div class="col-md-12">
                                  <h2 class="margin-vert-20">About <?=$this->blogname; ?></h2>
                                  <div class="row margin-bottom-30">
                                      <div class="col-md-12">
                                          <?=$this->about; ?>
                                      </div>
                                    </div>
                                  <hr class="margin-bottom-50">
                                </div>
                          </div>
                      </div>
                  </div>

<?php
   $this->getFooter();
?>

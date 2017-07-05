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
                          <div class="row margin-top-15">
                            <div class="headline">
                                <h2><span class="fa-users"><span>Our Current Team</h2>
                            </div>
                            <hr></>
                            <?=$this->workers; ?>
                          </div>
                        </div>
                    </div>

<?php
    $this->getFooter();
?>

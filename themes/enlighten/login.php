<?php $this->getHeader(); ?>
<div class="container">
<div class="row margin-vert-30">
  <div class="col-md-6 col-md-offset-3 col-sm-offset-3">
                                          <form action="<?=$this->get('form_url'); ?>" method="POST" class="login-page">
                                              <div class="login-header margin-bottom-30">
                                                  <h2>Login to your account</h2>
                                                <?php  if($this->get('msg') != ''): ?>
                                                  <blockquote class="primary"><p><?=$this->get('msg'); ?></p></blockqquote>
                                                <?php endif; ?>
                                              </div>
                                              <div class="input-group margin-bottom-20">
                                                  <span class="input-group-addon">
                                                      <i class="fa fa-user"></i>
                                                  </span>
                                                  <input name="uname" placeholder="Username" class="form-control" type="text">
                                              </div>
                                              <div class="input-group margin-bottom-20">
                                                  <span class="input-group-addon">
                                                      <i class="fa fa-lock"></i>
                                                  </span>
                                                  <input name="pass" placeholder="Password" class="form-control" type="password">
                                              </div>
                                              <div class="row">
                                                  <div class="col-md-6">
                                                      <label class="checkbox">
                                                          <input type="checkbox">Stay signed in</label>
                                                  </div>
                                                  <div class="col-md-6">
                                                      <button class="btn btn-primary pull-right" type="submit">Login</button>
                                                  </div>
                                              </div>
                                              <h4><a href="<?=$this->home; ?>/register">Register</a> | <a href="<?=$this->home; ?>/preset">Forgot your Password?</a></h4>
                                          </form>
                                      </div>
                              </div>
                            </div>
          <?php $this->getFooter(); ?>

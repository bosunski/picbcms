<?php $this->getHeader(); ?>
<div class="container">
<div class="row margin-vert-30">
<div class="col-md-6 col-md-offset-3 col-sm-offset-3">
                                    <?php if(!Session::check_session()): ?>
                                    <form action"" method="POST" class="signup-page">
                                        <div class="signup-header">
                                            <h2>Register a new account</h2>
                                            <p>Already a member? Click
                                                <a href="<?=$this->home; ?>/login"> HERE</a> to login to your account.</p>
                                        </div>
                                        <label>First Name</label>
                                        <input value="<?=$this->get('rfname'); ?>" class="form-control margin-bottom-20" type="text">
                                        <label>Last Name</label>
                                        <input value="<?=$this->get('rlname'); ?>" class="form-control margin-bottom-20" type="text">
                                        <label>Email Address
                                            <span class="color-red">*</span>
                                        </label>
                                        <input value="<?=$this->get('remail'); ?>" class="form-control margin-bottom-20" type="email">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label>Password
                                                    <span class="color-red">*</span>
                                                </label>
                                                <input value="<?=$this->get('rpass'); ?>" class="form-control margin-bottom-20" type="password">
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Confirm Password
                                                    <span class="color-red">*</span>
                                                </label>
                                                <input value="<?=$this->get('cpass'); ?>" class="form-control margin-bottom-20" type="password">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 text-right">
                                                <button class="btn btn-primary" type="submit">Register</button>
                                            </div>
                                        </div>
                                    </form>
                                  <?php else: ?>
                                    <blockquote class="default"><p>Please <a href="<?=$this->get('home'); ?>/login?a=o">log out</a> to start a new registration.</p></blockquote>
                                  <?php endif; ?>
                                </div>
                              </div>
                            </div>
          <?php $this->getFooter(); ?>

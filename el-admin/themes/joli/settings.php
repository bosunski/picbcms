<?php
	$this->getDashboardHeader();
	$post_title = isset($this->post_title) ? 'value="'.$this->post_title.'"' : '';
	$post_content = isset($this->post_content) ? $this->post_content : '';
	$post_status = isset($this->post_status) ? 'value="' . $this->post_status . '"' : '';
	$post_parent = isset($this->post_parent) ? 'value="' . $this->post_parent . '"' : '';
	$msg = (null !== $this->get('msg')) ? $this->get('msg') : '';
?>
<div class="row">
	<div class="col-md-12">
		<form id="post-edit-form" action="" method="POST" class="form-horizontal">
			<?=$msg; ?>
				  <div class="panel panel-default">
              <div class="panel-heading ui-draggable-handle">
                  <h2 class="panel-title"><span class="fa fa-gears"></span> Settings
									</h2>
              </div>
              <div class="panel-body">
                  <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                              <label class="col-md-3 control-label">Site Name:</label>
                              <div class="col-md-9">
                                  <div class="input-group">
                                      <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                      <input name="blogname" value="<?=$this->blogname; ?>" style="" placeholder="Enter site name" class="form-control" type="text">
                                  </div>
                              </div>
                          </div>

                          <div class="form-group">
                                <label class="col-md-3 control-label">Site description:</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input name="blogdescription" value="<?=$this->blogdescription; ?>" style="" placeholder="Enter site description" class="form-control" type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                  <label class="col-md-3 control-label">Admin Email:</label>
                                  <div class="col-md-9">
                                      <div class="input-group">
                                          <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                          <input name="admin_email" value="<?=$this->admin_email; ?>" style="" placeholder="Enter Admin email" class="form-control" type="email">
                                      </div>
                                  </div>
                              </div>


                              <div class="form-group">
                                    <label class="col-md-3 control-label">About page:</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            <input name="about_page" value="<?=$this->about_page; ?>" style="" placeholder="Your about page" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>



                              <div class="form-group">
                                    <label class="col-md-3 control-label">Posts per page</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            <input name="post_per_page" value="<?=$this->post_per_page; ?>" style="" placeholder="Posts per page" class="form-control">
                                        </div>
                                    </div>
                                </div>



                                  <div class="form-group">
                                        <label class="col-md-3 control-label">Site theme:</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input name="theme" value="<?=$this->theme; ?>" style="" placeholder="theme" class="form-control" type="text">
                                            </div>
                                        </div>
                                  </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                              <label class="col-md-3 control-label">Admin posts per page:</label>
                              <div class="col-md-9">
                                  <div class="input-group">
                                      <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                      <input name="admin_post_per_page" value="<?=$this->admin_post_per_page; ?>" style="" placeholder="Admin post per page" class="form-control">
                                  </div>
                              </div>
                          </div>

                          <div class="form-group">
                                <label class="col-md-3 control-label">Comments per page:</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input name="comment_per_page" value="<?=$this->comment_per_page; ?>" style="" placeholder="Comment per page" min="1" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                  <label class="col-md-3 control-label">Site Email:</label>
                                  <div class="col-md-9">
                                      <div class="input-group">
                                          <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                          <input name="blog_email" value="<?=$this->blog_email; ?>" style="" placeholder="Site email" class="form-control" type="email">
                                      </div>
                                  </div>
                              </div>

                              <div class="form-group">
                                    <label class="col-md-3 control-label">Site Phone:</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            <input name="blog_phone" value="<?=$this->blog_phone; ?>" style="" placeholder="Site phone" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                      <label class="col-md-3 control-label">Site address:</label>
                                      <div class="col-md-9">
                                          <div class="input-group">
                                              <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                              <input name="blog_address" value="<?=$this->blog_address; ?>" style="" placeholder="Site address" class="form-control" type="text">
                                          </div>
                                      </div>
                                  </div>

                                  <div class="form-group">
                                        <label class="col-md-3 control-label">Facebook link:</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input name="facebook_link" value="<?=$this->facebook_link; ?>" style="" placeholder="Facebook link" class="form-control" type="text">
                                            </div>
                                        </div>
                                  </div>
                      </div>

                      <div class="col-md-4">

                        <div class="form-group">
                              <label class="col-md-3 control-label">Twitter link:</label>
                              <div class="col-md-9">
                                  <div class="input-group">
                                      <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                      <input name="twitter_link" value="<?=$this->twitter_link; ?>" style="" placeholder="Twitter link" class="form-control" type="text">
                                  </div>
                              </div>
                          </div>

                          <div class="form-group">
                                <label class="col-md-3 control-label">Google plus link:</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input name="gplus_link" value="<?=$this->gplus_link; ?>" style="" placeholder="Google pluus link" class="form-control" type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                  <label class="col-md-3 control-label">RSS link:</label>
                                  <div class="col-md-9">
                                      <div class="input-group">
                                          <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                          <input name="rss_link" value="<?=$this->rss_link; ?>" style="" placeholder="RSS link" class="form-control" type="text">
                                      </div>
                                  </div>
                              </div>

                              <div class="form-group">
                                    <label class="col-md-3 control-label">Admin theme:</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            <input name="admin-theme" value="<?=$this->admin_theme; ?>" style="" placeholder="Admin theme" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                      </div>
                  </div>
              </div>
              <div class="panel-footer">
									<button type="submit" class="save-post-draft btn btn-success pull-right">Save Settings</button>
              </div>
          </div>
    </form>
  </div>
</div>

<?php
	$this->getDashboardFooter();
?>

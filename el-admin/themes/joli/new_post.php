<?php
	$this->getDashboardHeader();
	$post_title = isset($this->post_title) ? 'value="'.$this->post_title.'"' : '';
	$post_content = isset($this->post_content) ? 'value="'.$this->post_content.'"' : '';
	$post_content = isset($this->post_content) ? $this->post_content : '';
	$post_status = isset($this->post_status) ? 'value="' . $this->post_status . '"' : '';
	$post_parent = isset($this->post_parent) ? 'value="' . $this->post_parent . '"' : '';
	$msg = (null !== $this->get('msg')) ? $this->get('msg') : '';
?>
<div class="row">
	<div class="col-md-12">
		<form id="post-edit-form" action="<?=$this->get('form_url');?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
			<?=$msg; ?>
				  <div class="panel panel-default">
              <div class="panel-heading ui-draggable-handle">
                  <h2 class="panel-title"><span class="fa fa-edit"></span>Add new Post <a href="<?=get_option('home'); ?>/el-admin/post"  class="btn btn-success">View all Posts</a></h2>
              </div>
              <div class="panel-body">
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                              <label class="col-md-3 control-label">Title</label>
                              <div class="col-md-9">
                                  <div class="input-group">
                                      <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                      <input spellcheck="true" autocomplete="off" <?=$post_title; ?> name="post_title" style="" placeholder="Enter Page Title" class="form-control" type="text">
                                  </div>
                              </div>
                          </div>

													<div class="form-group">
														<label class="col-md-3 control-label">Post Type</label>
														<div class="col-md-4">
																<select id="post-type" class="form-control" name="post_type">
																	<option value="">Select type</option>
																	<option value="post">Blog Post</option>
																	<option value="page">Page</option>
																	<option value="video">Video</option>
																	<option value="audio">Audios</option>
															</select>
														</div>
													</div>

                          <div class="form-group">
                              <label class="col-md-3 control-label">Content</label>
                              <div class="col-md-9 col-xs-12">
                                  <textarea placeholder="Content" class="post-content form-control" rows="3" id="pbody" autocomplete="off" name="post_content" class="input-postcontent summernote form-control"><?=$post_content; ?></textarea>
                                  <span class="help-block">Write your Mind here!</span>
                              </div>
                          </div>
                      </div>

                      <div class="col-md-6">
													<div class="form-group">
                              <label class="col-md-3 control-label">Set Featured Image</label>
                              <div class="col-md-9">
                                  <input name="f_image" id="f_image" style="left: -124.867px; top: -9.35001px;" class="" title="Browse file" type="file">
                                  <span class="help-block">Only JPEG, GIF, or PNG files are allowed.</span>
                              </div>
                          </div>

													<div class="form-group">
																<label class="col-md-3 control-label">Status</label>
																<div class="col-md-4">
																	<select id="post-status"  class="form-control" name="post_status">
																		<?=$this->post_status_html; ?>
																	</select>
																	<span class="help-block">Status of this post</span>
																</div>
													</div>

													<div class="form-group">
														<label class="col-md-3 control-label">Category</label>
														<div class="col-md-4">
															<select id="post-parent" class="form-control" name="post_parent">
																<?=$this->cat_html; ?>
															</select>
														</div>
													</div>

													<div class="form-group">
														<label class="col-md-3 control-label">Tags</label>
														<div class="col-md-4">
										        	<input type="text" style="width:60%;" name="post_tag" class="post-tags" id="tags"/> <a style="margin-bottom:3px;" class="save-tags btn btn-default">Add</a>
															<span class="help-block">Separate Tags with commas. Click on <span style="color:red;" class="fa fa-thumb-tack"></span> to remove a tag.</span>
										        	<ul class="list-tags push-up-10">
						                  </ul>
														</div>
									        </div>
                      </div>
                  </div>
              </div>
              <div class="panel-footer">
									<button type="submit" class="save-post-draft btn btn-success pull-right" >Save</button>
              </div>
          </div>
    </form>
  </div>
</div>

<?php
	$this->getDashboardFooter();
?>

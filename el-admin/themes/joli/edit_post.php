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
		<form id="post-edit-form" action="<?=$this->get('form_url');?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
			<?=$msg; ?>
				  <div class="panel panel-default">
              <div class="panel-heading ui-draggable-handle">
                  <h2 class="panel-title"><span class="fa fa-edit"></span> Edit Post
										<a href="<?=get_option('home'); ?>/el-admin/post/newpost"  class="btn btn-success">Add New</a>
									</h2>
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
                                  <span class="help-block"><b>Permalink: </b> <?=$this->permalink; ?> <span class="perm-settings-button"><span class="edit-postname btn btn-default btn-sm">Edit</span>  <a target="_blank" href="<?=$this->vlink; ?>" class="view-post btn btn-default btn-sm">View</a></span></span>
																	<span style="color:red;" id="perm-stat"></span>
                              </div>
                          </div>

													<div class="form-group">
														<label class="col-md-3 control-label">Post Type</label>
														<div class="col-md-4">
															<select id="post-type" class="form-control" name="post_type">
																<?=$this->post_type_html; ?>
															</select>
														</div>
													</div>

                          <div class="form-group">
                              <label class="col-md-3 control-label">Content</label>
                              <div class="col-md-9 col-xs-12">
                                  <textarea class="post-content form-control" rows="3" id="pbody" autocomplete="off" name="post_content" class="input-postcontent summernote form-control"><?=$post_content; ?></textarea>
                                  <span class="help-block">Write your Mind!</span>
                              </div>
                          </div>
                      </div>

                      <div class="col-md-6">
													<div class="form-group">
                              <label class="col-md-3 control-label">Set Featured Image</label>
                              <div class="col-md-9">
                                  <input name="f_image" id="f_image" style="left: -124.867px; top: -9.35001px;" class="" name="filename" id="filename" title="Browse file" type="file">
																	<span class="help-block"><b>Current Image: <?=isset($this->f_image) ? $this->f_image : 'None'; ?></b></span>
                                  <span class="help-block">Only JPEG, GIF, or PNG files are allowed.</span>

                              </div>
                          </div>

													<div class="form-group">
                              <label class="col-md-3 control-label">Remove Featured Image</label>
                              <div class="col-md-9">
																	<input type="checkbox" name="removeImg" value="remove"/>
																	<span class="help-block">If you want to remove current Image check this box.</span>

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
										        	<input type="text" style="width:60%;" name="post_tags" class="post-tags" id="tags-<?=$this->ID; ?>"/> <a style="margin-bottom:3px;" onclick="saveTags()" class="save-tags btn btn-default">Add</a>
															<span class="help-block">Separate Tags with commas. Click on <span style="color:red;" class="fa fa-thumb-tack"></span> to remove a tag.</span>
										        	<ul class="list-tags push-up-10">
						                  	<?=$this->get('post_tag'); ?>
						                  </ul>
														</div>
									        </div>
                      </div>
                  </div>
              </div>
              <div class="panel-footer">
									<a href="<?=$this->get('trash_url');?>" class="btn btn-danger"><span class="fa fa-trash-o"></span> Trash</a>
									<button type="submit" class="save-post-draft btn btn-success pull-right" >Save as <?=ucfirst($this->get('post_status_val')); ?></button>
              </div>
          </div>
    </form>
  </div>
</div>

<?php
	$this->getDashboardFooter();
?>

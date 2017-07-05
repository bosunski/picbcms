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
		<form id="post-edit-form" action="" method="POST"  class="form-horizontal">
			<?=$this->msg; ?>
				  <div class="panel panel-default">
              <div class="panel-heading ui-draggable-handle">
                  <h2 class="panel-title"><span class="fa fa-edit"></span> Add/Edit Birthdays
									</h2>
              </div>
              <div class="panel-body">
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="col-md-3 control-label">Birthday Data(Comma separated details)</label>
                              <div class="col-md-9 col-xs-12">
                                  <textarea class="post-content form-control" rows="3" id="pbody" autocomplete="off" name="post_tag" class="input-postcontent summernote form-control"><?=$this->birthdays; ?></textarea>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="panel-footer">
									<button type="submit" class="save-post-draft btn btn-success pull-right" >Save Birthdays</button>
              </div>
          </div>
    </form>
  </div>
</div>

<?php
	$this->getDashboardFooter();
?>

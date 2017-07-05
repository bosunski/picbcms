<?php
  $this->getDashboardHeader();
  $msg = (null !== $this->get('msg')) ? $this->get('msg') : '';
?>
<div class="page-title">
    <?=$msg; ?>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading ui-draggable-handle">
                <h2><span class="fa fa-users"></span> All workers</h2>
            </div>

            <div class="panel-body">
              <div class="row" style="margin-bottom:5px;">
                <a href="<?=get_option('home');?>/el-admin/user/workers?action=addnew" class="btn btn-flat btn-default">Add New</a>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="table-responsive">
                    <table style="margin-bottom:5px;" class="table table-bordered table-striped table-actions">
                        <thead>
                          <?php if($this->worker_rows != '<b style="color:red;">Data is Empty!</b>') {
                          ?>
                          <tr>
                            <th>Worker</th>
                            <th>Image</th>
                            <th>Actions</th>
                          </tr>

                          <?php
                          } ?>

                        </thead>
                        <tbody>
                            <?=$this->worker_rows; ?>
                        </tbody>
                    </table>
                  </div>
                </div>

                <div class="col-md-6">
                <form id="post-edit-form" action="<?=$this->get('form_url');?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
                  <div class="form-group">
                      <label class="col-md-3 control-label">Select Image</label>
                      <div class="col-md-9">
                          <input name="f_image" id="f_image" style="left: -124.867px; top: -9.35001px;" class="" title="Select picture" type="file">
                          <span class="help-block">Only JPEG, GIF, or PNG files are allowed.</span>
                      </div>
                  </div>

                  <div class="form-group">
                        <label class="col-md-3 control-label">Name:</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input name="post_title" value="<?=$this->get('name'); ?>" style="" placeholder="Worker's name" class="form-control" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                          <label class="col-md-3 control-label">Office:</label>
                          <div class="col-md-9">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                  <input name="post_content" value="<?=$this->get('office'); ?>" style="" placeholder="Worker's office" class="form-control" type="text">
                              </div>
                          </div>
                      </div>

                      <div class="form-group">
                            <label class="col-md-3 control-label">Email:</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input name="post_name" value="<?=$this->get('email'); ?>" style="" placeholder="Worker's email" class="form-control" type="text">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                              <label class="col-md-3 control-label">Phone:</label>
                              <div class="col-md-9">
                                  <div class="input-group">
                                      <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                      <input name="post_excerpt" value="<?=$this->get('phone'); ?>" style="" placeholder="Worker's phone" class="form-control" type="text">
                                  </div>
                              </div>
                          </div>

                          <div class="form-group">
                                <label class="col-md-3 control-label">Address:</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input name="post_tag" value="<?=$this->get('address'); ?>" style="" placeholder="Worker's address" class="form-control" type="text">
                                    </div>
                                </div>
                          </div>

                          <div class="">
            									<button type="submit" class="save-post-draft btn btn-success pull-right">Save</button>
                          </div>
                      </form>

                </div>
              </div>
              <div class="row" style="margin-bottom:5px;">

              </div>


            </div>
        </div>

    </div>
</div>
<?php $this->getDashboardFooter(); ?>

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
                <a href="<?=get_option('home');?>/el-admin/user/admin?action=addnew" class="btn btn-flat btn-default">Add New</a>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="table-responsive">
                    <table style="margin-bottom:5px;" class="table table-bordered table-striped table-actions">
                        <thead>
                          <?php if($this->worker_rows != '<b style="color:red;">Data is Empty!</b>') {
                          ?>
                          <tr>
                            <th>ID</th>
                            <th>Admin</th>
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
                        <label class="col-md-3 control-label">Full name:</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input name="name" value="<?=$this->get('name'); ?>" style="" placeholder="Admin's fullname" class="form-control" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                          <label class="col-md-3 control-label">Username:</label>
                          <div class="col-md-9">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                  <input name="username" value="<?=$this->get('username'); ?>" style="" placeholder="Admin's username" class="form-control"  <?=$this->get('disabled'); ?> type="text">
                              </div>
                          </div>
                      </div>

                      <div class="form-group">
                            <label class="col-md-3 control-label">User Role:</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="" name="role">
                                      <?=$this->role_html; ?>
                                    </select>
                                </div>
                            </div>
                      </div>

                    <div class="form-group">
                          <label class="col-md-3 control-label">Email:</label>
                          <div class="col-md-9">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                  <input name="email" value="<?=$this->get('email'); ?>" style="" placeholder="Admin's Email" class="form-control" type="email">
                              </div>
                          </div>
                      </div>

                      <div class="form-group">
                            <label class="col-md-3 control-label">Password:</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input name="password" value="" style="" placeholder="Admin's password" class="form-control" type="password">
                                </div>
                                <p style="color:red;">Please leave this blank if you are not willing to change the password</p>
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

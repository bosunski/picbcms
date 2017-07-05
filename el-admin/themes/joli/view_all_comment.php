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
                <h2><span class="fa fa-file-text-o"></span>Posts</h2>
            </div>

            <div class="panel-body">
              <div class="row" style="margin-bottom:5px;">
                <h1>All comments(<?=$this->num_comment; ?>)</h1>
                <form action="<?=$this->form_url; ?>" method="post" name="batch_action_form" id="batch_action_form">
                <select class="col-md-3" name="batch_action">
                  <option value="">Select Batch Action</option>
                  <option value="delete">Delete</option>
                  <option value="publish">Publish</option>
                  <option value="clone">Clone</option>
                  <option value="draft">Draft</option>
                  <option value="page">Convert post to page</option>
                  <option value="pageToPost">Convert page to post</option>
                </select>
                <input type="submit" class="btn btn-flat btn-default" value="Apply"/>
                <a href="<?=$this->form_url;?>/newpost" class="btn btn-flat btn-default">Add New</a>

                <ul class="pagination pagination-sm pull-right">
                    <?=$this->pagers; ?>
                </ul>
              </div>
              <div class="row">
                <div class="table-responsive">
                    <table style="margin-bottom:5px;" class="table table-bordered table-striped table-actions">
                        <thead>
                          <?php if($this->post_rows != '<b style="color:red;">Data is Empty!</b>') {
                          ?>

                          <tr>
                              <th><input type="checkbox" name="select_all" id="select_all"/></th>
                              <th>Comment ID</th>
                              <th>Author</th>
                              <th>Email</th>
                              <th>COmment Status</th>
                              <th>IP Address</th>
                              <th>Content</th>
                              <th>Date</th>
                              <th>Action</th>
                          </tr>

                          <?php
                          } ?>

                        </thead>
                        <tbody>
                            <?=$this->post_rows; ?>
                        </tbody>
                    </table>
                </div>
              </div>
              <div class="row" style="margin-bottom:5px;">
                <ul class="pagination pagination-sm pull-right">
                    <?=$this->pagers; ?>
                </ul>
              </div>
            </form>


            </div>
        </div>

    </div>
</div>
<?php $this->getDashboardFooter(); ?>

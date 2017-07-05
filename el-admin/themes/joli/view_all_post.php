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
                <h1><?=$this->mmm; ?></h1>
                <form action="<?=$this->form_url; ?>" method="post" name="batch_action_form" id="batch_action_form">
                <h3 class=""><a href="<?=$this->form_url;?>?filter="><b>All Posts(<?=$this->num_post; ?>)</b></a>
                  | <a href="<?=$this->form_url;?>?filter=publish"><b>Published(<?=$this->num_publish; ?>)</b></a>
                  | <a href="<?=$this->form_url;?>?filter=page"><b>Pages(<?=$this->num_page; ?>)</b></a>
                  | <a href="<?=$this->form_url;?>?filter=draft"><b>Drafts(<?=$this->num_draft; ?>)</b></a> | <a href="<?=$this->form_url;?>?filter=trashed"><b>Trash(<?=$this->num_trash; ?>)</b></a></h3>
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
                              <th>Post ID</th>
                              <th>Author</th>
                              <th>Title</th>
                              <th>Category</th>
                              <th>Status</th>
                              <th>Featured Image</th>
                              <th>Tags</th>
                              <th>Comments</th>
                              <th>Date</th>
                              <th>Actions</th>
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

<?php
  $this->getHeader();
?>

<div id="content">
  <div style="font-size:20px;" class="container background-gray-lighter">
      <div class="row">
          <p class="pull-right animate fadeIn text-center margin-bottom-10 margin-top-10"><?=$this->get('bread_crumb'); ?></p>
      </div>
  </div>
                        <div class="container">
                          <div class="row margin-top-15">
                              <!--<?=$this->get('categories'); ?>-->
                          </div>
                          <h2 class="margin-top-10"><?=$this->get('headText'); ?></h2>
                            <div class="row margin-vert-30">
                                <!-- Main Column -->
                                <div style="border-right: 1px solid #f4f4f4;" class="col-md-8">

                                    <?=$this->post_row; ?>
                                    <ul class="pagination">
                                        <?=$this->pagers; ?>
                                    </ul>
                                    <!-- End Pagination -->
                                </div>
                                <!-- End Main Column -->
                                <!-- Side Column -->
                                <div class="col-md-4">
                                  <!-- Blog Search -->
                                  <div class="panel panel-default">
                                    <div class="panel-body">
                                      <form action="<?=$this->get('home').'/blog'; ?>" method="POST" class="form-search search-404">
                                          <div class="input-append">
                                              <input name="search_post" style ="background-color: rgb(255, 255, 255); background-image: none; border-radius: 5px; box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset; transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s; padding: 6px 12px; line-height: 1.42857; color: rgb(85, 85, 85); border: 1px solid rgb(204, 204, 204); width:75%" placeholder="What are you looking for?" class="span2 search-query" type="text">
                                              <button type="submit" class="btn btn-primary">Search!</button>
                                          </div>
                                      </form>
                                    </div>
                                  </div>

                                  <div class="recent-posts">
                                    <div class="panel panel-default">
                                      <div class="panel-heading">
                                          <h2>Audio Resources</h2>
                                      </div>
                                      <div class="panel-body">
                                        <ul class="posts-list margin-top-10">
                                          <?=$this->audios; ?>
                                        </ul>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="recent-posts">
                                    <div class="panel panel-default">
                                      <div class="panel-heading">
                                          <h2>Video Resources</h2>
                                      </div>
                                      <div class="panel-body">
                                        <ul class="posts-list margin-top-10">
                                          <?=$this->videos; ?>
                                        </ul>
                                      </div>
                                    </div>
                                  </div>

                                    <!-- Blog Tags -->
                                    <div class="panel panel-default">
                                      <div class="panel-heading">
                                          <h2>Tags</h2>
                                      </div>
                                      <div class="panel-body">
                                        <ul class="blog-tags">
                                            <?=$this->post_tags; ?>
                                        </ul>
                                    </div>
                                  </div>
                                    <!-- End Blog Tags -->
                                    <!-- Recent Posts -->
                                    <div class="panel panel-default">
                                      <div class="panel-heading">
                                          <h2>Recent Posts</h2>
                                      </div>
                                      <div class="panel-body">
                                        <ul class="posts-list margin-top-10">
                                          <?=$this->recents; ?>
                                        </ul>
                                      </div>
                                    </div>
                                    <!-- End Recent Posts -->

                                    <div class="panel panel-default">
                                      <div class="panel-body">
                                        <ul class="posts-list margin-top-10">
                                          Adverts will be here when ready.
                                        </ul>
                                      </div>
                                    </div>
                                </div>
                                <!-- End Side Column -->
                            </div>
                        </div>
                    </div>

<?php
  $this->getFooter();
?>

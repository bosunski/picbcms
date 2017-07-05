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
                              <?=$this->get('categories'); ?>
                          </div>
                            <div class="row margin-vert-30">
                                <!-- Main Column -->
                                <div class="col-md-8">
                                    <div class="blog-post">
                                        <div class="blog-item-header">
                                            <h2>
                                                <?=$this->post['post_title']; ?>
                                            </h2>
                                        </div>

                                        <div class="blog-post-details">
                                            <!-- Author Name -->
                                            <div class="blog-post-details-item blog-post-details-item-left user-icon">
                                                <i class="fa fa-user color-gray-light"></i>
                                                <?=$this->author_link; ?>
                                            </div>
                                            <!-- End Author Name -->
                                            <!-- Date -->
                                            <div class="blog-post-details-item blog-post-details-item-left">
                                                <i class="fa fa-calendar color-gray-light"></i>
                                                <?=$this->post['post_date']; ?>
                                            </div>
                                            <!-- End Date -->

                                            <!-- # of Comments -->
                                            <div class="blog-post-details-item blog-post-details-item-left blog-post-details-item-last">
                                                <a href="<?=$this->get('form_url'); ?>/#disqus_thread">
                                                    <i class="fa fa-comments color-green-light"></i>
                                                    <!--<?=$this->cnts; ?>-->
                                                </a>
                                            </div>
                                            <!-- End # of Comments -->
                                        </div>
                                        <div class="blog-item">
                                            <div class="clearfix"></div>
                                            <div class="blog-post-body row margin-top-15">
                                              <?=$this->f_image.reverse_simple_clean($this->post['post_content']); ?>

                                              <h2>
                                              <ul class="social-icons color">
                                                <li style="background:none;">Enjoyed this? Do well to share:</li>
                                                  <!--<li class="social-rss">
                                                      <a href="<?=$this->rss_link; ?>" target="_blank" title="RSS"></a>
                                                  </li>-->
                                                  <li class="social-twitter">
                                                      <a href="https://twitter.com/intent/tweet?text=<?=$this->post['post_title']; ?>&url=<?=$this->get('form_url'); ?>" target="_blank" title="Twitter"></a>
                                                  </li>
                                                  <li class="social-facebook">
                                                      <a rel="nofollow" href="https://www.facebook.com/sharer.php?u=<?=$this->get('form_url'); ?>" target="_blank" title="Facebook"></a>
                                                  </li>
                                                  <li class="social-googleplus">
                                                      <a href="https://plus.google.com/share?url=<?=$this->get('form_url'); ?>" target="_blank" title="GooglePlus"></a>
                                                  </li>
                                              </ul>
<fb:like href="https://developers.facebook.com/" width="450" height="80"></fb:like>
                                            </h2>
                                            </div>
                                          </div>
                                    </div>
                                    <!-- End Blog Post -->
                                    <h1 id="comments"><span class="fa-comments"></span>Comments</h1>


                                    <!-- Discuss Thread -->
                                    <div id="disqus_thread"></div>
                                      <script>
                                        (function() { // DON'T EDIT BELOW THIS LINE
                                          var d = document, s = d.createElement('script');
                                          s.src = '//seun-speaks.disqus.com/embed.js';
                                          s.setAttribute('data-timestamp', +new Date());
                                          (d.head || d.body).appendChild(s);
                                        })();
                                      </script>
                                      <noscript>
                                        Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a>
                                      </noscript>

                                    <!-- Discus Thread Ends -->
                                    <!--<?=$this->comment_rows; ?>
                                    <ul style="padding-left:12px;" class="pagination">
                                      <?=$this->pagers; ?>
                                    </ul>-->

                                    <div class="blog-item-footer">
                                        <br /><br/>
                                        <!-- Comments
                                        <div  class="blog-recent-comments panel panel-default margin-bottom-30">
                                            <ul class="list-group">

                                                <!-- Comment Form -
                                                <li class="list-group-item">
                                                    <div class="blog-comment-form">
                                                        <div class="row margin-top-20">
                                                            <div class="col-md-12">
                                                                <div class="pull-left">
                                                                    <h3>Leave a Comment</h3>
                                                                    Fields marked <span style="color:red;">*</span> are required.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row margin-top-20">
                                                            <div class="col-md-12">
                                                                <form name="com_form" action="<?=$this->form_url; ?>" method="POST">
                                                                    <label>Name <span style="color:red;">*</span></label>
                                                                    <div class="row margin-bottom-20">
                                                                        <div class="col-md-7 col-md-offset-0">
                                                                            <input <?=$this->comment_name; ?> name="name" class="form-control" type="text">
                                                                        </div>
                                                                    </div>
                                                                    <label>Email
                                                                        <span style="color:red;">*</span>
                                                                    </label>
                                                                    <div class="row margin-bottom-20">
                                                                        <div class="col-md-7 col-md-offset-0">
                                                                            <input <?=$this->comment_email; ?> name="email" class="form-control" type="text">
                                                                        </div>
                                                                    </div>
                                                                    <label>Comment <span style="color:red;">*</span></label>
                                                                    <div class="row margin-bottom-20">
                                                                        <div class="col-md-11 col-md-offset-0">
                                                                            <textarea name="comment" class="form-control" rows="8"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <p>
                                                                        <button name="addComment" class="btn btn-primary" type="submit">Post Comment</button>
                                                                    </p>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <!-- End Comment Form
                                            </ul> -
                                        </div>
                                        <!-- End Comments -->
                                    </div>

                                </div>
                                <!-- End Main Column -->
                                <!-- Side Column -->
                                <div class="col-md-4">
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
                                    <div class="blog-tags">
                                      <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3>Tags</h3>
                                        </div>
                                        <div class="panel-body">
                                          <ul class="blog-tags">
                                              <?=$this->post_tags; ?>
                                          </ul>
                                      </div>
                                    </div>
                                    </div>
                                    <!-- End Blog Tags -->
                                    <!-- Recent Posts -->
                                    <div class="recent-posts">
                                      <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3>Recent Posts</h3>
                                        </div>
                                        <div class="panel-body">
                                          <ul class="posts-list margin-top-10">
                                            <?=$this->recents; ?>
                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                    <!-- End Recent Posts -->

                                    <div class="recent-posts">
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
                    </div>
                  </div>
                </div>

<?php
  $this->getFooter();
?>

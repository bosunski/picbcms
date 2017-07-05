<?php
   $this->getHeader();
?>

<div id="content">
                        <div class="container">
                            <div class="row margin-vert-30">
                                <!-- Main Column -->
                                <div class="col-md-9">
                                    <!-- Main Content -->
                                    <?=$this->msg; ?>
                                    <div class="headline">
                                        <h2>Seek Counsel</h2>
                                    </div>
                                    <p>You can use this medium to contact us or encourage us. We can also get
                                    back to you if there is the need. Please ensure that you indicate your phone number in the message box.</p>
                                    <br>
                                    <!-- Contact Form -->
                                    <form action="" method="POST">
                                        <label>Name <span class="color-red">*</span></label>
                                        <div class="row margin-bottom-20">
                                            <div class="col-md-6 col-md-offset-0">
                                                <input name="name" class="form-control" type="text">
                                            </div>
                                        </div>
                                        <label>Email
                                            <span class="color-red">*</span>
                                        </label>
                                        <div class="row margin-bottom-20">
                                            <div class="col-md-6 col-md-offset-0">
                                                <input name="email" class="form-control" type="text">
                                            </div>
                                        </div>
                                        <label>Message <span class="color-red">*</span></label>
                                        <div class="row margin-bottom-20">
                                            <div class="col-md-8 col-md-offset-0">
                                                <textarea name="message" rows="8" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <p>
                                            <button type="submit" class="btn btn-primary">Send Message</button>
                                        </p>
                                    </form>
                                    <!-- End Contact Form -->
                                    <!-- End Main Content -->
                                </div>
                                <!-- End Main Column -->
                                <!-- Side Column -->
                                <div class="col-md-3">
                                    <!-- Recent Posts -->
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Our Details</h3>
                                        </div>
                                        <div class="panel-body">
                                          <ul class="list-unstyled">
                                                <li>
                                                    <i class="fa-phone color-primary"></i><?=$this->blog_phone; ?></li>
                                                <li>
                                                    <i class="fa-envelope color-primary"></i><?=$this->blog_email; ?></li>
                                                <li>
                                                    <i class="fa-home color-primary"></i><?=$this->blog_address; ?></li>
                                            </ul>

                                        </div>
                                    </div>
                                    <!-- End recent Posts -->
                                </div>
                                <!-- End Side Column -->
                            </div>
                        </div>
                    </div>

                    <?php
                       $this->getFooter();
                    ?>

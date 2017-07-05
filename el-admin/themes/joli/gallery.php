<?php
	$this->getDashBoardHeader();
?>

					<div class="row">
                     	<div class="col-md-9">
                        <?=$this->msg; ?>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h3><span class="fa fa-media"></span> Showing all images</h3>
                                    <div style="height: 985px;" class="content-frame-body content-frame-body-left">

                        <div class="pull-left push-up-10">
                            <button class="btn btn-primary" id="gallery-toggle-items">Toggle All</button>
                        </div>
                        <script type="text/javascript">
                        function voice() {
                          var r = confirm("Are you sure you want to delete the image(s)?");
                          if(r)
                            return true;
                          return false;
                        }
                        </script>
                        <form id="images_del" onsubmit="return voice();" action="" method="POST">
                        <div class="pull-right push-up-10">
                            <div class="btn-group">

                                <button  class="btn btn-primary"><span class="fa fa-trash-o"></span> Delete</button>

                            </div>
                        </div>

												<div style="display: none;" id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
								            <div style="width: 21648px;" class="slides"></div>
								            <h3 class="title"></h3>
								            <a class="prev">‹</a>
								            <a class="next">›</a>
								            <a class="close">×</a>
								            <a class="play-pause"></a>
								            <ol class="indicator"></ol>
								        </div>
                        <div class="gallery" id="links">
                            <?=$this->pics_row; ?>
                        </div>
                      </form>

                        <ul class="pagination pagination-sm pull-right push-down-20 push-up-20">
                            <?=$this->pagers; ?>
                        </ul>
                    </div>
                                  </div>
                            </div>
                        </div>

                        <div class="col-md-3">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h3><span class="fa fa-upload"></span> Upload new image to gallery</h3>
                                    <form enctype="multipart/form-data" method="POST" class="form-horizontal" action="<?=$this->form_url; ?>">
                                    	<div class="form-group">
	                                        <div class="col-md-12">
		                                        <span class="file-input file-input-new">
		                                        	<div class="file-preview ">
                    													   <div class="close fileinput-remove text-right">×</div>
                    													   <div class="file-preview-thumbnails"></div>
                    													   <div class="clearfix"></div>
                    													   <div class="file-preview-status text-center text-success"></div>
                    													</div>
													                    <input name="gal_pic[]" multiple="" id="file-simple" type="file"><br/>
																							<p> Image must not be more than 1080x360 in resolution.</p>
                                              <button class="btn btn-success" name="upl_gallery" id="upl_gallery">Upload Image</button>
												                    </span>
	                                        </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>

                    </div>

										<?php
											$this->getDashBoardFooter();
										?>

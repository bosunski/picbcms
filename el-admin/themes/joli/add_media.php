<?php
	$this->getDashBoardHeader();
?>
					<div class="row">
                     	<div class="col-md-9">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h3><span class="fa fa-upload"></span> Upload New Media</h3>
                                    <form action="#" class="dropzone dz-clickable"><div class="dz-default dz-message"><span>Drop files here to upload</span></div></form>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-3">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h3><span class="fa fa-upload"></span> Or try the Simple Uploader</h3>
                                    <form enctype="multipart/form-data" class="form-horizontal">
                                    	<div class="form-group">
	                                        <div class="col-md-12">
		                                        <span class="file-input file-input-new">
		                                        	<div class="file-preview ">
													   <div class="close fileinput-remove text-right">×</div>
													   <div class="file-preview-thumbnails"></div>
													   <div class="clearfix"></div>
													   <div class="file-preview-status text-center text-success"></div>
													</div>
													<input multiple="" id="file-simple" type="file">
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

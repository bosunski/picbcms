<?php

?>
<div class="row">
	<div class="content-frame">  
        <!-- START CONTENT FRAME TOP -->                        
            <div class="page-title">                    
                <h2><span class="fa fa-plus-square"></span> Add new page</h2>
            </div>   
        
        <!-- START CONTENT FRAME BODY -->
        <div class="col-md-9">
            <div class="col-md-12">
            	<div class="block">
                    <form class="form-horizontal" role="form">                                    
                        <div class="form-group">
                            <div class="col-md-12">
                                <input style="border-radius:0px;font-size: 20px; font-weight: bold; height: 40px;" class="form-control" placeholder="Enter Page Title" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="btn-group">
                                <a  class="btn btn-primary pull-right"><span class="fa fa-music"></span> Add Media</a>
                            </div>                            
                        </div>                                                                        
                        <div class="form-group">
                            <div class="col-md-12">
                                <textarea class="summernote form-control" rows="3"></textarea>
                            </div>
                        </div>                                    
                    </form>
                </div>
            </div>
        </div>       
        <!-- END CONTENT FRAME BODY -->

        <!-- START CONTENT FRAME RIGHT -->
        <div class="col-md-3">                        
            <div class="block push-up-10">
                <div class="col-md-12">
				    <!-- START VISITORS BLOCK -->
				    <div class="panel panel-default">
				        <div style="height:40px;" class="panel-heading ui-draggable-handle">
				            <div class="panel-title-box">
				                <h3>Visitors</h3>
				            </div>
				            <ul class="panel-controls" style="margin-top: 1px;">
				                <li><a href="#" style="border:0px;line-height:2px;" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>                                  
				            </ul>
				        </div>
				        <div class="panel-body"> 
				        	<div>
					        	<button class="btn btn-default">Save Draft</button>
					        	<button class="btn btn-default pull-right">Preview</button>
					        </div><br/>
				        	<div>
				        		<h4> <span class="fa fa-key"></span> Status: <b>Draft</b> <a href="#">Edit</a></h4>
				        	</div>
				        	<div>
				        		<p> <span class="fa fa-eye"></span> Visibility: <b>Public</b> <a href="#">Edit</a></p>
				        	</div>
				        	<div>
				        		<p> <span class="fa fa-calendar"></span> Publish: <b>Imediately</b> <a href="#">Edit</a></p>
				        	</div>
				        </div>
				        <div class="panel-footer">
				        	<button class="btn btn-danger"><span class="fa fa-trash-o"></span> Trash</button>
				        	<button class="btn btn-success pull-right"><i class="fa fa-calendar"></i> Publish</button>
				        </div>
				    </div>
				    <!-- END VISITORS BLOCK -->
				   </div>
            </div>
            <div class="block push-up-10">
                <div class="col-md-12">
				    <!-- START VISITORS BLOCK -->
				    <div class="panel panel-default">
				        <div style="height:40px;" class="panel-heading ui-draggable-handle">
				            <div class="panel-title-box">
				                <h3>Page Attributes</h3>
				            </div>
				            <ul class="panel-controls" style="margin-top: 1px;">
				                <li><a href="#" style="border:0px;line-height:2px;" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>                                  
				            </ul>
				        </div>
				        <div class="panel-body"> 
				        	<div>
				        		<h4><b>Parent</b></h4>
				        		<select>
				        			<option value="">(No Parent)</option>
				        			<option>Sermon</option>
				        			<option>Workers</option>
				        			<option>Comunity</option>

				        		</select><br/><br/>
				        		<h4><b>Order</b></h4>
				        		<div class="form-group col-md-6">
				        			<input type="text" class="form-control" value="0"/>
				        		</div>
				        		
				        	</div>
				        </div>
				    </div>
				    <!-- END VISITORS BLOCK -->
				   </div>
            </div>
            <div class="block push-up-10">
                <div class="col-md-12">
				    <!-- START VISITORS BLOCK -->
				    <div class="panel panel-default">
				        <div style="height:40px;" class="panel-heading ui-draggable-handle">
				            <div class="panel-title-box">
				                <h3>Set Featured Image</h3>
				            </div>
				            <ul class="panel-controls" style="margin-top: 1px;">
				                <li><a href="#" style="border:0px;line-height:2px;" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>                                  
				            </ul>
				        </div>
				        <div class="panel-body"> 
				        	<div>
				        		<h4> <span class="fa fa-image"></span> <a href="#">Select Image</a></h4>
				        	</div>
				        </div>
				    </div>
				    <!-- END VISITORS BLOCK -->
				   </div>
            </div>                        
        </div>
        <!-- END CONTENT FRAME RIGHT -->
    </div>
</div>
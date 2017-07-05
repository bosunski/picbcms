<?php
  $this->getHeader();
?>

<div id="content">
  <div style="font-size:20px;" class="container background-gray-lighter">
      <div class="row">
          <p class="pull-right animate fadeIn text-center margin-bottom-10 margin-top-10">No Where!</p>
      </div>
  </div>
                        <div class="container">
                            <div class="row margin-vert-30">
                                <div class="col-md-12">
                                    <div class="error-404-page text-center">
                                        <h2>404!</h2>
                                        <h3>The page can not be found</h3>
                                        <p>The page you are looking for might have been removed,
                                            <br>had its name changed or is temporarily unavailable.</p>

                                                <button class="btn btn-info" onclick="document.location.href = '<?=get_option("home"); ?>';">Back to <span class="fa fa-home"></span>HOME</button>


                                                <button class="btn btn-primary" onclick="history.back();"><span class="fa fa-arrow-left"></span>Previous page</button>
                                                <br/><br/>

                                        <form class="form-search search-404">
                                            <div class="input-append">
                                                <input class="span2 search-query" type="text">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<?php
  $this->getFooter();
?>

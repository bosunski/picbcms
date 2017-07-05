<?php
   $this->getHeader();
?>

<div id="content">
  <div style="font-size:20px;" class="container background-gray-lighter">
      <div class="row">
          <p class="pull-right animate fadeIn text-center margin-bottom-10 margin-top-10"><?=$this->get('bread_crumb'); ?></p>
      </div>
  </div>
    <div class="container no-padding">
      <div class="row">
        <div class="col-md-6 ">
                <ul class="menu">
                    <li>
                        <a class="" href=""><h2>Sharable Memes</h2></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
          </div>
      </div>
      <div class="row">
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
        <ul style="margin-right:20px;" class="pagination pagination-sm pull-right push-down-20 push-up-20">
          <?=$this->pagers; ?>
        </ul>
    </div>
    </div>
</div>
<!-- === END CONTENT === -->

<?php
   $this->getFooter();
?>

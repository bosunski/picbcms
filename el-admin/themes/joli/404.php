<?php
    $this->getDashboardHeader();
?>
 <div class="page-content-wrap">
 <div class="row">
<div class="col-md-12">
	<div class="error-container">
        <div class="error-code">404</div>
        <div class="error-text">page not found</div>
        <div class="error-subtext">Unfortunately we couldn't find what you are looking for.</div>
        <div class="error-actions">
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-info btn-block btn-lg" onclick="document.location.href = '<?=get_option("home"); ?>/el-admin';">Back to dashboard</button>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-primary btn-block btn-lg" onclick="history.back();">Previous page</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<?php
    $this->getDashboardFooter();
?>

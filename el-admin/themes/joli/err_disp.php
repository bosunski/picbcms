<?php
	$this->getDashboardHeader();
	$post_title = isset($this->post_title) ? 'value="'.$this->post_title.'"' : '';
	$post_content = isset($this->post_content) ? $this->post_content : '';
	$post_status = isset($this->post_status) ? 'value="' . $this->post_status . '"' : '';
	$post_parent = isset($this->post_parent) ? 'value="' . $this->post_parent . '"' : '';
	$msg = (null !== $this->get('msg')) ? $this->get('msg') : '';
?>
<div class="row">
	<div class="col-md-12">
		<form id="post-edit-form" action="<?=$this->get('form_url');?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
			<?=$msg; ?>
    </form>
  </div>
</div>

<?php
	$this->getDashboardFooter();
?>

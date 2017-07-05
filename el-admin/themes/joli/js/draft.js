var home = '';
$.get('indexi.php', function(result) {
	home = result;

});

function showMessageToggle(selector, message) {
	selector.html(message);
	setTimeout(function() {
		selector.html('');
	}, 3000);
}
$(document).ready(function() {
	$(".save-draft").click(function() {
		if($(".dtitle").val() == '') {
			//alert('good');
			$(".dtitle").focus();
			$(".dtitle").parent('div').addClass('has-error');
			showMessageToggle($(".dstatus"), '<blockquote class="" style="padding:0px 5px 20px; height:15px;border-left-color:red;"> Input Title.</blockquote>');
		} else if($(".dbody").val() == '') {
			//alert('good');
			$(".dbody").focus();
			$(".dbody").parent('div').addClass('has-error');
			showMessageToggle($(".dstatus"), '<blockquote style="padding:0px 5px 20px;height:15px;border-left-color:red;">Body is empty.</blockquote>');
		} else {
			$.ajax({
				type: 'POST',
				url: home+'/el-admin/dashboard/addDraft',
				data: $("#draft-form :input").serializeArray(),
				cache: false,
				success: function(a) {
					$(".dbody").parent('div').removeClass('has-error');
					$(".dtitle").parent('div').removeClass('has-error');
					$(".three-drafts").html(a);
					showMessageToggle($(".dstatus"), '<blockquote style="padding:0px 5px 20px;height:15px;border-left-color:green;">Draft Saved.</blockquote>');
				}, 
				failure: function() {
					showMessageToggle($(".dstatus"), '<blockquote style="padding:0px 5px 20px;height:15px;border-left-color:red;">An Error occured. Reload and try again.</blockquote>');
				}
			});
		}
	});
});

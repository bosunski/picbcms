$(document).ready(function() {
	var href = window.location.href;
	var arr = href.split('?action');
	var state = { "a": true};
	window.history.replaceState(state, "Title", arr[0]);
		var select_all = document.getElementById("select_all").checked;
	  $("#select_all").click(function() {
			var form = document.getElementById('batch_action_form');
			var check_boxes = document.getElementsByName('post_id[]');
			for(var x = 0; x < check_boxes.length; x++) {
				is_checked = check_boxes[x].checked;
				if(select_all) {
					check_boxes[x].checked = false;
				} else {
					check_boxes[x].checked = true;
				}
			}
			select_all = (select_all) ? false : true;
		});
});

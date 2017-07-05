var home = '';
var ajaxsent = '';
var resp = '';
$.get('getHome', function(result) {
	home = result;
});

function sendAjaxr(type, data, url, options = null) {
	$.ajax({
		url: url,
		data: data,
		type: type,
		success: function(res) {
			resp = res;
		},
		failure: function(re) {
			resp =  'Cannot communicate with server, please make sure you are connected';
		}
	});
}

function saveTags() {
	if($('.post-tags').val() !== '') {
		var id = $('.post-tags').attr('id');
		var pid = id.substr(id.lastIndexOf('-')+1, id.length);
		url = home + '/el-admin/elajax/updateTag/?id='+pid+'&post_tag='+$('.post-tags').val();
		$.ajax({
			url: url,
			type: 'GET',
			success: function(response) {
				$(".list-tags").html(response);
			},
			failure: function(re) {
				response =  'cannot communicate with server, please make sure you are connected';
				$(".list-tags").html(response);
			}
		});

		setTimeout(function() {
			attach_event_for_tags();
		}, 1000);
	}
}
function deleteTag(e) {
	var tag_val = $(e).next().html();
	var id = $('.post-tags').attr('id');
	var pid = id.substr(id.lastIndexOf('-')+1, id.length);
	url = home + '/el-admin/elajax/delTag/?id='+pid+'&tag_val='+tag_val;
	$.ajax({
		type: 'GET',
		url: url,
		cache: false,
		success: function(info) {if(info == 'done') {$(e).parent().parent().remove();}},
		failure: function() { alert('Cannot send Request'); }
	});
}
function attach_event_for_tags() {
	$(".each-tag").click(function(){
		deleteTag(this);
	});
}

function savePostEdit() {
	var st = false;
	tinyMCE.triggerSave();
	var link = window.location.href;
	var pos = link.lastIndexOf('/');
	var pid = link.substr(pos+1, link.length);
	var data = $("#post-edit-form").serializeArray();
	$.ajax({
		url: home + '/el-admin/post/updatePost/' + pid,
		type: 'POST',
		data: data,
		cache: false,
		success: function(a) {
			return true;
		}
	});
}
function slidUpAndShow(selector, show) {
	$(selector).slideUp('fast');
	$(show).show();
}
function showQuotedMsg(text, color) {
	var msg = '<blockquote style="border-left-color:'+color+';">'+text+'</blockquote>';
	$(".quoted-message").html(msg);

}

$(document).ready(function() {
	var href = window.location.href;
	var arr = href.split('?');
	var state = { "a": true};
	window.history.replaceState(state, "Title", arr[0]);
	$(".edit-postname").on('click', function() {
		$(".perma-input").val($(".post-name").html());
		$(".post-name").hide();$(".perm-settings-button").hide();$(".perm-input").show();
		$(".ok-perm").on('click', function() {
			var id = $(this).attr('eyedee');
			if($(".perma-input").val() != '') {
				$.ajax({
					type: 'POST',
					url: home + '/el-admin/post/updateperm/'+id,
					data: $(".perma-input").serializeArray(),
					success: function(info) {
						var d = info.split('||');
						if(d[1] == 'done') {
							$(".post-name").show();$(".perm-settings-button").show();$(".perm-input").hide();
							$(".post-name").html(d[0]);
							$("#perm-stat").html('');
						} else {
							$(".post-name").show();$(".perm-settings-button").show();$(".perm-input").hide();
							$("#perm-stat").html(info);
						}
					},
					failure: function(a) {

					}
				});
			} else {
				$(".post-name").show();$(".perm-settings-button").show();$(".perm-input").hide();
				$("#perm-stat").html(info);
			}

		});

		$(".cancel-perm").on('click', function() {
			$(".post-name").show();$(".perm-settings-button").show();$(".perm-input").hide();
		});
	});

	var autoSaveInterval = setInterval(function() {
		//$("#post-edit-form").submit();
		//alert(savePostEdit());
		//if() {
			//showQuotedMsg('Auto Saved.');
		//}
	}, 5000);

	$(".save-post-draft").on('click', function() {
		if(savePostEdit()) {
			showQuotedMsg('Draft Saved Successfully');
		}
		$("#post-edit-form").submit();
		$("#publish-edit-form").submit();
	});

	$("#ed-post-status").on('click', function() {
		$("#status-options").slideDown('fast');
		$(this).hide();
	});

	$("#ed-post-visibility").on('click', function() {
		$("#visibility-options").slideDown('fast');
		$(this).hide();
	});

	$("#ed-post-publishdate").on('click', function() {
		$("#publishing-options").slideDown('fast');
		$(this).hide();
	});

	attach_event_for_tags();

	$("#post-status").change(function() {
		var sas = $("#post-status").val() == '' ? '...' : $("#post-status").val();
		$(".save-post-draft").html('Save as '+sas);
		//$(".bold-status").html($("#post-status").val());
		//$("#status-options").slideUp('fast');
		//slidUpAndShow('#status-options', '#ed-post-status');
		//$(this).hide();
	});

	$().click(function() {
		$().submit();
	});
});

			tinymce.init({
						end_container_on_empty_block: true,
	                      selector: "#pbody",
	                      height: 350,
	                      plugins: [
	                        "alphamanager advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
	                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
	                        "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
	                      ],

	                      toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
	                      toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
	                      toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",

	                      menubar: false,
	                      toolbar_items_size: 'small',
	                      content_css: []
	        });

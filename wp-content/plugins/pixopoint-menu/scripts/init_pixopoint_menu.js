jQuery(function($) {


	$('#colour1').hide().farbtastic('#inputbox_colour1').dialog({ width: 230, autoOpen:  false, modal: true });
	$('#button_colour1').click(function(){
		$('#colour1').dialog('open');
	});

	$('#colour2').hide().farbtastic('#inputbox_colour2').dialog({ width: 230, autoOpen:  false, modal: true });
	$('#button_colour2').click(function(){
		$('#colour2').dialog('open');
	});

	$('#colour4').hide().farbtastic('#inputbox_colour4').dialog({ width: 230, autoOpen:  false, modal: true });
	$('#button_colour4').click(function(){
		$('#colour4').dialog('open');
	});

	$('#colour5').hide().farbtastic('#inputbox_colour5').dialog({ width: 230, autoOpen:  false, modal: true });
	$('#button_colour5').click(function(){
		$('#colour5').dialog('open');
	});

	$('#colour6').hide().farbtastic('#inputbox_colour6').dialog({ width: 230, autoOpen:  false, modal: true });
	$('#button_colour6').click(function(){
		$('#colour6').dialog('open');
	});

	$('#colour7').hide().farbtastic('#inputbox_colour7').dialog({ width: 230, autoOpen:  false, modal: true });
	$('#button_colour7').click(function(){
		$('#colour7').dialog('open');
	});

	$('#colour8').hide().farbtastic('#inputbox_colour8').dialog({ width: 230, autoOpen:  false, modal: true });
	$('#button_colour8').click(function(){
		$('#colour8').dialog('open');
	});

	$('#colour9').hide().farbtastic('#inputbox_colour9').dialog({ width: 230, autoOpen:  false, modal: true });
	$('#button_colour9').click(function(){
		$('#colour9').dialog('open');
	});

	$('#colour10').hide().farbtastic('#inputbox_colour10').dialog({ width: 230, autoOpen:  false, modal: true });
	$('#button_colour10').click(function(){
		$('#colour10').dialog('open');
	});

	$('#colour21').hide().farbtastic('#inputbox_colour21').dialog({ width: 230, autoOpen:  false, modal: true });
	$('#button_colour21').click(function(){
		$('#colour21').dialog('open');
	});







	$('#colour11').hide().farbtastic('#inputbox_colour11').dialog({ width: 230, autoOpen:  false, modal: true });
	$('#button_colour11').click(function(){
		$('#colour11').dialog('open');
	});

	$('#colour12').hide().farbtastic('#inputbox_colour12').dialog({ width: 230, autoOpen:  false, modal: true });
	$('#button_colour12').click(function(){
		$('#colour12').dialog('open');
	});

	$('#colour14').hide().farbtastic('#inputbox_colour14').dialog({ width: 230, autoOpen:  false, modal: true });
	$('#button_colour14').click(function(){
		$('#colour14').dialog('open');
	});

	$('#colour15').hide().farbtastic('#inputbox_colour15').dialog({ width: 230, autoOpen:  false, modal: true });
	$('#button_colour15').click(function(){
		$('#colour15').dialog('open');
	});

	$('#colour16').hide().farbtastic('#inputbox_colour16').dialog({ width: 230, autoOpen:  false, modal: true });
	$('#button_colour16').click(function(){
		$('#colour16').dialog('open');
	});

	$('#colour17').hide().farbtastic('#inputbox_colour17').dialog({ width: 230, autoOpen:  false, modal: true });
	$('#button_colour17').click(function(){
		$('#colour17').dialog('open');
	});

	$('#colour18').hide().farbtastic('#inputbox_colour18').dialog({ width: 230, autoOpen:  false, modal: true });
	$('#button_colour18').click(function(){
		$('#colour18').dialog('open');
	});

	$('#colour19').hide().farbtastic('#inputbox_colour19').dialog({ width: 230, autoOpen:  false, modal: true });
	$('#button_colour19').click(function(){
		$('#colour19').dialog('open');
	});

	$('#colour20').hide().farbtastic('#inputbox_colour20').dialog({ width: 230, autoOpen:  false, modal: true });
	$('#button_colour20').click(function(){
		$('#colour20').dialog('open');
	});

	$('#colour31').hide().farbtastic('#inputbox_colour31').dialog({ width: 230, autoOpen:  false, modal: true });
	$('#button_colour31').click(function(){
		$('#colour31').dialog('open');
	});


	$('#menu1_bgimage_chooser1').dialog({width: 500, autoOpen:false, modal:true});
	$('#menu1_background_image_button').click(function(){
		$('#menu1_bgimage_chooser1').dialog('open');
	});
	$('#menu1_bgimage_chooser1 .bgimage').click(function(){
		$('[name=menu1_background_image]').val(this.src);
		$('#menu1_bgimage_chooser1').dialog('close');
	})

	$('#menu1_bgimage_chooser2').dialog({width: 500, autoOpen:false, modal:true});
	$('#menu1_background_buttonimage_button').click(function(){
		$('#menu1_bgimage_chooser2').dialog('open');
	});
	$('#menu1_bgimage_chooser2 .bgimage').click(function(){
		$('[name=menu1_background_buttonimage]').val(this.src);
		$('#menu1_bgimage_chooser2').dialog('close');
	})


	$('#menu2_bgimage_chooser1').dialog({width: 500, autoOpen:false, modal:true});
	$('#menu2_background_image_button').click(function(){
		$('#menu2_bgimage_chooser1').dialog('open');
	});
	$('#menu2_bgimage_chooser1 .bgimage').click(function(){
		$('[name=menu2_background_image]').val(this.src);
		$('#menu2_bgimage_chooser1').dialog('close');
	})

	$('#menu2_bgimage_chooser2').dialog({width: 500, autoOpen:false, modal:true});
	$('#menu2_background_buttonimage_button').click(function(){
		$('#menu2_bgimage_chooser2').dialog('open');
	});
	$('#menu2_bgimage_chooser2 .bgimage').click(function(){
		$('[name=menu2_background_buttonimage]').val(this.src);
		$('#menu2_bgimage_chooser2').dialog('close');
	})

});

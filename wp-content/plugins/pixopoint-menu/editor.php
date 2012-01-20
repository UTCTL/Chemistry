<?php
/*
	This file loads the editing panel

	PixoPoint Menu Plugin
	Copyright (c) 2009 PixoPoint Web Development

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

require_once(ABSPATH . '/wp-includes/pluggable.php');

// Creates the option boxes for changing font-family
function fontfamilycode($fontfamilyoption,$fontfamilystyling) {global $variable;
	echo '<select name="'.$fontfamilyoption.'" '.$fontfamilystyling.'>';

	$fontselection[0] = $variable[$fontfamilyoption];
	$fontselection[1] = 'helvetica,arial,sans-serif';
	$fontselection[2] = 'tahoma,sans-serif';
	$fontselection[3] = 'verdana,sans-serif';
	$fontselection[4] = 'Trebuchet MS,sans-serif';
	$fontselection[5] = 'Lucida Sans,sans-serif';
	$fontselection[6] = 'times,Times New Roman,serif';
	$fontselection[7] = 'Palatino,serif';
	$fontselection[8] = 'Avant Garde,serif';
	$fontselection[9] = 'Georgia,serif';
	$fontselection[10] = 'Arial Black,Impact,sans-serif';
	$fontselection[11] = 'Impact,Arial Black,sans-serif';
	$fontselection[12] = 'Comic Sans MS,cursive';
	$fontselection[13] = 'courier-new,courier,monospace';

	foreach($fontselection as $key=> $fontchoice) {
		if ($fontchoice == $variable[$fontfamilyoption]) {$fontchoice = '';}
		if ($key == 0) {$fontchoice = $variable[$fontfamilyoption];}
		switch ($fontchoice){
			case "helvetica,arial,sans-serif":echo '<option value="helvetica,arial,sans-serif" style="font-family:helvetica,arial,sans-serif">Helvetica/Arial</option>';break;
			case "tahoma,sans-serif":echo '<option value="tahoma,sans-serif" style="font-family:tahoma,geneva,sans-serif">Tahoma</option>';break;
			case "verdana,sans-serif":echo '<option value="verdana,sans-serif" style="font-family:verdana,sans-serif">Verdana</option>';break;
			case "Trebuchet MS,sans-serif":echo '<option value="Trebuchet MS,sans-serif" style="font-family:Trebuchet MS,sans-serif">Trebuchet</option>';break;
			case "Lucida Sans,sans-serif":echo '<option value="Lucida Sans,sans-serif" style="font-family:Lucida Sans,sans-serif">Lucida Sans</option>';break;
			case "times,Times New Roman,serif":echo '<option value="times,Times New Roman,serif" style="font-family:times,Times New Roman,serif">Times/Times New Roman</option>';break;
			case "Palatino,serif":echo '<option value="Palatino,serif" style="font-family:Palatino,serif">Palatino</option>';break;
			case "Avant Garde,serif":echo '<option value="Avant Garde,serif" style="font-family:Avant Garde,serif">Avant Garde</option>';break;
			case "Georgia,serif":echo '<option value="Georgia,serif" style="font-family:Georgia,serif">Georgia</option>';break;
			case "Arial Black,Impact,sans-serif":echo '<option value="Arial Black,Impact,sans-serif" style="font-family:Arial Black,Impact,sans-serif">Arial Black</option>';break;
			case "Impact,Arial Black,sans-serif":echo '<option value="Impact,Arial Black,sans-serif" style="font-family:Impact,Arial Black,sans-serif">Impact</option>';break;
			case "Comic Sans MS,cursive":echo '<option value="Comic Sans MS,cursive" style="font-family:Comic Sans MS,cursive">Comic Sans</option>';break;
			case "courier-new,courier,monospace":echo '<option value="courier-new,courier,monospace" style="font-family:courier-new,monospace">Courier New</option>';break;
		}
	}
	echo '</select>';
}

// Creates the option boxes for text-transforms
function tab_texttransform($texttransformoption,$texttransformstyling) {global $variable;
	echo '<select name="'.$texttransformoption.'" '.$texttransformstyling.'">';

	$texttransformselection[0] = $variable[$texttransformoption];
	$texttransformselection[1] = 'uppercase';
	$texttransformselection[2] = 'lowercase';
	$texttransformselection[3] = 'capitalize';
	$texttransformselection[4] = 'small-caps';
	$texttransformselection[5] = 'normal';

	foreach($texttransformselection as $key=> $texttransformchoice) {
		if ($texttransformchoice == $variable[$texttransformoption]) {$texttransformchoice = '';}
		if ($key == 0) {$texttransformchoice = $variable[$texttransformoption];}
		switch ($texttransformchoice) {
		case "uppercase":echo '<option value="uppercase">uppercase</option>';break;
		case "lowercase":echo '<option value="lowercase">lowercase</option>';break;
		case "capitalize":echo '<option value="capitalize">capitalize</option>';break;
		case "small-caps":echo '<option value="small-caps">small-caps</option>';break;
		case "":echo '<option value="">normal</option>';break;
		}
	}
	echo '</select>';
}

// Checks to see that the hex colour code is valid
function hex_code_check($colour) {global $variable;
	$length = strlen($variable[$colour]);
	$bla = split('#', $variable[$colour]);
	if ($length > 7 || $length < 4 || eregi('[^abcdef1234567890]', $bla[1])) {$variable[$colour] = '#00FF00';}
}

// Adds list of background images
function pixopoint_menu_images() {global $pixopoint_menu_images;
	echo '
	<img src="'.$pixopoint_menu_images.'smoothfade_paleyellow.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'smoothfade_palewhite.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'smoothfade_palered.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'smoothfade_palepurple.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'smoothfade_palepink.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'smoothfade_paleorange.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'smoothfade_palegrey.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'smoothfade_palegreen.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'smoothfade_palecyan.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'smoothfade_paleblue.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'smoothfade_paleblack.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >

	<img src="'.$pixopoint_menu_images.'smoothfade_darkyellow.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'smoothfade_darkwhite.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'smoothfade_darkred.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'smoothfade_darkpurple.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'smoothfade_darkpink.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'smoothfade_darkorange.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'smoothfade_darkgrey.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'smoothfade_darkgreen.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'smoothfade_darkcyan.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'smoothfade_darkblue.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'smoothfade_darkblack.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >

	<img src="'.$pixopoint_menu_images.'dazzle_yellow.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'dazzle_white.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'dazzle_red.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'dazzle_purple.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'dazzle_pink.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'dazzle_orange.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'dazzle_grey.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'dazzle_green.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'dazzle_cyan.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'dazzle_blue.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	<img src="'.$pixopoint_menu_images.'dazzle_black.png" style="width:45px;height:60px;border-top:5px solid #fff;" class="bgimage" >
	';
	}
?>


<div id="temp_outer">
<div id="temp_inner">
</div>
</div>


<form name="myform" onSubmit="return OnSubmitForm();" method="post">


<div id="editor">
<div id="editor_inner">


<script type="text/javascript">
function OnSubmitForm() {
	if(document.pressed == '<?php if ($variable['confirmloading'] == '') {echo 'Reload';} else {echo 'Continue';} ?>') {document.myform.action ="<?php echo $pixopoint_codingengine; ?>index.php";}
	else {document.myform.action ="";}
	return true;
}
</script>

	<?php if (get_option('pixo_saved') != $variable['saved'] AND $variable['saved'] != '') {update_option('pixo_saved',$variable['saved']);}
	// update_option('pixo_saved','9');
	?>
	<input type="hidden" name="url" value="<?php echo bloginfo('wpurl'); ?>" />
	<input type="hidden" name="saved" value="<?php echo wp_kses( get_option('pixo_saved'), '', '' ); ?>" />
	<input type="hidden" name="passwordconfirmed" value="<?php echo wp_kses( get_option('pixo_password'), '', '' ); ?>" />
	<input type="hidden" name="ip" value="<?php echo esc_attr( $_SERVER['REMOTE_ADDR'] ); ?>" />
	<input type="hidden" name="identification" value="<?php echo wp_kses( get_option('suckerfish_identification'), '', '' ); ?>" /><?php /* Identification code - used by PixoPoint to check that you are who you say you are */ ?>

<?php
	// Only show main Reload button when not confirming new design
	if ($variable['confirmloading'] == '') {echo '
	<input class="pixosubmit" type="submit" name="Operation" onClick="document.pressed=this.value" value="Reload">';
	}
?>
	<div id="editor_menu">
<?php
	// Loads confirmation box before loading new design
	if ($variable['confirmloading'] != '') {echo '
	<div style="width:650px;text-align:center;margin-top:30px;">
		<h2>You are loading the "'.$variable['confirmloading'].'" design</h2>
		<br />
		<input class="confirmationbutton" type="submit" name="Operation" onClick="document.pressed=this.value" value="Continue">
	</div>
	<div style="display:none">
';}
?>
		<div class="tabber" id="mytabber1">

			<div class="tabbertab">
				<h2><?php _e('Editor','pixopoint_theme'); ?><?php if (get_option('suckerfish_secondmenu') == 'on') { ?> #1<?php }?></h2>

				<div class="chunks chunkoverall">
					<!--<p><?php _e('This section allows you to modify the appearance of your main menu.','pixopoint_theme'); ?></p>-->
					<?php /* <div id="menu1_background__colourH">z</div> */ ?>

					<!--<h4><?php _e('Overall','pixopoint_theme'); ?></h4>-->
					<label><?php _e('Height','pixopoint_theme'); ?></label>
					<input id="inputbox_letterspacing" type="text" name="menu1_height" value="<?php echo $variable['menu1_height']; ?>" /><label>px</label>
					<br />
					<label style="line-height:10px;"><?php _e('Bkgrnd image','pixopoint_theme'); ?></label>
					<input type="text" name="menu1_background_image" value="<?php echo $variable['menu1_background_image']; ?>" />
					<input type="button" id="menu1_background_image_button" class="palettebutton" value="pick" />
					<div id="menu1_bgimage_chooser1" title="Background Image Chooser">
					<?php pixopoint_menu_images(); ?>
					</div>
					<br />
					<label><?php _e('Bkgrnd colour','pixopoint_theme'); ?></label>
          <?php hex_code_check('menu1_background_colour'); ?>
					<input id="inputbox_colour1" type="text" name="menu1_background_colour" value="<?php echo $variable['menu1_background_colour']; ?>" />
					<input type="button" id="button_colour1" class="palettebutton" value="pick" />
					<br />
					<h4><?php _e('Width','pixopoint_theme'); ?></h4>
					<label><?php _e('Wrapper','pixopoint_theme'); ?></label>
					<input id="inputbox_letterspacing" style="width:27px" type="text" name="menu1_wrapperwidth" value="<?php echo $variable['menu1_wrapperwidth']; ?>" />
					<select name="menu1_percent_wrapperwidth" style="width:38px;" id="selectbox_fontfamily">
						<?php
							if ($variable['menu1_percent_wrapperwidth'] == 'px') { ?><option value="px">px</option><option value="%">%</option><?php }
							else { ?><option value="%">%</option><option value="px">px</option><?php }
						?>
					</select>
					<label><?php _e('Container','pixopoint_theme'); ?></label>
					<input id="inputbox_letterspacing" style="width:27px" type="text" name="menu1_containerwidth" value="<?php echo $variable['menu1_containerwidth']; ?>" />
					<select name="menu1_percent_containerwidth" style="width:38px;" id="selectbox_fontfamily">
						<?php
							if ($variable['menu1_percent_containerwidth'] == 'px') { ?><option value="px">px</option><option value="%">%</option><?php }
							else { ?><option value="%">%</option><option value="px">px</option><?php }
						?>
					</select>
					<select name="menu1_alignment" style="float:right;margin-right:15px;width:60px;" id="selectbox_fontfamily">
						<?php
							if ($variable['menu1_alignment'] == 'center') { ?><option value="center">center</option><option value="right">right</option><option value="left">left</option><?php }
							elseif ($variable['menu1_alignment'] == 'left') { ?><option value="left">left</option><option value="center">center</option><option value="right">right</option><?php }
							else { ?><option value="right">right</option><option value="left">left</option><option value="center">center</option><?php }
						?>
					</select>
					<div id="colour1" title="bla bla bla">XXXXX</div>
				</div>

				<div class="chunks chunkoverall">
					<h4><?php _e('Buttons','pixopoint_theme'); ?></h4>
					<label><?php _e('Bkgrnd colour','pixopoint_theme'); ?></label>
          <?php hex_code_check('menu1_background_buttoncolour'); ?>
					<input id="inputbox_colour21" type="text" name="menu1_background_buttoncolour" value="<?php echo $variable['menu1_background_buttoncolour']; ?>" />
					<input type="button" id="button_colour21" class="palettebutton" value="pick" />
					<br />
					<label style="line-height:10px;"><?php _e('Bkgrnd image','pixopoint_theme'); ?></label>
					<input type="text" name="menu1_background_buttonimage" value="<?php echo $variable['menu1_background_buttonimage']; ?>" /> <input type="button" id="menu1_background_buttonimage_button" class="palettebutton" value="pick" />
					<div id="menu1_bgimage_chooser2" title="Background Image Chooser">
					<?php pixopoint_menu_images(); ?>
					</div>
					<br />
					<label style="width:63px;display:inline-block;line-height:12px;"><?php _e('Hover bkgrnd colour','pixopoint_theme'); ?></label>
					<?php hex_code_check('menu1_backgroundhovercolour'); ?>
					<input style="position:relative;top:-8px;" id="inputbox_colour2" type="text" name="menu1_backgroundhovercolour" value="<?php echo $variable['menu1_backgroundhovercolour']; ?>" />
					<input style="position:relative;top:-8px;" type="button" id="button_colour2" class="palettebutton" value="pick" />
					<br />
					<label><?php _e('Graphical hover?','pixopoint_theme'); ?></label>
					<input type="hidden" name="menu1_graphicalhover" value="off" />
					<input type="checkbox" name="menu1_graphicalhover" value="on" <?php if ($variable['menu1_graphicalhover'] == 'on') {?>checked="checked"<?php } ?> />
					<br />
					<label><?php _e('Margin','pixopoint_theme'); ?></label>
					<input id="inputbox_inline" type="text" name="menu1_button_betweenpadding" value="<?php echo $variable['menu1_button_betweenpadding']; ?>" />
					<label><?php _e('Padding','pixopoint_theme'); ?></label>
					<input id="inputbox_inline" type="text" name="menu1_button_withinpadding" value="<?php echo $variable['menu1_button_withinpadding']; ?>" />
					<br />
					<div id="colour2"></div>
					<div id="colour21"></div>
				</div>

				<div class="chunks">
					<h4><?php _e('Text','pixopoint_theme'); ?></h4>
					<label><?php _e('Font family','pixopoint_theme'); ?></label>
					<?php fontfamilycode('menu1_fontfamily','id="selectbox_fontfamily"'); ?>
					<br />
					<label><?php _e('Font size','pixopoint_theme'); ?>: </label>
					<input id="inputbox_fontsize" type="text" name="menu1_fontsize" value="<?php echo $variable['menu1_fontsize']; ?>" /><label>px</label>
					<label><?php _e('Bold','pixopoint_theme'); ?></label>
					<input type="hidden" name="menu1_fontweight" value="off" />
					<input type="checkbox" name="menu1_fontweight" value="on" <?php if ($variable['menu1_fontweight'] == 'on') {?>checked="checked"<?php } ?> />
					<label><?php _e('Italics','pixopoint_theme'); ?></label>
					<input type="hidden" name="menu1_fontitalics" value="off" />
				 <input type="checkbox" name="menu1_fontitalics" value="on" <?php if ($variable['menu1_fontitalics'] == 'on') {?>checked="checked"<?php } ?> />
					<br />
					<label><?php _e('Links','pixopoint_theme'); ?></label>
					<select id="selectbox_links" name="menu1_links_underline">
					<?php
						if ($variable['menu1_links_underline'] == 'Underlined') {echo '<option>Underlined</option><option>Underlined on hover</option><option>Never underlined</option>';}
						if ($variable['menu1_links_underline'] == 'Never underlined') {echo '<option>Never underlined</option><option>Underlined</option><option>Underlined on hover</option>';}
						else {echo '<option>Underlined on hover</option><option>Underlined</option><option>Never underlined</option>';}
					?>
					</select>
					<br />
					<label><?php _e('Transformation','pixopoint_theme'); ?></label>
					<?php tab_texttransform('menu1_texttransform','style="width:80px" id="selectbox_transform"'); ?>
					<br />
					<label><?php _e('Letter spacing','pixopoint_theme'); ?></label>
					<input id="inputbox_letterspacing" type="text" name="menu1_letter_spacing" value="<?php echo $variable['menu1_letter_spacing']; ?>" /><label>px</label>
					<br />
					<label><?php _e('Colour','pixopoint_theme'); ?></label>
          <?php hex_code_check('menu1_colour'); ?>
					<input id="inputbox_colour4" type="text" name="menu1_colour" value="<?php echo $variable['menu1_colour']; ?>" />
					<input type="button" id="button_colour4" class="palettebutton" value="pick" />
					<br />
					<label><?php _e('Hover colour','pixopoint_theme'); ?></label>
          <?php hex_code_check('menu1_hovercolour'); ?>
					<input id="inputbox_colour5" type="text" name="menu1_hovercolour" value="<?php echo $variable['menu1_hovercolour']; ?>" /> <input type="button" id="button_colour5" class="palettebutton" value="pick" />
					<div id="colour4"></div>
					<div id="colour5"></div>
				</div>

				<div class="chunks">
					<h4><?php _e('Dropdown Text','pixopoint_theme'); ?></h4>
			  	<label><?php _e('Font family','pixopoint_theme'); ?></label>
			  	<?php fontfamilycode('menu1_dropdown_fontfamily','id="selectbox_fontfamily"'); ?>
					<label><?php _e('Text colour','pixopoint_theme'); ?></label>
          <?php hex_code_check('menu1_dropdown_textcolour'); ?>
					<input id="inputbox_colour6" type="text" name="menu1_dropdown_textcolour" value="<?php echo $variable['menu1_dropdown_textcolour']; ?>" />
					<input type="button" id="button_colour6" class="palettebutton" value="pick" />
					<br />
					<label><?php _e('Hover colour','pixopoint_theme'); ?></label>
          <?php hex_code_check('menu1_dropdown_texthovercolour'); ?>
					<input id="inputbox_colour7" type="text" name="menu1_dropdown_texthovercolour" value="<?php echo $variable['menu1_dropdown_texthovercolour']; ?>" />
					<input type="button" id="button_colour7" class="palettebutton" value="pick" />
					<br /><br />
					<h4><?php _e('Dropdown Background','pixopoint_theme'); ?></h4>
					<label><?php _e('Bkgrnd','pixopoint_theme'); ?></label>
          <?php hex_code_check('menu1_dropdown_backgroundcolour'); ?>
					<input id="inputbox_colour8" type="text" name="menu1_dropdown_backgroundcolour" value="<?php echo $variable['menu1_dropdown_backgroundcolour']; ?>" />
					<input type="button" id="button_colour8" class="palettebutton" value="pick" />
					<br />
					<label>Bkgrnd hover</label>
          <?php hex_code_check('menu1_dropdown_backgroundhovercolour'); ?>
					<input id="inputbox_colour9" type="text" name="menu1_dropdown_backgroundhovercolour" value="<?php echo $variable['menu1_dropdown_backgroundhovercolour']; ?>" /> <input type="button" id="button_colour9" class="palettebutton" value="pick" />
					<div id="colour6"></div>
					<div id="colour7"></div>
					<div id="colour8"></div>
					<div id="colour9"></div>
				</div>

				<div class="chunks premiumone premium">
					<h4>Dropdowns</h4>
					<label>Width</label>
					<input id="inputbox_letterspacing" type="text" name="menu1_dropdown_width" value="<?php echo $variable['menu1_dropdown_width']; ?>" /><label>px</label>
					<br />
					<label>Opacity</label>
					<input style="width:21px" id="inputbox_fontsize" type="text" name="menu1_dropdown_opacity" value="<?php echo $variable['menu1_dropdown_opacity']; ?>" /><label>%</label>
					<br />
					<label>Vert padding</label>
					<input id="inputbox_fontsize" type="text" name="menu1_dropdown_paddingvertical" value="<?php echo $variable['menu1_dropdown_paddingvertical']; ?>" /><label>px</label>
					<br />
					<label>Horiz padding</label>
					<input id="inputbox_fontsize" type="text" name="menu1_dropdown_paddinghorizontal" value="<?php echo $variable['menu1_dropdown_paddinghorizontal']; ?>" /><label>px</label>
					<br />
					<label>Shadow depth</label>
					<input id="inputbox_fontsize" type="text" name="menu1_shadow_width" value="<?php echo $variable['menu1_shadow_width']; ?>" /><label>px</label>
				</div>

				<div class="chunks premiumtwo premium">
					<h4>Dropdown text</h4>
					<label><?php _e('Font size','pixopoint_theme'); ?></label>
					<input id="inputbox_fontsize" type="text" name="menu1_dropdown_fontsize" value="<?php echo $variable['menu1_dropdown_fontsize']; ?>" /><label>px</label>
					<label><?php _e('Bold','pixopoint_theme'); ?></label>
					<input type="hidden" name="menu1_dropdown_bold" value="off" />
					<input type="checkbox" name="menu1_dropdown_bold" value="on" <?php if ($variable['menu1_dropdown_bold'] == 'on') {?>checked="checked"<?php } ?> />
					<label><?php _e('Italics','pixopoint_theme'); ?></label>
					<input type="hidden" name="menu1_dropdown_italics" value="off" />
					<input type="checkbox" name="menu1_dropdown_italics" value="on" <?php if ($variable['menu1_dropdown_italics'] == 'on') {?>checked="checked"<?php } ?> />
					<br />
					<label><?php _e('Transformation','pixopoint_theme'); ?></label>
					<?php tab_texttransform('menu1_dropdown_texttransform','style="width:80px" id="selectbox_transform"'); ?>
					<br />
					<label><?php _e('Letter spacing','pixopoint_theme'); ?></label>
					<input id="inputbox_letterspacing" type="text" name="menu1_dropdown_letter_spacing" value="<?php echo $variable['menu1_dropdown_letter_spacing']; ?>" /><label>px</label>
					<br />
					<label><?php _e('Links','pixopoint_theme'); ?></label>
					<select id="selectbox_links" name="menu1_dropdown_underline">
					<?php
						if ($variable['menu1_dropdown_underline'] == 'Underlined') {echo '<option>Underlined</option><option>Underlined on hover</option><option>Never underlined</option>';}
						elseif ($variable['menu1_dropdown_underline'] == 'Never underlined') {echo '<option>Never underlined</option><option>Underlined</option><option>Underlined on hover</option>';}
						else {echo '<option>Underlined on hover</option><option>Underlined</option><option>Never underlined</option>';}
					?>
					</select>
					<br /><br />
					<h4><?php _e('Dropdown Borders','pixopoint_theme'); ?></h4>
					<label><?php _e('Width','pixopoint_theme'); ?></label>
					<input id="inputbox_fontsize" type="text" name="menu1_dropdown_borderwidth" value="<?php echo $variable['menu1_dropdown_borderwidth']; ?>" /><label>px</label>
					&nbsp;
					<label><?php _e('Colour','pixopoint_theme'); ?></label>
          <?php hex_code_check('menu1_dropdown_bordercolour'); ?>
					<input id="inputbox_colour10" type="text" name="menu1_dropdown_bordercolour" value="<?php echo $variable['menu1_dropdown_bordercolour']; ?>" />
					<input type="button" id="button_colour10" class="palettebutton" value="pick" />
					<div id="colour10"></div>
				</div>

			</div>

<?php
function pixosecondmenu() {global $variable; ?>
				<h2><?php _e('Editor','pixopoint_theme'); ?><?php if (get_option('suckerfish_secondmenu') == 'on') { ?> #2<?php }?></h2>

				<div class="chunks chunkoverall">
					<!--<p><?php _e('This section allows you to modify the appearance of your main menu.','pixopoint_theme'); ?></p>-->
					<?php /* <div id="menu2_background__colourH">z</div> */ ?>

					<!--<h4><?php _e('Overall','pixopoint_theme'); ?></h4>-->
					<label><?php _e('Height','pixopoint_theme'); ?></label>
					<input id="inputbox_letterspacing" type="text" name="menu2_height" value="<?php echo $variable['menu2_height']; ?>" /><label>px</label>
					<br />
					<label style="line-height:10px;"><?php _e('Bkgrnd image','pixopoint_theme'); ?></label>
					<input type="text" name="menu2_background_image" value="<?php echo $variable['menu2_background_image']; ?>" />
					<input type="button" id="menu2_background_image_button" class="palettebutton" value="pick" />
					<div id="menu2_bgimage_chooser1" title="Background Image Chooser">
					<?php pixopoint_menu_images(); ?>
					</div>
					<br />
					<label><?php _e('Bkgrnd colour','pixopoint_theme'); ?></label>
          <?php hex_code_check('menu2_background_colour'); ?>
					<input id="inputbox_colour11" type="text" name="menu2_background_colour" value="<?php echo $variable['menu2_background_colour']; ?>" />
					<input type="button" id="button_colour11" class="palettebutton" value="pick" />
					<br />
					<h4><?php _e('Width','pixopoint_theme'); ?></h4>
					<label><?php _e('Wrapper','pixopoint_theme'); ?></label>
					<input id="inputbox_letterspacing" style="width:27px" type="text" name="menu2_wrapperwidth" value="<?php echo $variable['menu2_wrapperwidth']; ?>" />
					<select name="menu2_percent_wrapperwidth" style="width:38px;" id="selectbox_fontfamily">
						<?php
							if ($variable['menu2_percent_wrapperwidth'] == 'px') { ?><option value="px">px</option><option value="%">%</option><?php }
							else { ?><option value="%">%</option><option value="px">px</option><?php }
						?>
					</select>
					<label><?php _e('Container','pixopoint_theme'); ?></label>
					<input id="inputbox_letterspacing" style="width:27px" type="text" name="menu2_containerwidth" value="<?php echo $variable['menu2_containerwidth']; ?>" />
					<select name="menu2_percent_containerwidth" style="width:38px;" id="selectbox_fontfamily">
						<?php
							if ($variable['menu2_percent_containerwidth'] == 'px') { ?><option value="px">px</option><option value="%">%</option><?php }
							else { ?><option value="%">%</option><option value="px">px</option><?php }
						?>
					</select>
					<select name="menu2_alignment" style="float:right;margin-right:15px;width:60px;" id="selectbox_fontfamily">
						<?php
							if ($variable['menu2_alignment'] == 'center') { ?><option value="center">center</option><option value="right">right</option><option value="left">left</option><?php }
							elseif ($variable['menu2_alignment'] == 'left') { ?><option value="left">left</option><option value="center">center</option><option value="right">right</option><?php }
							else { ?><option value="right">right</option><option value="left">left</option><option value="center">center</option><?php }
						?>
					</select>
					<div id="colour11"></div>
				</div>

				<div class="chunks chunkoverall">
					<h4><?php _e('Buttons','pixopoint_theme'); ?></h4>
					<label><?php _e('Bkgrnd colour','pixopoint_theme'); ?></label>
          <?php hex_code_check('menu2_background_buttoncolour'); ?>
					<input id="inputbox_colour31" type="text" name="menu2_background_buttoncolour" value="<?php echo $variable['menu2_background_buttoncolour']; ?>" />
					<input type="button" id="button_colour31" class="palettebutton" value="pick" />
					<br />
					<label style="line-height:10px;"><?php _e('Bkgrnd image','pixopoint_theme'); ?></label>
					<input type="text" name="menu2_background_buttonimage" value="<?php echo $variable['menu2_background_buttonimage']; ?>" />
					<input type="button" id="menu2_background_buttonimage_button" class="palettebutton" value="pick" />
					<div id="menu2_bgimage_chooser2" title="Background Image Chooser">
					<?php pixopoint_menu_images(); ?>
					</div>
					<br />
					<label style="width:63px;display:inline-block;line-height:12px;"><?php _e('Hover bkgrnd colour','pixopoint_theme'); ?></label>
					<?php hex_code_check('menu2_backgroundhovercolour'); ?>
					<input style="position:relative;top:-8px;" id="inputbox_colour12" type="text" name="menu2_backgroundhovercolour" value="<?php echo $variable['menu2_backgroundhovercolour']; ?>" />
					<input style="position:relative;top:-8px;" type="button" id="button_colour12" class="palettebutton" value="pick" />
					<br />
					<label><?php _e('Graphical hover?','pixopoint_theme'); ?></label>
					<input type="hidden" name="menu2_graphicalhover" value="off" />
					<input type="checkbox" name="menu2_graphicalhover" value="on" <?php if ($variable['menu2_graphicalhover'] == 'on') {?>checked="checked"<?php } ?> />
					<br />
					<label><?php _e('Margin','pixopoint_theme'); ?></label>
					<input id="inputbox_inline" type="text" name="menu2_button_betweenpadding" value="<?php echo $variable['menu2_button_betweenpadding']; ?>" />
					<label><?php _e('Padding','pixopoint_theme'); ?></label>
					<input id="inputbox_inline" type="text" name="menu2_button_withinpadding" value="<?php echo $variable['menu2_button_withinpadding']; ?>" />
					<br />
					<div id="colour12"></div>
					<div id="colour31"></div>
				</div>

				<div class="chunks">
					<h4><?php _e('Text','pixopoint_theme'); ?></h4>
					<label><?php _e('Font family','pixopoint_theme'); ?></label>
					<?php fontfamilycode('menu2_fontfamily','id="selectbox_fontfamily"'); ?>
					<br />
					<label><?php _e('Font size','pixopoint_theme'); ?>: </label>
					<input id="inputbox_fontsize" type="text" name="menu2_fontsize" value="<?php echo $variable['menu2_fontsize']; ?>" /><label>px</label>
					<label><?php _e('Bold','pixopoint_theme'); ?></label>
					<input type="hidden" name="menu2_fontweight" value="off" />
					<input type="checkbox" name="menu2_fontweight" value="on" <?php if ($variable['menu2_fontweight'] == 'on') {?>checked="checked"<?php } ?> />
					<label><?php _e('Italics','pixopoint_theme'); ?></label>
					<input type="hidden" name="menu2_fontitalics" value="off" />
				 <input type="checkbox" name="menu2_fontitalics" value="on" <?php if ($variable['menu2_fontitalics'] == 'on') {?>checked="checked"<?php } ?> />
					<br />
					<label><?php _e('Links','pixopoint_theme'); ?></label>
					<select id="selectbox_links" name="menu2_links_underline">
					<?php
						if ($variable['menu2_links_underline'] == 'Underlined') {echo '<option>Underlined</option><option>Underlined on hover</option><option>Never underlined</option>';}
						if ($variable['menu2_links_underline'] == 'Never underlined') {echo '<option>Never underlined</option><option>Underlined</option><option>Underlined on hover</option>';}
						else {echo '<option>Underlined on hover</option><option>Underlined</option><option>Never underlined</option>';}
					?>
					</select>
					<br />
					<label><?php _e('Transformation','pixopoint_theme'); ?></label>
					<?php tab_texttransform('menu2_texttransform','style="width:80px" id="selectbox_transform"'); ?>
					<br />
					<label><?php _e('Letter spacing','pixopoint_theme'); ?></label>
					<input id="inputbox_letterspacing" type="text" name="menu2_letter_spacing" value="<?php echo $variable['menu2_letter_spacing']; ?>" /><label>px</label>
					<br />
					<label><?php _e('Colour','pixopoint_theme'); ?></label>
          <?php hex_code_check('menu2_colour'); ?>
					<input id="inputbox_colour14" type="text" name="menu2_colour" value="<?php echo $variable['menu2_colour']; ?>" />
					<input type="button" id="button_colour14" class="palettebutton" value="pick" />
					<br />
					<label><?php _e('Hover colour','pixopoint_theme'); ?></label>
          <?php hex_code_check('menu2_hovercolour'); ?>
					<input id="inputbox_colour15" type="text" name="menu2_hovercolour" value="<?php echo $variable['menu2_hovercolour']; ?>" />
					<input type="button" id="button_colour15" class="palettebutton" value="pick" />
					<div id="colour14"></div>
					<div id="colour15"></div>
				</div>

				<div class="chunks">
					<h4><?php _e('Dropdown Text','pixopoint_theme'); ?></h4>
			  	<label><?php _e('Font family','pixopoint_theme'); ?></label>
			  	<?php fontfamilycode('menu2_dropdown_fontfamily','id="selectbox_fontfamily"'); ?>
					<label><?php _e('Text colour','pixopoint_theme'); ?></label>
          <?php hex_code_check('menu2_dropdown_textcolour'); ?>
					<input id="inputbox_colour16" type="text" name="menu2_dropdown_textcolour" value="<?php echo $variable['menu2_dropdown_textcolour']; ?>" />
					<input type="button" id="button_colour16" class="palettebutton" value="pick" />
					<br />
					<label><?php _e('Hover colour','pixopoint_theme'); ?></label>
          <?php hex_code_check('menu2_dropdown_texthovercolour'); ?>
					<input id="inputbox_colour17" type="text" name="menu2_dropdown_texthovercolour" value="<?php echo $variable['menu2_dropdown_texthovercolour']; ?>" />
					<input type="button" id="button_colour17" class="palettebutton" value="pick" />
					<br /><br />
					<h4><?php _e('Dropdown Background','pixopoint_theme'); ?></h4>
					<label><?php _e('Bkgrnd','pixopoint_theme'); ?></label>
          <?php hex_code_check('menu2_dropdown_backgroundcolour'); ?>
					<input id="inputbox_colour18" type="text" name="menu2_dropdown_backgroundcolour" value="<?php echo $variable['menu2_dropdown_backgroundcolour']; ?>" />
					<input type="button" id="button_colour18" class="palettebutton" value="pick" />
					<br />
					<label>Bkgrnd hover</label>
          <?php hex_code_check('menu2_dropdown_backgroundhovercolour'); ?>
					<input id="inputbox_colour19" type="text" name="menu2_dropdown_backgroundhovercolour" value="<?php echo $variable['menu2_dropdown_backgroundhovercolour']; ?>" /> <input type="button" id="button_colour19" class="palettebutton" value="pick" />
					<div id="colour16"></div>
					<div id="colour17"></div>
					<div id="colour18"></div>
					<div id="colour19"></div>
				</div>

				<div class="chunks premiumone premium">
					<h4>Dropdowns</h4>
					<label>Width</label>
					<input id="inputbox_letterspacing" type="text" name="menu2_dropdown_width" value="<?php echo $variable['menu2_dropdown_width']; ?>" /><label>px</label>
					<br />
					<label>Opacity</label>
					<input style="width:21px" id="inputbox_fontsize" type="text" name="menu2_dropdown_opacity" value="<?php echo $variable['menu2_dropdown_opacity']; ?>" /><label>%</label>
					<br />
					<label>Vert padding</label>
					<input id="inputbox_fontsize" type="text" name="menu2_dropdown_paddingvertical" value="<?php echo $variable['menu2_dropdown_paddingvertical']; ?>" /><label>px</label>
					<br />
					<label>Horiz padding</label>
					<input id="inputbox_fontsize" type="text" name="menu2_dropdown_paddinghorizontal" value="<?php echo $variable['menu2_dropdown_paddinghorizontal']; ?>" /><label>px</label>
					<br />
					<label>Shadow depth</label>
					<input id="inputbox_fontsize" type="text" name="menu2_shadow_width" value="<?php echo $variable['menu2_shadow_width']; ?>" /><label>px</label>
				</div>

				<div class="chunks premiumtwo premium">
					<h4>Dropdown text</h4>
					<label><?php _e('Font size','pixopoint_theme'); ?></label>
					<input id="inputbox_fontsize" type="text" name="menu2_dropdown_fontsize" value="<?php echo $variable['menu2_dropdown_fontsize']; ?>" /><label>px</label>
					<label><?php _e('Bold','pixopoint_theme'); ?></label>
					<input type="hidden" name="menu2_dropdown_bold" value="off" />
					<input type="checkbox" name="menu2_dropdown_bold" value="on" <?php if ($variable['menu2_dropdown_bold'] == 'on') {?>checked="checked"<?php } ?> />
					<label><?php _e('Italics','pixopoint_theme'); ?></label>
					<input type="hidden" name="menu2_dropdown_italics" value="off" />
					<input type="checkbox" name="menu2_dropdown_italics" value="on" <?php if ($variable['menu2_dropdown_italics'] == 'on') {?>checked="checked"<?php } ?> />
					<br />
					<label><?php _e('Transformation','pixopoint_theme'); ?></label>
					<?php tab_texttransform('menu2_dropdown_texttransform','style="width:80px" id="selectbox_transform"'); ?>
					<br />
					<label><?php _e('Letter spacing','pixopoint_theme'); ?></label>
					<input id="inputbox_letterspacing" type="text" name="menu2_dropdown_letter_spacing" value="<?php echo $variable['menu2_dropdown_letter_spacing']; ?>" /><label>px</label>
					<br />
					<label><?php _e('Links','pixopoint_theme'); ?></label>
					<select id="selectbox_links" name="menu2_dropdown_underline">
					<?php
						if ($variable['menu2_dropdown_underline'] == 'Underlined') {echo '<option>Underlined</option><option>Underlined on hover</option><option>Never underlined</option>';}
						elseif ($variable['menu2_dropdown_underline'] == 'Never underlined') {echo '<option>Never underlined</option><option>Underlined</option><option>Underlined on hover</option>';}
						else {echo '<option>Underlined on hover</option><option>Underlined</option><option>Never underlined</option>';}
					?>
					</select>
					<br /><br />
					<h4><?php _e('Dropdown Borders','pixopoint_theme'); ?></h4>
					<label><?php _e('Width','pixopoint_theme'); ?></label>
					<input id="inputbox_fontsize" type="text" name="menu2_dropdown_borderwidth" value="<?php echo $variable['menu2_dropdown_borderwidth']; ?>" /><label>px</label>
					&nbsp;
					<label><?php _e('Colour','pixopoint_theme'); ?></label>
          <?php hex_code_check('menu2_dropdown_bordercolour'); ?>
					<input id="inputbox_colour20" type="text" name="menu2_dropdown_bordercolour" value="<?php echo $variable['menu2_dropdown_bordercolour']; ?>" />
					<input type="button" id="button_colour20" class="palettebutton" value="pick" />
					<div id="colour20"></div>
				</div>
<?php } ?>

			<?php
				if (get_option('suckerfish_secondmenu') == 'on') {echo '<div class="tabbertab">';pixosecondmenu();echo '</div>';}
				else {echo '<div style="display:none">';pixosecondmenu();echo '</div>';}
			?>

			<div class="tabbertab">
				<h2><?php _e('Save/Open','pixopoint_theme'); ?></h2>
				<div class="chunks" style="width:80px">
					<h4><?php _e('Save/Open','pixopoint_theme'); ?></h4>
					<br />
					<input class="bigcurvedbutton" name="save" value="Save" type="submit" />
					<br />
					<input class="bigcurvedbutton" name="open" value="Open" type="submit" />
				</div>
				<div class="chunks" style="width:200px">
					<table>
						<tr>
							<td style="padding-bottom:10px;">
								<h4><?php _e('Designs','pixopoint_theme'); ?></h4>
							</td>
							<td><strong>Menu #1</strong></td>
							<?php if (get_option('suckerfish_secondmenu') == 'on') {echo '<td><strong>Menu #2</strong></td>';} ?>
						</tr>
						<tr>
							<td><label>Red Dazzle</label></td>
							<td><input class="curvedbutton" name="reddazzle" value="Load" type="submit" /></td>
							<?php if (get_option('suckerfish_secondmenu') == 'on') {echo '<td><input class="curvedbutton" name="reddazzle2" value="Load" type="submit" /></td>';} ?>
						</tr>
						<tr>
							<td><label>Corporate black</label></td>
							<td><input class="curvedbutton" name="corporateblack" value="Load" type="submit" /></td>
							<?php if (get_option('suckerfish_secondmenu') == 'on') {echo '<td><input class="curvedbutton" name="corporateblack2" value="Load" type="submit" /></td>';} ?>
						</tr>
						<tr>
							<td><label>Nature</label></td>
							<td><input class="curvedbutton" name="nature" value="Load" type="submit" /></td>
							<?php if (get_option('suckerfish_secondmenu') == 'on') {echo '<td><input class="curvedbutton" name="nature2" value="Load" type="submit" /></td>';} ?>
						</tr>
						<tr>
							<td><label>Blue berry</label></td>
							<td><input class="curvedbutton" name="blueberry" value="Load" type="submit" /></td>
							<?php if (get_option('suckerfish_secondmenu') == 'on') {echo '<td><input class="curvedbutton" name="blueberry2" value="Load" type="submit" /></td>';} ?>
						</tr>
						<tr>
							<td><label>Bland grey</label></td>
							<td><input class="curvedbutton" name="blandgrey" value="Load" type="submit" /></td>
							<?php if (get_option('suckerfish_secondmenu') == 'on') {echo '<td><input class="curvedbutton" name="blandgrey2" value="Load" type="submit" /></td>';} ?>
						</tr>
						<tr>
							<td><label>Bland red</label></td>
							<td><input class="curvedbutton" name="blandred" value="Load" type="submit" /></td>
							<?php if (get_option('suckerfish_secondmenu') == 'on') {echo '<td><input class="curvedbutton" name="blandred2" value="Load" type="submit" /></td>';} ?>
						</tr>
					</table>
				</div>

				<div class="chunks" style="width:150px">
					<h4><?php _e('Login for premium features','pixopoint_theme'); ?></h4>
					<p><?php _e('To use the premium features of this plugin you need to register for the <a href="http://pixopoint.com/premium_support/">PixoPoint Premium Features option</a>','pixopoint_theme'); ?></p>
					<p style="margin:0"><?php _e('Username (case sensitive)','pixopoint_theme'); ?>: <input name="username" type="text" value="<?php echo $variable['username']; ?>" /></p>
					<p style="margin:0"><?php _e('Password','pixopoint_theme'); ?>: <input name="password" type="text" value="" /></p>
				</div>

			</div>

		</div>
	</div>

<?php
	// Loads confirmation box before loading new design
	if ($variable['confirmloading'] != '') {echo '</div>';}



/*
?>
			<div class="editorclose">
				<input class="closebutton" name="disableeditingpane" value="Disable Editor" type="submit" />
				<a class="premiumbutton basicoff" href="#" onclick="setActiveStyleSheet(''); return false;"><?php _e('Basic','pixopoint_theme'); ?></a>
				<a class="premiumbutton premiumoff" href="#" onclick="setActiveStyleSheet('premium'); return false;"><?php _e('Premium','pixopoint_theme'); ?></a>
			</div>

<?php
*/




/*
	// Loads confirmation box before loading new design
	if ($variable['confirmloading'] != '') {echo '
<div id="temp_outer">
<div id="temp_inner">
	<div class="confirmationbox">
	<h2>You have tried to load the "'.$variable['confirmloading'].'" design</h2>
	<input class="pixosubmit" type="submit" name="Operation" onClick="document.pressed=this.value" value="Reload">
	</div>
</div>
</div>
';} */
?>

</div>
</div>

<?php wp_nonce_field('pxp_form'); ?>

</form>

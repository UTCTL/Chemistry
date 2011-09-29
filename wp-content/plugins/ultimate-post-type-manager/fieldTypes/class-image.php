<?php 

class image extends fieldType{

	public function __construct($name,$label='',$desc='',$val='',$help='')
	{
		parent::__construct($name,$label,$desc,$val,$help);
		$this->ver = 1.0;
		$this->basic = true;
		$this->ftype = 'image';
		$this->flabel = 'Image';
	}
	public function input($post_id)
	{
		$img = get_post_meta($post_id, $this->name, TRUE);
		
		if(!is_array($img))
			{$img['img_alt']='';$img['img_url']='';}
		else
			{$img = $img[$this->ftype];}
		if(''==$img['img_url'])
			$img_src = '../wp-includes/images/blank.gif';
		else
			{
				if (preg_match('/\A(?:\b(?:(?:https?|ftp|file):\/\/|www\.|ftp\.)[-A-Z0-9+&@#\/%=~_|$?!:,.]*[A-Z0-9+&@#\/%=~_|$])\Z/i', $img['img_url'])) 
				{
				$img_src = wp_specialchars_decode($img['img_url']);
				}
				else{
				preg_match_all('/src="(.*?)"/', $img['img_url'], $result, PREG_PATTERN_ORDER);
				$result = $result[0][0];
				$img_src = substr($result,5,-1);
				
				}
			$img['img_url']= wp_specialchars_decode($img['img_url']);
			}
		$e.="<fieldset style='width:80%;float:left;'>";
		$e.="<label for='".$this->name."-URL' style='display:inline'>".$this->label." HTML</label>";
		$e.='<a href="media-upload.php?type=image&amp;TB_iframe=true&width=640&height=513" style="padding:4px;font-weight:normal;text-decoration:none;margin-left:20px" class="thickbox" id="xydac_cpt_add_image_'.$this->name.'" name="xydac_custom['.$this->ftype.'-'.$this->name.'][img_url]"  title="Add an Image"><img src="images/media-button-image.gif" alt="Add an Image" style="padding-right:10px;">Add Image</a>';
		$e.='<a href="#" style="padding:4px;font-weight:normal;text-decoration:none;margin-left:20px" id="xydac_cpt_remove_image_'.$this->name.'" name="xydac_custom['.$this->ftype.'-'.$this->name.'][img_url]" title="Remove Image">Remove Image</a>';
		$e.="<p><input type='text' id='".$this->name."-URL' name='xydac_custom[".$this->ftype."-".$this->name."][img_url]' value='".$img['img_url']."' /></p>";
		$e.="<p><span>".$this->desc."</span></p></fieldset>";
		$e.="<img src='".$img_src."' id='xydac_custom[".$this->ftype."-".$this->name."][img_url]' width='75px' height='75px' style='padding:4px;float:right'/>";
		return $e;
	}
	
	public function saving(&$temp,$post_id,$val,$oval=null)
	{
		//$val not cleaned
		if(is_array($val))
			if(isset($val['img_url']))
				if(''!=$val['img_url'])
					{
						$val['img_url']=_wp_specialchars($val['img_url']);
						$val = array( $this->ftype=>$val);
						array_push($temp,update_post_meta($post_id, $this->name, $val));
					}
	}
	public function output($val,$atts)
	{
	$s='';
	if(is_array($val))
		if(isset($val['img_url']))
			{
				$val['img_url'] = wp_specialchars_decode($val['img_url']);
				if (preg_match('/\A(?:\b(?:(?:https?|ftp|file):\/\/|www\.|ftp\.)[-A-Z0-9+&@#\/%=~_|$?!:,.]*[A-Z0-9+&@#\/%=~_|$])\Z/i', $val['img_url'])) 
					$s.='<img src="'.$val['img_url'].'" >';
				else
					$s.=do_shortcode($val['img_url']);
			}
		return $s;
	}
	public function adminscript()
	{
	$r = <<<XYDACSCRIPT
	jQuery(document).ready(function() {
	var xydac_field='';
	(function($) {
	xydac_tb_position = function() {
		var tbWindow = $('#TB_window'), width = $(window).width(), H = $(window).height(), W = ( 720 < width ) ? 720 : width, adminbar_height = 0;

		if ( $('body.admin-bar').length )
			adminbar_height = 28;

		if ( tbWindow.size() ) {
			tbWindow.width( W - 50 ).height( H - 45 - adminbar_height );
			$('#TB_iframeContent').width( W - 50 ).height( H - 75 - adminbar_height );
			tbWindow.css({'margin-left': '-' + parseInt((( W - 50 ) / 2),10) + 'px'});
			if ( typeof document.body.style.maxWidth != 'undefined' )
				tbWindow.css({'top': 20 + adminbar_height + 'px','margin-top':'0'});
		};

		return $("a[id^='xydac_cpt_add_image']").each( function() {
			var href = $(this).attr('href');
			if ( ! href ) return;
			href = href.replace(/&width=[0-9]+/g, '');
			href = href.replace(/&height=[0-9]+/g, '');
			$(this).attr( 'href', href + '&width=' + ( W - 80 ) + '&height=' + ( H - 85 - adminbar_height ) );
		});
	};

	$(window).resize(function(){ xydac_tb_position(); });
	})(jQuery);
    jQuery("a[id^='xydac_cpt_add_image']").click(function() {
	 xydac_field = jQuery(this).attr('name');
     tb_show('Add an Image', jQuery(this).attr('href'));
     return false;
    });
	
	//Click on Remove Image
    jQuery("a[id^='xydac_cpt_remove_image']").click(function() {
	 xydac_field = jQuery(this).attr('name');
     jQuery("img[id='" +xydac_field+ "']").attr('src','../wp-includes/images/blank.gif');
	 jQuery("input[type='text'][name='"+xydac_field+"']").attr('value',' ');
     return false;
    });
	jQuery("input[name^=xydac_custom]").blur(function() {
		imgurl = jQuery(this).attr('value');
		xydac_field = jQuery(this).attr('name');
		if (/^(?:\b(?:(?:https?|ftp|file):\/\/|www\.|ftp\.)[\-A-Z0-9+&@#\/%=~_|$?!:,.]*[A-Z0-9+&@#\/%=~_|$])$/i.test(imgurl)) {
			jQuery("img[id='" +xydac_field+ "']").attr('src',imgurl);
			
		} 

	});
	
	window.original_send_to_editor = window.send_to_editor;
    window.send_to_editor = function(html) {
		if(xydac_field!='')
		{
			var imgurl = jQuery('img',html).attr('src');
			jQuery("img[id='" +xydac_field+ "']").attr('src',imgurl);
			jQuery("input[type='text'][name='"+xydac_field+"']").attr('value',html);
			tb_remove();
			
		}
		else
			window.original_send_to_editor(html);
		}
	});
XYDACSCRIPT;
return $r;
	}

}

?>
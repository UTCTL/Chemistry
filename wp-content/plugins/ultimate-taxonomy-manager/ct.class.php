<?php
if ( !class_exists( 'ct_fields' ) ) :
class ct_fields
{
	var $ct_type;
	var $ct_field_name;
	var $ct_field_label;
	var $ct_field_type ;
	var $ct_field_desc ;
	var $ct_field_val ;
	function ct_fields($taxonomy,$name,$label,$type,$desc,$val)
	{
        
		$this->ct_type = $taxonomy;
		$this->ct_field_name = $name;
		$this->ct_field_label = $label;
		$this->ct_field_type = $type;
		$this->ct_field_desc = $desc;
		$this->ct_field_val = $val;
		add_action ( $this->ct_type.'_add_form_fields', array($this, 'field_input_metabox'));
		add_action ( $this->ct_type.'_edit_form_fields', array($this, 'field_input_metabox'));
		add_action ( 'edited_'.$this->ct_type, array($this, 'save_field_data' ));
		add_action ( 'created_'.$this->ct_type, array($this, 'save_field_data' ));
        add_filter( 'manage_edit-'.$this->ct_type.'_columns', array($this,'taxonomy_columns'));
		add_filter( 'manage_'.$this->ct_type.'_custom_column', array($this,'taxonomy_columns_manage'),10,3);
        add_shortcode('xy_'.$this->ct_type, array($this,'xydac_shortcode'));
	}
	
    function taxonomy_columns($columns) {
        $columns[$this->ct_field_name] = __( $this->ct_field_label, 'xydac' );
        return $columns;
    }
    function taxonomy_columns_manage( $out ,$column_name, $term) {
		global $wp_version;
        //if ($column_name !=$this->ct_field_name)
         //   return;
        $val =  get_metadata('taxonomy', $term, $this->ct_field_name, TRUE);
        //if ( !$val )
		//    $val = '<em>' . __( 'undefined', 'xydac' ) . '</em>';
	    //echo $val;
		if ($column_name==$this->ct_field_name)
		{
			if($this->ct_field_type!='image')
			{
				if ( !$val )
					$out .= '<em>' . __( 'undefined', 'xydac' ) . '</em>';
				else
					$out .= $val;
			}
			else
			{
				if ( !$val )
					$out .= '<em>' . __( 'undefined', 'xydac' ) . '</em>';
				else
					$out .= "<img src='".$val."' alt=$this->ct_field_name width='75px' />";
			}
 		}
		
	if(((float)$wp_version)<3.1)
		return $out;
	else
		echo $out;		
    }
    public function find_label($name)
    {
        global $wpdb;
        $table = $wpdb->prefix.'taxonomyfield';
        $t = $wpdb->get_row("SELECT field_label FROM $table WHERE field_name='$name' limit 1");
		if(is_object($t)) return $t->field_label; else return $t;
    }
    public function find_type($name)
    {
        global $wpdb;
        $table = $wpdb->prefix.'taxonomyfield';
        $t = $wpdb->get_row("SELECT field_type FROM $table WHERE field_name='$name' limit 1");
		if(is_object($t)) return $t->field_type; else return $t;
    }
    function xydac_shortcode($atts)
    {//very bad implementation
        global $post;
	    extract(shortcode_atts(array(
		'field' => '',
		'decode' => '',
	     ), $atts));
        $a = wp_get_object_terms($post->ID, $this->ct_type);
        
        if(empty($field))
			$d=array();
		//$d = array();//final data
        if(!is_wp_error($a))
		{
		foreach($a as $v)
		{
		if(empty($field)){
		if($v->taxonomy=='category' || $v->taxonomy=='post_tag')
			{$c["name"] = "<a href='".get_term_link($v)."'>".$v->name."</a>";}
		else
			$c["name"] = $v->name;
		$c["desc"] = $v->description;
		$c["field"] = array();
		foreach(get_metadata("taxonomy", $v->term_id, $field , TRUE) as $o=>$p)
			foreach($p as $r => $s)
				array_push($c["field"],array($o=>$s));
		array_push($d,$c);}
		else {
			if(1==$decode)
				$d= htmlspecialchars_decode(get_metadata("taxonomy", $v->term_id, $field , TRUE)); 
			else
				$d= get_metadata("taxonomy", $v->term_id, $field , TRUE); 
			}
		}
        if(empty($field))
        {   $e = '';
			if(is_array($d))
            foreach ($d as $k=>$v)
            {
				$f = "";
				$g = "";
				//return var_dump($v);
				if(is_array($v["field"]))
                foreach($v["field"] as $l=>$j)
                {
				
				foreach($j as $f_name=>$f_val)
					{
					$fl = $this->find_label($f_name);
					if(!empty($fl))
						{
							if($this->find_type($f_name)=='image')
							{	
								if(!empty($f_val))$f .="<div class='xydac-left' style='overflow:hidden;clear:left;float:left;margin:0px;width:28%;padding:2px;'><strong>".$fl."</strong> : <img src='".$f_val."' alt='".$fl."' /></div>"; 
								
							}
							else
								if(!empty($f_val))$g .= "<strong>".$fl."</strong> : ".$f_val."<br/>";
						}
					}
                }
				if($f!="")
				{$e .="<div class='xydac-container' style='margin:0px;overflow:hidden;padding:0px;'> 
		<div class='xydac-right' style='clear:right;float:right;margin:0px;width:70%;'>";}
				else
				{$e .="<div class='xydac-container' style='margin:0px;overflow:hidden;padding:0px;'> 
		<div class='xydac-right' style='clear:right;float:right;margin:0px;width:100%;'>";}
				$e .="<br/><strong>Name : </strong>".$v["name"]."<br/>";
				if(!empty($v["desc"]))
					$e .="<strong>Description : </strong>".$v["desc"]."<br/>";
				
				$e .=$g;$e .="</div>";
				$e .=$f;
				
			$e.="</div>";
			
            }
            $d = $e;
        }
		if(substr($d,-2)==', ')
			return substr($d,0,-2);
		else
			return $d;
        }
    }
	public function field_input_metabox($tag) {
    if(is_object($tag))
	$xy_meta = get_metadata('taxonomy', $tag->term_id, $this->ct_field_name, TRUE);
    else
        $xy_meta = '';
    if(!isset($_GET['action'])){?>
    <div class="form-field">
        <label for="<?php _e($this->ct_field_name) ?>"><?php _e($this->ct_field_label) ?></label><?php if($this->ct_field_type == 'image') { ?>
            <a href="" style="padding:4px;font-weight:normal;text-decoration:none;margin-left:20px" id="xydac_add_image_<?php _e($this->ct_field_name) ?>" name="<?php _e($this->ct_field_name) ?>"  title="Add an Image">
            <img src="images/media-button-image.gif" alt="Add an Image" style="padding-right:10px;">Add Image</a><a href="#" style="padding:4px;font-weight:normal;text-decoration:none;margin-left:20px" id="xydac_remove_image_<?php _e($this->ct_field_name) ?>" name="<?php _e($this->ct_field_name) ?>" title="Remove Image">Remove Image</a><br/><?php } ?>
        <?php if($this->ct_field_type == 'text'){ ?>
            <input type="text" name="<?php _e($this->ct_field_name) ?>" id="<?php _e($this->ct_field_name) ?>" value="<?php echo $xy_meta; ?>" size="40"/>
        <?php } elseif($this->ct_field_type == 'combobox') { $p_values = explode(',',$this->ct_field_val); ?>
            <select name="<?php _e($this->ct_field_name) ?>" id="<?php _e($this->ct_field_name) ?>">
                <?php foreach($p_values as $p_value) { $p_value = trim($p_value); ?>
                    <option value="<?php _e($p_value) ?>" <?php if($xy_meta==$p_value) _e('Selected'); ?>><?php _e($p_value) ?></option>
                <?php } ?>
            </select>
        <?php } elseif($this->ct_field_type == 'image') { ?>
            <img class="xydac_cat" src='<?php !empty($xy_meta) ? _e($xy_meta): _e(get_bloginfo('wpurl').'/wp-includes/images/blank.gif') ; ?>' id='<?php _e($this->ct_field_name) ?>'/>
            <!--<input type="hidden" name="<?php _e($this->ct_field_name) ?>" value="<?php !empty($xy_meta) ? _e($xy_meta): _e('') ; ?>" />-->
			<input type="text" name="<?php _e($this->ct_field_name) ?>" id="<?php _e($this->ct_field_name) ?>" value="<?php !empty($xy_meta) ? _e($xy_meta): _e('') ; ?>" size="40"/>
            <?php }  elseif($this->ct_field_type == 'textarea'){  ?>
			<textarea name="<?php _e($this->ct_field_name) ?>" id="<?php _e($this->ct_field_name) ?>" cols=60 rows=6 ><?php echo $xy_meta; ?></textarea>
			<?php } ?>
        <p class="description"><?php _e($this->ct_field_desc) ?></p>
    </div>
    <?php }else { ?>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="<?php _e($this->ct_field_name) ?>"><?php _e($this->ct_field_label) ?></label>
		</th>
		<td>
            <?php if($this->ct_field_type == 'text'){  ?>
			    <input type="text" name="<?php _e($this->ct_field_name) ?>" id="<?php _e($this->ct_field_name) ?>" value="<?php echo $xy_meta; ?>" size="40"/><br />
            <?php } elseif($this->ct_field_type == 'combobox') { $p_values = explode(',',$this->ct_field_val); ?>
                <select name="<?php _e($this->ct_field_name) ?>" id="<?php _e($this->ct_field_name) ?>">
                     <?php foreach($p_values as $p_value) { $p_value = trim($p_value);  ?>
                        <option value="<?php _e($p_value)  ?>" <?php if($xy_meta==$p_value) _e('Selected'); ?>><?php _e($p_value) ?></option>
                    <?php } ?>
                </select>
            <?php } elseif($this->ct_field_type == 'image') { ?>
                    <a href="" style="padding:4px;font-weight:normal;text-decoration:none;margin-left:20px" id="xydac_add_image_<?php _e($this->ct_field_name) ?>" name="<?php _e($this->ct_field_name) ?>"  title="Add an Image">
            <img src="images/media-button-image.gif" alt="Add an Image" style="padding-right:10px;">Add Image</a><a href="#" style="padding:4px;font-weight:normal;text-decoration:none;margin-left:20px" id="xydac_remove_image_<?php _e($this->ct_field_name) ?>" name="<?php _e($this->ct_field_name) ?>" title="Remove Image">Remove Image</a><br/>
                   <img class="xydac_cat" src='<?php !empty($xy_meta) ? _e($xy_meta): _e(get_bloginfo('wpurl').'/wp-includes/images/blank.gif') ; ?>' id='<?php _e($this->ct_field_name) ?>'/>
                    <!--<input type="hidden" name="<?php _e($this->ct_field_name) ?>" value="<?php !empty($xy_meta) ? _e($xy_meta): _e('') ; ?>" /> -->
					<input type="text" name="<?php _e($this->ct_field_name) ?>" id="<?php _e($this->ct_field_name) ?>" value="<?php !empty($xy_meta) ? _e($xy_meta): _e('') ; ?>" size="40"/>
			<?php } elseif($this->ct_field_type == 'textarea'){  ?>
			    <textarea name="<?php _e($this->ct_field_name) ?>" id="<?php _e($this->ct_field_name) ?>" cols=60 rows=6 ><?php echo $xy_meta; ?></textarea><br />
            <?php } ?>
			<p class="description"><?php _e($this->ct_field_desc) ?></p>
		</td>
	</tr>
		<?php }
	}
	public function save_field_data($term_id) {
        if (isset($_POST[$this->ct_field_name]) ) {
	        $ct_value = esc_attr($_POST[$this->ct_field_name]);
	        update_metadata('taxonomy', $term_id, $this->ct_field_name, $ct_value);
        }
	}
}
endif;
?>
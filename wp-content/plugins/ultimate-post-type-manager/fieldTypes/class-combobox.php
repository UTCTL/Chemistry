<?php 

class combobox extends fieldType{

	public function __construct($name,$label='',$desc='',$val='',$help='')
	{
		parent::__construct($name,$label,$desc,$val,$help);
		$this->ver = 1.0;
		$this->basic = true;
		$this->ftype = 'combobox';
		$this->flabel = 'Combo Box';
		$this->value = $val;
		
	}
	public function input($post_id)
	{
		$atemp = explode(',',$this->value);
		$e.="<label for='".$this->name."'>".$this->label."</label>";
		$e.="<p><select id='".$this->name."' name='xydac_custom[".$this->ftype."-".$this->name."]'>";
		$val = get_post_meta($post_id, $this->name, TRUE);
		foreach($atemp as $k=>$v)
			{
				if($val[$this->ftype]==$v) 
					$e.="<option value='".$v."' name='".$v."' selected>".$v."</option>";  
				else 
					$e.="<option value='".$v."' name='".$v."'>".$v."</option>";
			}
		$e.="</select></p>";
		if(!empty($this->desc))
		$e.="<p><span>".$this->desc."</span></p>";
		return $e;
	}
	
	public function saving(&$temp,$post_id,$val,$oval=null)
	{
		$val = esc_attr($val);
		$val = array( $this->ftype=>$val);
		array_push($temp,update_post_meta($post_id, $this->name, $val));
	}
	public function output($val,$atts)
	{
		return $val;
	}

}

?>
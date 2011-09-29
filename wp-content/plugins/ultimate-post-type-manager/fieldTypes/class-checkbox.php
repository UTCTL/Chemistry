<?php 

class checkbox extends fieldType{

	public function __construct($name,$label='',$desc='',$val='',$help='')
	{
		parent::__construct($name,$label,$desc,$val,$help);
		$this->ver = 1.0;
		$this->basic = true;
		$this->ftype = 'checkbox';
		$this->flabel = 'Check Box';
		$this->value = $val;
		
	}
	public function input($post_id)
	{
		$atemp = explode(',',$this->value);
		$e.="<label for='".$this->name."'>".$this->label."</label>";
		$e.="<p>";
		$val = get_post_meta($post_id, $this->name, TRUE);
		$val = $val[$this->ftype];
		if(!is_array($val)) $val=array();
		foreach($atemp as $k=>$v)
			{if(in_array($v,$val))
				{$e.="<input id='".$v."' type='checkbox' name='xydac_custom[".$this->ftype."-".$this->name."][".$v."]' value='".$v."' checked='checked'/><label class='radio'  for='".$v."'>".$v."</label><br/>"; }
			else 
				{$e .="<input id='".$v."' type='checkbox' name='xydac_custom[".$this->ftype."-".$this->name."][".$v."]' value='".$v."'/><label class='radio'  for='".$v."'>".$v."</label><br/>";}
			}
		$e.="<input type='hidden' name=xydac_custom[".$this->ftype."-".$this->name."][xydac-null] value='xydac-null'/>";
		$e.="</p>";
		if(!empty($this->desc))
		$e.="<p><span>".$this->desc."</span></p>";
		return $e;
	}
	
	public function saving(&$temp,$post_id,$val,$oval=null)
	{
		$val = array( $this->ftype => $val);
		array_push($temp,update_post_meta($post_id, $this->name, $val));
	}
	public function output($val,$atts)
	{
		unset($val["xydac-null"]);
		$s ="";
		foreach($val as $k=>$v)
			$s.=$v.", ";
		return substr($s,0,-2);
	}

}

?>
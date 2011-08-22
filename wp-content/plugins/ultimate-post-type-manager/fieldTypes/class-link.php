<?php 

class link extends fieldType{

	public function __construct($name,$label='',$desc='',$val='',$help='')
	{
		parent::__construct($name,$label,$desc,$val,$help);
		$this->ver = 1.0;
		$this->basic = true;
		$this->ftype = 'link';
		$this->flabel = 'Link';
		$this->value = $val;
		
	}
	public function input($post_id)
	{
		$val = get_post_meta($post_id, $this->name, TRUE);
		if(!is_array($val[$this->ftype]))
			{$val[$this->ftype]['link_label']='';$val[$this->ftype]['link_url']='';}
		$e.="<label for='".$this->name."-label'>".$this->label." Label</label>";
		$e.="<p><input type='text' id='".$this->name."-label' name='xydac_custom[".$this->ftype."-".$this->name."][link_label]' value='".$val[$this->ftype]['link_label']."' /></p>";
		$e.="<label for='".$this->name."-URL'>".$this->label." URL</label>";
		$e.="<p><input type='text' id='".$this->name."-URL' name='xydac_custom[".$this->ftype."-".$this->name."][link_url]' value='".$val[$this->ftype]['link_url']."' /></p>";
		$e.="<p><span>".$this->desc."</span></p>";
		return $e;
	}
	
	public function saving(&$temp,$post_id,$val,$oval=null)
	{
		if(is_array($val))
			if(isset($val['link_url']))
				if(''!=$val['link_url'])
					{
						$val = array( $this->ftype=>$val);
						array_push($temp,update_post_meta($post_id, $this->name, $val));
					}
	}
	public function output($val,$atts)
	{
		$s="";
		if(is_array($val))
			$s.='<a href="'.$val['link_url'].'">'.$val['link_label'].'</a>';
		return $s;
	}

}

?>
<?php

//this class manages the relation between custom fields and Custom Post type
class fieldManager{

	var $cptname; //Custom Post Type Name
	var $name;
	var $label;
	var $type;	//Type of field
	var $desc;
	var $value;
	var $order;

	//functions:
	
	function fieldManager($new=false,$cptname,$name,$type,$label='',$desc='',$order='')
	{
		//checks the incoming values for error here.
		$this->cptname = $cptname;
		$this->name = sanitize_title_with_dashes($name);
		if($label='')
			$this->label = $name;
		else
			$this->label = $label;
		$this->desc = $desc;
		$this->order = $order;
	}
	
	public function getCptFieldrow($fname,$tname){
    $a = get_option('xydac_cpt_'.$tname);
	
	if(is_array($a))
		{foreach($a as $k=>$v)
			if($v['field_name']==$fname)
				{$v['cpt_name'] = $tname;return $v;}
		}
	else
		return false;//changed 0 to false
}
	public function getCptFields($name) {
	return get_option('xydac_cpt_'.$name);
}
	function insertField()
	{
		$sa = array();
		$sa['field_name'] = $this->name;
		$sa['field_label'] = $this->label;
		$sa['field_type'] = $this->type;
		$sa['field_desc'] = $this->desc;
		$sa['field_val'] = $this->value;
		$sa['field_order'] = $this->order;
		$getopt = get_option('xydac_cpt_'.$this->cptname);
		if(is_array($getopt))
			array_push($getopt,$sa);
		else
			{$getopt = array();array_push($getopt,$sa);}
		usort($getopt, array($this,'xy_cmp')); 
		update_option('xydac_cpt_'.$this->cptname,$getopt);
	}
	function updateField()
	{
		$sa = array();
		$sa['field_name'] = $this->name;
		$sa['field_label'] = $this->label;
		$sa['field_type'] = $this->type;
		$sa['field_desc'] = $this->desc;
		$sa['field_val'] = $this->value;
		$sa['field_order'] = $this->order;
		$xydac_cpt_fields = get_option('xydac_cpt_'.$this->cptname);
		foreach($xydac_cpt_fields as $k=>$xydac_cpt_field)
			if($xydac_cpt_field['field_name']==$sa['field_name'])
				{unset($xydac_cpt_fields[$k]);
				array_push($xydac_cpt_fields,$sa);
				usort($xydac_cpt_fields, array($this,'xy_cmp')); 
				update_option('xydac_cpt_'.$this->cptname,$xydac_cpt_fields);
				return 1;
				break;}
		return 0;
	}
	function deleteField()
	{
		$xydac_cpt_fields = get_option('xydac_cpt_'.$this->cptname);
		if(is_array($xydac_cpt_fields))
		foreach($xydac_cpt_fields as $k=>$xydac_cpt_field)
			if($xydac_cpt_field['field_name']==$field_name)
				{unset($xydac_cpt_fields[$k]);break;}
		usort($xydac_cpt_fields, array($this,'xy_cmp')); 
		update_option('xydac_cpt_'.$this->cptname,$xydac_cpt_fields);
	}
	//checks if the field name is available for Custom Post type
	function fieldAvail()
	{
		$l_row = $this->getCptFieldrow($fname,$tname);
		if(!$l_row)
			return 1;
		else 
			return 0;
	}
	private function xy_cmp($a, $b)
	{
		if(is_array($a)&& is_array($b))
			return strcmp($a['field_order'], $b['field_order']);
		else
			return false;
	}

}


?>
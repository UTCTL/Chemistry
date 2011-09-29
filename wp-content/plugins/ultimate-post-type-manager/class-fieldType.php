<?php 
// class field
abstract class fieldType{

	public $ftype; //class name of extension
	public $flabel; //Label for field types
	public $ver; //version of field type
	public $name; //name of field type 
	public $label; //label of field type 
	public $desc; // description of field type 
	public $value; // value of field type 
	public $helptext; // helptext of field type 
	public $basic;	//bool :true if field type is a basic type; 
	
	/* The primary Constructor of the class, Defines the basic stuffs,Always call this primary constructor in subclass
	 *
	 *
	 */
	public function __construct($name,$label='',$desc='',$val='',$help='')
	{
		$this->name = $name;
		if(''!=$label)
			$this->label= $label;
		else
			$this->label= $name;
		$this->desc = $desc;
		$this->helptext = $help;
		$this->ver = "1.0";
		$this->ftype = "new_field";
		$this->flabel = __("Label Undefined","xydac_cpt");
		$this->value=$val;
		$this->basic = false;
	}
	/* The function for defining the input data for field type.
	 * @post_id - Provide the Post id Under use, Use to fetch the post meta data.
	 * return the string containing html which generates the form
	 */
	abstract public function input($post_id);
	
	/* The function for handling the form data on save.
	 * @temp = The array used to store all update metadata values
	 * @post_id - Provide the Post id Under use, Use to fetch/save the post meta data.
	 * @val - the variable containing the post form data.
	 * @oval - Old value of the meta object
	 */
	abstract public function saving(&$temp,$post_id,$val,$oval=null);
	
	/* The function for customizing the output of the field type.
	 * @val - the variable containing stored data.
	 * @atts - Can be used for customizing the short code
	 */
	abstract public function output($val,$atts);
	
	/* The function for generating the select options.
	 */
	public function option($sel)
	{
		if($sel== $this->ftype)
			$t = "<option value='".$this->ftype."' Selected>".$this->flabel."</option>";
		else
			$t = "<option value='".$this->ftype."'>".$this->flabel."</option>";
		return $t;
	}
	/* This function returns True if basic variable is set to true, and false on false.
	 * ON TRUE : All the basic field types fall into same tab
	 * ON FALSE: All Non basic field types get their on tab.
	 */
	public function isBasic()
	{
		if($this->basic)
			return true;
		else
			return false;
	
	}
	/* Function that returns the script to be included in head section of admin panel
	 */
	public function adminscript()
	{ return;}
	/* Function that returns the style to be included in head section of admin panel
	 */
	public function adminstyle()
	{ return;}
	/* Function that returns the script to be included in head section of admin panel
	 */
	public function sitescript()
	{ return;}
	
	/* Function that returns the style to be included in head section of admin panel
	 */
	 public function sitestyle()
	{ return;}
	
	public function inputLabel($name,$label)
	{
	return "<label for='".$name."'>".$label."</label>";
	}
	public function inputText($id,$name,$value)
	{
	return "<p><input type='text' id='".$id."' name='xydac_custom[".$this->ftype."-".$name."]' value='".$value."' /></p>";
	}
	public function inputDesc($desc)
	{
	if(''!=$desc)
		return "<p><span>".$desc."</span></p>";
	else
		return "";
	}

}

?>
<?php
class debug {
	var $isActive;
	var $messages;
	var $activeIndex;
	var $showDebugging;
	
	public function __toString() {
		return '';
	}
	
	public function __invoke() {
		//var_dump ( $this );
	}
	
	function addMessage($message = '') {
		if (wec_isDebugMode ()) {
			//	debug::showMessage($message);
		}
	}
	
	function showMessage($message) {
		//	echo "<pre>"; print_r($message); echo "</pre><br />";
	}
	
	function dumpArray($data, $title=null) {
		if (is_array ( $data )) { //If the given variable is an array, print using the print_r function.
			print "<pre>-----------$title------------\n";
			print_r ( $data );
			print "-----------------------</pre>";
		} elseif (is_object ( $data )) {
			print "<pre>============$title==============\n";
			var_dump ( $data );
			print "===========================</pre>";
		} else {
			print "=====$title====&gt; ";
			var_dump ( $data );
			print " &lt;=========";
		}
	
	}

}

?>
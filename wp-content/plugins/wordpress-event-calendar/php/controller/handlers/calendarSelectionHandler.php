<?php 
class calendarSelectionHandler {
    var $selectionArray;
    var $currentMonth;
    
    function __construct() {
        $this->selectionArray = $this->getSelection();
		$this->currentMonth = $this->lookupCurrentMonth();
    }
    
    private function getSelection() {
        global $current_user;
        get_currentuserinfo();
        
        if ( empty($this->selectionArray)) {
            $this->setSelectionArray(get_usermeta($current_user->id, 'wec_calendar_selections'));
        }
        
        return $this->selectionArray;
    }
    
    function storeSelection() {
        global $current_user;
        get_currentuserinfo();
        
        update_usermeta($current_user->id, 'wec_calendar_selections', $this->selectionArray);
    }
    
    private function lookupCurrentMonth() {
        global $current_user;
        get_currentuserinfo();
        
        if ( empty($this->currentMonth)) {
            $this->setCurrentMonth(get_usermeta($current_user->id, 'wec_calendar_currentMonth'));
        }
        
        return $this->currentMonth;
    }
	
	 function storeCurrentMonth() {
        global $current_user;
        get_currentuserinfo();
        
        update_usermeta($current_user->id, 'wec_calendar_currentMonth', $this->currentMonth);
    }
    
	public function getCurrentMonth(){
		return $this->currentMonth;
	}
	
    /**
     * Returns $selectionArray.
     * @see calendarSelectionHandler::$selectionArray
     */
    public function getSelectionArray() {
        return $this->selectionArray;
    }
    
    /**
     * Sets $selectionArray.
     * @param object $selectionArray
     * @see calendarSelectionHandler::$selectionArray
     */
    public function setSelectionArray($selectionArray) {
        $this->selectionArray = $selectionArray;
    }
    
    /**
     * Sets $currentMonth.
     *
     * @param object $currentMonth
     * @see calendarSelectionHandler::$currentMonth
     */
    public function setCurrentMonth($currentMonth) {
        $this->currentMonth = $currentMonth;
    }
}
?>

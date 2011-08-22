<?php 
class calendar extends wec_db {

    private $ID;
    var $name;
    var $color;
    var $slug;
    var $description;
    private $feedID;

    
    //Constructor
    function __construct($calendarID = null, $autoPopulate = true) {
    
        //If we have an ID given to us
        if (! empty($calendarID)) {
            $this->setID($calendarID);
            $this->read();
        }
    }
    
    function delete() {
        if (isset($this->ID)) {
            calendarDA::deleteCalendar($this->id);
        }
        
    }
    
    /**
     * php 4x compatible constructor
     * @return
     */
    function calendar($calendarID = null) {
        $this->__construct($calendarID);
    }

    
    /**
     * Accessor Methods
     */
     
     /**
     * Returns $ID.
     * @see Calendar::$ID
     */
    public function getID() {
        return $this->ID;
    }
    
    /**
     * Sets $ID.
     * @param object $ID
     * @see Calendar::$ID
     */
    public function setID($ID) {
        $this->ID = attribute_escape($ID);
    }
    
    /**
     * Returns $color.
     * @see Calendar::$color
     */
    public function getColor() {
        return $this->color;
    }
    
    /**
     * Sets $color.
     * @param object $color
     * @see Calendar::$color
     */
    public function setColor($color) {
        $this->color = attribute_escape($color);
    }
    
    /**
     * Returns $description.
     * @see Calendar::$description
     */
    public function getDescription() {
        return stripslashes($this->description);
    }
    
    /**
     * Sets $description.
     * @param object $description
     * @see Calendar::$description
     */
    public function setDescription($description) {
        $this->description = attribute_escape($description);
    }
    
    /**
     * Returns $feedID.
     * @see Calendar::$feedID
     */
    public function getFeedID() {
        return $this->feedID;
    }
    
    /**
     * Sets $feedID.
     * @param object $feedID
     * @see Calendar::$feedID
     */
    public function setFeedID($feedID) {
        $this->feedID = $feedID;
    }
    
    /**
     * Returns $name.
     * @see Calendar::$name
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Sets $name.
     * @param object $name
     * @see Calendar::$name
     */
    public function setName($name) {
        $this->name = attribute_escape($name);
    }
    
    /**
     * Returns $slug.
     * @see Calendar::$slug
     */
    public function getSlug() {
        return stripslashes($this->slug);
    }
    
    /**
     * Sets $slug.
     * @param object $slug
     * @see Calendar::$slug
     */
    public function setSlug($slug) {
        $this->slug = $slug;
    }
}

?>

<?php 
/**
 * Class that allows model classes to implement CRUD functions
 */
class wec_db {

    function add() {
        global $wpdb;
        incrementWECqueries();
        $wpdb->insert($this->getDBPrefix().get_class($this), $this->toArray());
        return $wpdb->insert_id;
    }
    
    function create() {
        return $this->add();
    }
    
    function read() {
        global $wpdb;
        
        $query = $wpdb->prepare('SELECT * FROM '.$this->getDBPrefix().get_class($this).' WHERE '.get_class($this).'ID=%d', $this->getID());
        $results = $wpdb->get_results($query, ARRAY_A);
        incrementWECqueries();
        
        foreach ($results[0] as $property=>$value) {
            $this->$property = $value;
        }
    }
    
    function update() {
        global $wpdb;
        incrementWECqueries();
        $wpdb->update($this->getDBPrefix().get_class($this), $this->toArray(), array(get_class($this).'ID'=>$this->getID()));
    }
    
    function delete() {
        global $wpdb;
        incrementWECqueries();
        $query = 'delete from '.$this->getDBPrefix().get_class($this).' where '.get_class($this).'ID = '.$this->getID();
        $wpdb->query($wpdb->prepare($query));
    }
    
    function getDBPrefix() {
        global $wpdb;
        return $wpdb->prefix.'wec_';
    }
    
    function toArray() {
        $array = array();
        
        foreach ($this as $property=>$value) {
            if (!is_array($value) && $property != 'ID') {
                $array[$property] = $value;
            }
        }
        
        return $array;
    }
}
?>

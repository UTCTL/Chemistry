<?php 
class feedDA {

    function lookupAllFeeds() {
        global $wpdb;
        $query = 'SELECT * FROM '.WEC_FEED_TABLE;
        $return = $wpdb->get_results($query, ARRAY_A);
        incrementWECqueries();
        return $return;
        
    }
    
    function lookupAllEditableFeeds() {
        if (!get_option('wec_defaultFeedID')) {
            global $wpdb;
            $query = 'SELECT * FROM '.WEC_FEED_TABLE.' WHERE feedID != '.get_option('wec_defaultFeedID');
            incrementWECqueries();
            return $wpdb->get_results($query, ARRAY_A);
        } else {
            return $this->lookupAllFeeds();
        }
    }
    
    function lookupFeedByID($id) {
        global $wpdb;
        $query = 'SELECT * FROM '.WEC_FEED_TABLE.' WHERE feedID='.$id;
        return $wpdb->get_results($query, ARRAY_A);
    }
}

?>

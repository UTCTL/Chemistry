<?php 
class tagDA {

    function getAllTags() {
        global $wpdb;
        $query = "select distinct ".$wpdb->prefix."term_relationships.object_id 'id', ".$wpdb->prefix."terms.name from ".$wpdb->prefix."term_relationships inner join ".$wpdb->prefix."terms on ".$wpdb->prefix."term_relationships.object_id = ".$wpdb->prefix."terms.term_id where ".$wpdb->prefix."term_relationships.object_id in (select term_taxonomy_id from ".$wpdb->prefix."term_taxonomy where taxonomy = 'post_tag')";
        return $wpdb->get_results($query, ARRAY_A);
    }
    
    function getAllTagNames() {
        global $wpdb;
        $query = "select distinct ".$wpdb->prefix."terms.name from ".$wpdb->prefix."term_relationships inner join ".$wpdb->prefix."terms on ".$wpdb->prefix."term_relationships.object_id = ".$wpdb->prefix."terms.term_id where ".$wpdb->prefix."term_relationships.object_id in (select term_taxonomy_id from ".$wpdb->prefix."term_taxonomy where taxonomy = 'post_tag')";
        $results = $wpdb->get_results($query, ARRAY_A);
        
        $tagNames = array();
        $tagNamesIndex = 0;
        
        if (count($results) > 0) {
            foreach ($results as $result) {
                $tagNames[$tagNamesIndex] = $result["name"];
                $tagNamesIndex++;
            }
        }
        
        return $tagNames;
    }
    
    function createTagRelationship($tagID, $eventID) {
        global $wpdb;
        $wpdb->insert($wpdb->prefix.'wec_event_tag_relationships', array('eventID'=>$eventID, 'tagID'=>$tagID), array('%d', '%d'));
    }
    
    function deleteTagRelationship($tagID, $eventID) {

    
    }
    
    function deleteTagsByEventID($eventID) {
        global $wpdb;
        $query = "delete from ".$wpdb->prefix."wec_event_tag_relationships where eventID = ".$eventID;
        $wpdb->query($query);
    }
    
    function getEventTags($eventID, $array = true) {
        global $wpdb;
        $query = "select * from wp_wec_event_tag_relationships where eventID = ".$eventID;
        $results = $wpdb->get_results($query, ARRAY_A);

        
        $allTags = $this->getAllTags();
		
		//if we have no tags, there's no way an event can have any, so skip to the end
        if (count($allTags > 0)) {

        
            if ($array == true) {
                return $results;
            } else {
                $csvList = "";
                
                $listOfNames = array();
                $listOfNamesIndex = 0;
                
                if (count($results) > 0) {
                    foreach ($results as $result) {
                        foreach ($allTags as $tag) {
                            if ($tag["id"] == $result['tagID']) {
                                $listOfNames[$listOfNamesIndex] = $tag["name"];
                                $listOfNamesIndex++;
                            }
                        }
                    }
                    
                    unset($tag);
                    unset($result);

                    
                    $csvList = join(',', $listOfNames);
                    
                }

                
                return $csvList;
            }
        }
    }
    
}
?>

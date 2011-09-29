<?php 
class categoryDA
{


    function createCategoryRelationship($categoryID, $eventID)
    {
        global $wpdb;
        $wpdb->insert($wpdb->prefix.'wec_event_category_relationships', array('eventID'=>$eventID, 'categoryID'=>$categoryID), array('%d', '%d'));
    }
    
    function deleteCategoryRelationshipsByEventID($eventID)
    {
        global $wpdb;
        $query = "delete from ".$wpdb->prefix."wec_event_category_relationships where eventID = ".$eventID;
        $wpdb->query($query);
    }
    
    function lookupCategoryRelationshipsByEventID($eventID)
    {
        global $wpdb;
        $query = "select categoryID from ".$wpdb->prefix."wec_event_category_relationships where eventID = ".$eventID;
        $results = $wpdb->get_results($query, ARRAY_A);

        
        if (! empty($results))
        {
        
            $categoryIDs = array();
            $categoryIDsIndex = 0;
            foreach ($results as $idArray)
            {
                $categoryIDs[$categoryIDsIndex] = $idArray["categoryID"];
                $categoryIDsIndex++;
            }
			
			return $categoryIDs;
        }
        
        
    }
}
?>

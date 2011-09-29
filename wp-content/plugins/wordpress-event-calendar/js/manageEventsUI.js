function deleteEventUsingAJAX(eventID, nonce){

    if (confirm('You are about to delete this event. Are you sure you want to do this?')) {
        try {
            var ajaxObject = new sack('/wp-admin/admin-ajax.php');
            
            
            ajaxObject.execute = 1;
            ajaxObject.setVar('action', 'wec_deleteEventFromAJAX');
            ajaxObject.setVar('eventID', eventID);
            ajaxObject.setVar('wp_nonce', nonce);
            
            
            ajaxObject.onError = function(){
                alert("An error has occured deleting this event");
            };
            
            ajaxObject.runAJAX();
            
            
            
        } 
        catch (ex) {
            alert(ex);
        }
    }
    
    
    return false;
    
}

function deleteRecurrenceUsingAJAX(recurrenceID, nonce){
    if (confirm('You are about to delete this occurence of this event. Are you sure you want to do this?')) {
    
    
        try {
            var ajaxObject = new sack('/wp-admin/admin-ajax.php');
            
            
            ajaxObject.execute = 1;
            ajaxObject.setVar('action', 'wec_deleteRecurrenceFromAJAX');
            ajaxObject.setVar('recurrenceID', recurrenceID);
            ajaxObject.setVar('wp_nonce', nonce);
            
            
            ajaxObject.onError = function(){
                alert("An error has occured deleting this event");
            };
            
            ajaxObject.runAJAX();
            
            
            
        } 
        catch (ex) {
            alert(ex);
        }
        
    }
    return false;
    
}


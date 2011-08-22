<?php 
class feedGenerator {
    var $feedList;
    
    function __construct() {
    
        $this->createCustomFeeds();
        $this->createFeedsFromCalendars();
        
    }
    
    function addFeed($feed) {
        add_feed($feed->getSlug(), array($feed, 'printFeed'));
    }
    
    function createFeedsFromCalendars() {
    
        $calendarHandler = new calendarHandler();
        $calendars = $calendarHandler->readAll();
        
        if (! empty($calendars)) {
            foreach ($calendars as $calendar) {
            
                $feed = new feed();
                $feed->setName($calendar->getName());
                $feed->setFeedParameters('calendarID='.$calendar->getID());
                $feed->setSlug($calendar->getSlug());
                
                $this->addFeed($feed);
            }
            
            //Flush the rewrite object, to play nice with others
            global $wp_rewrite;
            $wp_rewrite->flush_rules();
        }

        
    }
    
    function createCustomFeeds() {
        $feedHandler = new feedHandler();
        $this->feedList = $feedHandler->getAllFeeds();
        
        if (! empty($this->feedList)) {
        
            /**
             * Loop through all the feeds and add them
             **/
            foreach ($this->feedList as $feed) {
                $this->addFeed($feed);
            }
            
            //Flush the rewrite object, to play nice with others
            global $wp_rewrite;
            $wp_rewrite->flush_rules();
        }
    }
    
}

?>
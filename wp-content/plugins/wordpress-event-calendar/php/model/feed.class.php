<?php 
class feed extends wec_db {
    var $ID;
    var $name;
    var $slug;
    var $feedParameters;
    var $description = '';

    
    /**
     *
     * @return
     */
    function __construct($feedID = null, $output = false) {
    
        //If we have a feed ID provided...
        if (! empty($feedID)) {
            $this->setID($feedID);
            $this->read();
        }
        
        if ($output) {
            $this->printFeed();
        }
        
    }
    
    function printFeed() {
    
        $this->feedHeader();
        
        $feedQuery = new WEC_Query($this->getFeedParameters());
        
        while ($feedQuery->haveEvents()):
            $feedQuery->the_event();
            
            $this->feedItem($feedQuery->getTheTitle(), $feedQuery->getEventExcerpt(), $feedQuery->getEventDescription(), $feedQuery->recurrence->getrecurrenceStartTime());
            
        endwhile;
        
        $this->feedFooter();
    }

    
    function feedHeader() {
        header('Content-Type: text/xml; charset='.get_option('blog_charset'), true);
        
        echo "<?xml version=\"1.0\" encoding=\"";
        echo get_option('blog_charset');
        echo "\"?>";
        ?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/">
    <?php do_action('rss2_ns'); ?>
    	
    <channel>
        <title><?php echo $this->getName(); ?></title>
        <!--<atom:link href="http://www.google.ca" rel="self" type="application/rss+xml" /> -->
        <link>
<?php echo bloginfo('url'); ?>
        </link>
        <description>
<?php echo $this->getDescription(); ?>
        </description>
        <pubDate>
<?php echo mysql2date('D, d M Y H:i:s +0000', date('Y-m-d H:i:s')); ?>
        </pubDate>
        <?php the_generator('rss2'); ?>
        <language>
            en
        </language>
        <sy:updatePeriod>
<?php apply_filters('rss_update_period', 'hourly'); ?>
        </sy:updatePeriod>
        <sy:updateFrequency>
<?php apply_filters('rss_update_frequency', '1'); ?>
        </sy:updateFrequency>
        <ttl>
            1
        </ttl>
        <?php 
        do_action('rss2_head');
        }
        
        
        function feedFooter() {
            $timeManager = new dateTimeManager();
            
        ?>
    </channel>
</rss>
</xml>
<?php 
}

function feedItem($title, $description, $content, $eventTime) {
    
?>
<item>
    <title><?php echo $title; ?> on <?php echo date('l, F j, Y', $eventTime); ?></title>
    <link>
<?php bloginfo('url'); ?>
    </link>
    <pubDate>
<?php echo mysql2date('D, d M Y H:i:s +0000', date('Y-m-d H:i:s', $timeManager->subtractDaysFromTimeStamp($eventTime, get_option('wec_numberOfDaysBeforeEventToPublishInRSSFeed')))); ?>
    </pubDate>
    <description>
<![CDATA[<?php echo $content; ?>]]>
    </description>
    <content:encoded>
<![CDATA[<?php echo $content; ?>]]>
    </content:encoded>
</item>
<?php 
}

/**
 * Returns $ID.
 * @see feed::$ID
 */
public function getID() {
    return $this->ID;
}

/**
 * Sets $ID.
 * @param object $ID
 * @see feed::$ID
 */
public function setID($ID) {
    $this->ID = $ID;
}


/**
 * Returns $feedParameters.
 * @see feeds::$feedParameters
 */
public function getFeedParameters() {
    return $this->feedParameters;
}

/**
 * Sets $feedParameters.
 * @param object $feedParameters
 * @see feeds::$feedParameters
 */
public function setFeedParameters($feedParameters) {
    $this->feedParameters = $feedParameters;
}

/**
 * Returns $name.
 * @see feeds::$name
 */
public function getName() {
    return stripslashes($this->name);
}

/**
 * Sets $name.
 * @param object $name
 * @see feeds::$name
 */
public function setName($name) {
    $this->name = $name;
}

/**
 * Returns $slug.
 * @see feeds::$slug
 */
public function getSlug() {
    return $this->slug;
}

/**
 * Sets $slug.
 * @param object $slug
 * @see feeds::$slug
 */
public function setSlug($slug) {
    $this->slug = $slug;
}

/**
 * Returns $description.
 * @see feed::$description
 */
public function getDescription() {
    return $this->description;
}

/**
 * Sets $description.
 * @param object $description
 * @see feed::$description
 */
public function setDescription($description) {
    $this->description = $description;
}

}

?>

<?php 
/**
 * A Post class to work with posts. This class is multi-use, if it is instantiated
 * with a post ID it will contain all the post data for that post, or if it is created
 * without an ID, it can act as a temporary container, then write the data when add_post()
 * is called.
 *
 *
 */
class calendarPost extends Object {
    protected $postID;
    var $comment_status;
    var $post_content;
    var $post_date;
    var $post_date_gmt;
    var $post_excerpt;
    var $post_title;
    var $post_type = 'post';
    var $post_author;
    var $post_category = array();
    var $post_ping_status;
    
    //This is an event ID
    var $postEventID;
    
    //This is a recurrence ID
    var $postRecurrenceID;
    
    private $postData = array(null);
    protected $postMeta = array(null);
    protected $eventData;
    
    function __construct($eventID = null, $recurrenceID = null, $postID = null) {
        //If we have a post ID...
        if (! empty($postID)) {
            $this->lookupPostData($postID);
            $this->postID = $postID;
        } else {
            $this->post_author = wecUser::getUserID();
        }
        
        //If we have an event ID...
        if (! empty($eventID)) {
            $this->postEventID = $eventID;
        }
        
        //If we have a recurrence ID...
        if (! empty($recurrenceID)) {
            $this->postRecurrenceID = $recurrenceID;
        }
        
    }
    
    function add_post() {
        $this->postID = wp_insert_post($this->postData);
        //echo 'New Post ID: ' . $this->postID . '<br />';
        $this->addPostMetaData();
    }
    
    function update_post() {
        wp_update_post($this->postData);
    }
    
    private function lookupPostData($postID) {
        $postData = get_post($postID, ARRAY_A);
    }
    
    private function generatePostData() {
        $this->postData['post_title'] = $this->getPost_title();
        $this->postData['post_author'] = $this->getPost_author();
        $this->postData['post_content'] = $this->getPost_content();
        $this->postData['post_excerpt'] = $this->getPost_excerpt();
        $this->postData['post_type'] = $this->getPost_type();
        $this->postData['comment_status'] = "closed";
        $this->postData['post_date'] = $this->getPost_date();
        $this->postData['post_date_gmt'] = $this->getPost_date_gmt();
        $this->post_ping_status = get_option('default_ping_status');
        $this->setPost_category(wec_getEventCategoryID());
        
    }
    
    private function lookupPostMetaData() {
        $metaKeys = get_post_custom_keys($this->postID);
        //var_dump($metaKeys);
    }
    
    private function addPostMetaData() {
        //Add the event ID to the post
        if (!update_post_meta($this->postID, '_EventID', $this->postEventID)) {
            add_post_meta($this->postID, '_EventID', $this->postEventID);
        }
        
        //Add the recurrence ID to the post
        
        if (!update_post_meta($this->postID, '_RecurrenceID', $this->postRecurrenceID)) {
            add_post_meta($this->postID, '_RecurrenceID', $this->postRecurrenceID);
        }
    }
    
    private function lookupEventData() {
        $this->eventData = eventDA::lookupEventByID($this->postEventID);
    }
    
    public function populateDataFromEvent() {
        //Start by looking up the data
        $this->lookupEventData();
        
        //Then take the event fields populate this object
        $this->post_title = $this->eventData[0]['eventName'];
        $this->post_content = $this->eventData[0]['eventDescription'];
        $this->post_excerpt = $this->eventData[0]['eventExcerpt'];
        $this->post_author = wecUser::getUserID();
        
        $this->generatePostData();
    }
    
    /**
     * Returns $postID.
     * @see calendarPost::$postID
     */
    public function getPostID() {
        return $this->postID;
    }
    
    /**
     * Sets $postID.
     * @param object $postID
     * @see calendarPost::$postID
     */
    private function setPostID($postID) {
        $this->postID = $postID;
    }
    
    /**
     * Returns $comment_status.
     * @see calendarPost::$comment_status
     */
    public function getComment_status() {
        return $this->comment_status;
    }
    
    /**
     * Sets $comment_status.
     * @param object $comment_status
     * @see calendarPost::$comment_status
     */
    public function setComment_status($comment_status) {
        $this->comment_status = $comment_status;
    }
    
    /**
     * Returns $post_author.
     * @see calendarPost::$post_author
     */
    public function getPost_author() {
        return $this->post_author;
    }
    
    /**
     * Sets $post_author.
     * @param object $post_author
     * @see calendarPost::$post_author
     */
    public function setPost_author($post_author) {
        $this->post_author = $post_author;
    }
    
    /**
     * Returns $post_category.
     * @see calendarPost::$post_category
     */
    public function getPost_category() {
        return $this->post_category;
    }
    
    /**
     * Sets $post_category.
     * @param object $post_category
     * @see calendarPost::$post_category
     */
    public function setPost_category($post_category) {
        $this->post_category = $post_category;
    }
    
    /**
     * Returns $post_content.
     * @see calendarPost::$post_content
     */
    public function getPost_content() {
        return $this->post_content;
    }
    
    /**
     * Sets $post_content.
     * @param object $post_content
     * @see calendarPost::$post_content
     */
    public function setPost_content($post_content) {
        $this->post_content = $post_content;
    }
    
    /**
     * Returns $post_date.
     * @see calendarPost::$post_date
     */
    public function getPost_date() {
        return $this->post_date;
    }
    
    /**
     * Sets $post_date.
     * @param object $post_date
     * @see calendarPost::$post_date
     */
    public function setPost_date($post_date) {
        $this->post_date = $post_date;
    }
    
    /**
     * Returns $post_date_gmt.
     * @see calendarPost::$post_date_gmt
     */
    public function getPost_date_gmt() {
        return $this->post_date_gmt;
    }
    
    /**
     * Sets $post_date_gmt.
     * @param object $post_date_gmt
     * @see calendarPost::$post_date_gmt
     */
    public function setPost_date_gmt($post_date_gmt) {
        $this->post_date_gmt = $post_date_gmt;
    }
    
    /**
     * Returns $post_excerpt.
     * @see calendarPost::$post_excerpt
     */
    public function getPost_excerpt() {
        return $this->post_excerpt;
    }
    
    /**
     * Sets $post_excerpt.
     * @param object $post_excerpt
     * @see calendarPost::$post_excerpt
     */
    public function setPost_excerpt($post_excerpt) {
        $this->post_excerpt = $post_excerpt;
    }
    
    /**
     * Returns $post_title.
     * @see calendarPost::$post_title
     */
    public function getPost_title() {
        return $this->post_title;
    }
    
    /**
     * Sets $post_title.
     * @param object $post_title
     * @see calendarPost::$post_title
     */
    public function setPost_title($post_title) {
        $this->post_title = $post_title;
    }
    
    /**
     * Returns $post_type.
     * @see calendarPost::$post_type
     */
    public function getPost_type() {
        return $this->post_type;
    }
    
    /**
     * Sets $post_type.
     * @param object $post_type
     * @see calendarPost::$post_type
     */
    public function setPost_type($post_type) {
        $this->post_type = $post_type;
    }
    
    /**
     * Returns $postData.
     * @see calendarPost::$postData
     */
    public function getPostData() {
        return $this->postData;
    }
    
    /**
     * Sets $postData.
     * @param object $postData
     * @see calendarPost::$postData
     */
    public function setPostData($postData) {
        $this->postData = $postData;
    }
    
    /**
     * Returns $postEvent.
     * @see calendarPost::$postEvent
     */
    public function getPostEventID() {
        return $this->postEventID;
    }
    
    /**
     * Sets $postEvent.
     * @param object $postEvent
     * @see calendarPost::$postEvent
     */
    public function setPostEventID($postEventID) {
        $this->postEventID = $postEventID;
    }
    
    /**
     * Returns $postMeta.
     * @see calendarPost::$postMeta
     */
    public function getPostMeta() {
        return $this->postMeta;
    }
    
    /**
     * Sets $postMeta.
     * @param object $postMeta
     * @see calendarPost::$postMeta
     */
    public function setPostMeta($postMeta) {
        $this->postMeta = $postMeta;
    }
    
    /**
     * Returns $postRecurrence.
     * @see calendarPost::$postRecurrence
     */
    public function getPostRecurrenceID() {
        return $this->postRecurrenceID;
    }
    
    /**
     * Sets $postRecurrence.
     * @param object $postRecurrence
     * @see calendarPost::$postRecurrence
     */
    public function setPostRecurrenceID($postRecurrenceID) {
        $this->postRecurrenceID = $postRecurrenceID;
    }
    
    /**
     * Returns $eventData.
     * @see calendarPost::$eventData
     */
    public function getEventData() {
        return $this->eventData;
    }
    
    /**
     * Sets $eventData.
     * @param object $eventData
     * @see calendarPost::$eventData
     */
    public function setEventData($eventData) {
        $this->eventData = $eventData;
    }
    
}

?>

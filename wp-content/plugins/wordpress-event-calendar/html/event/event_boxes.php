<?php 
require_once('includes/meta-boxes.php');

function showPublishBox($eventID = 0)
{
    
?>
<div id="submitdiv" class="postbox">
    <div class="handlediv" title="Click to toggle">
        <br>
    </div>
    <h3 class="hndle"><span>Publish</span></h3>
    <div class="inside">
        <div class="submitbox" id="submitpost">
            <div id="minor-publishing">
                <div style="display:none;">
                    <input type="submit" name="save" value="Save">
                </div>
                <div id="minor-publishing-actions">
                    <?php if ($eventID != 0) { ?>
                    <div id="delete-action">
                        <a class="submitdelete deletion" href="" onclick="if(confirm('You are about to delete this event. Press Cancel to stop or OK if you\'re sure')){$('deleteEventForm').submit();}">Delete Event</a>
                    </div>
                    <form id="deleteEventForm" action="<?php wec_currentURL ()?>?page=calendar.php" method="post" style="display: inline;">
                        <input type="hidden" name="wec_action" value="deleteEvent" /><input type="hidden" name="eventID" value="<?php echo $eventID; ?>"/>
                    </form>
                    <div id="publishing-action">
                        <img src="images/wpspin_light.gif" id="ajax-loading" style="visibility: hidden; " alt=""><input name="save" type="submit" class="button-primary" id="publish" tabindex="5" accesskey="p" value="Update">
                    </div>
                    <?php 
                    }
                    else
                    {
                        
                    ?>
                    <div id="publishing-action">
                        <img src="images/wpspin_light.gif" id="ajax-loading" style="visibility: hidden; " alt=""><input name="save" type="submit" class="button-primary" id="publish" tabindex="5" accesskey="p" value="Publish">
                    </div>
                    <?php } ?>
                    <div class="clear">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
}

function showTaxonomyBoxes($postID = null)
{

?>
<div id="tags-sortables" class='meta-box-sortables'>

<?php

	$box = array();
	$box['title'] = __("Post Tags");
    $box['args'] = null;
    $box['id'] = "tagsdiv-post_tag";
    $box['callback'] = 'post_tags_meta_box';
                
    echo '<div id="' . $box['id'] . '" class="postbox ' . postbox_classes($box['id'], $page) . $hidden_class . '" ' . '>' . "\n";
	echo '<div class="handlediv" title="' . __('Click to toggle') . '"><br /></div>';
	echo "<h3 class='hndle'><span>{$box['title']}</span></h3>\n";
	echo '<div class="inside">' . "\n";
				
	if(is_null($postID))
	{
		call_user_func($box['callback'], $object, $box);
	}
	else
	{
		call_user_func($box['callback'], get_post($postID), $box);
	}
				
	echo "</div>\n";
	echo "</div>\n";
            
?>
</div>
              
<div id="category-sortables" class='meta-box-sortables'>

<?php
	$box = array();
	$box['title'] = __("Categories");
	$box['args'] = null;
	$box['id'] = "categorydiv";
	$box['callback'] = 'post_categories_meta_box';
                
    echo '<div id="' . $box['id'] . '" class="postbox ' . postbox_classes($box['id'], $page) . $hidden_class . '" ' . '>' . "\n";
	echo '<div class="handlediv" title="' . __('Click to toggle') . '"><br /></div>';
	echo "<h3 class='hndle'><span>{$box['title']}</span></h3>\n";
	echo '<div class="inside">' . "\n";
				
	if(is_null($postID))
	{
		call_user_func($box['callback'], $object, $box);
	}
	else
	{
		call_user_func($box['callback'], get_post($postID), $box);
	}
	
	echo "</div>\n";
	echo "</div>\n";
    ?>
</div>
<?php
}
?>
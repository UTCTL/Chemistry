<?php
/*
Template Name: Lecture Calendar
*/

include(WP_PLUGIN_URL . '/wordpress-event-calendar/html/manage/calendarUserView.php');
?>

<?php get_header(); ?>

<?php $currentPage = get_permalink();
//var_dump($currentPage);
 ?>
 
<script type="text/javascript">
	jQuery(document).ready(function(){
	});
</script>
<style>
<?php
wp_reset_query();
// The Query

$announcements = get_posts( array( 'post_type' => 'announcement', 'numberposts' => -1 ) );
	
wp_reset_query();

$sections = get_posts( array( 'post_type' => 'section', 'numberposts' => -1 ) );
foreach ($sections as $section) :
	//echo "." . $section -> post_title . "{ }\n";
endforeach;

?>


#old_announcements {
    width: 18em !important;
    margin: 0 1em 0 0 !important;
}

#old_course_material {
    margin: 1em 1em 0 0 !important;
}

#primary_calendar {
	width: 64%;
	float:left;
	margin-left: 17px;
}

#announcements {
	width: 30%;
	background-color:#F0F0F0;
	float:right;
	margin: 37px 15px 5px 0px ;
}

#announcements .scrolling {
	overflow:auto;
	height: 318px;
}

#course_material .scrolling {
	overflow:auto;
	height: 318px;
}

#announcements ul, #course_material ul {
	list-style: none;
	margin:0;
	padding:0;
}
#announcements ul li:first-child, #course_material ul li:first-child {
    border-top:0;
}
#announcements ul li, #course_material ul li {
    padding:0.25em 1em;
    border-top:1px solid #CCC;
}
#announcements > h2, #course_material > h2 {
	text-align: center;
	font-weight: bold;
    border-bottom:1px solid #999;
}
#announcements p, #course_material p {
    margin:0;
    padding:0 0 0.5em 0;
} 

#announcements ul li p, #announcements ul li a {
	font-size: .8em;
}

#announcements ul li hr {
	margin: 1px 0 1px 0;
}

#course_material {
	width: 30%;
	background-color:#F0F0F0;
	clear:none;
	float:right;
	margin: 15px 15px 0 0;
}

.allSections {
	background-color: red;
}

#calendar-list {
    clear: none;
    width: 37em;
    float: left;
    margin: 0 1em;
    color: #FAFAFA;
}

#calendar-list .eventDate-topright {
	float:right;
	font-size: .9em;
	margin: 0px 5px 0px 0px;
}

#calendar-list p {
	margin: 0 0 0 0;
	font-size: .8em;
	
}

#calendar-list h3 {
	float:left;
	margin: 0 0 0 0;
	
}

.xxxsingle-event-listing {
	min-height: 60px;
}

.eventData, p.eventLocation {
	padding-left:.5em;
}

.eventDate-topright {
	font-size: .9em;
}


.leftArrow, .rightArrow, .monthNameText {
    font-size: 1.2em;
    font-weight: bold;
}
.monthNameText {
    color:#DDD;
}

.wec_calendarDayBox .description {
    color:#373737;
}
.wec_calendarDayBox .description:hover div {
    text-decoration:underline;
}

#todayButton {
    float: right;
    display: inline;
    margin: 0;
}
#goToToday .button {
    line-height: 1em;
    box-shadow: inset 0 0 19px #fff;
    border-radius: 2px;
    padding: 0.25em;
    border: 1px solid #EEE;
    margin: 0 0 0.5em 0;
    width: 7em;
    height: 2em;
}

</style>

<script>
</script>

<?php
wp_reset_query();
// The Query
query_posts( array( 'post_type' => 'module' ) );

?>

<div id="primary_calendar">
	<div id="content" role="main" class="calendar_content">
	    
	    <?php
	    
	    the_content();
	    
		 ?>
	    
        <script type="text/javascript">
            /*
            <?php
                $users = array();
                $lectures = array();
                while ( have_posts() ) : the_post();
                	foreach (get_post_custom() as $attr=>$val) {
                	    if (strstr($attr,'_schedule_')) {
                	        $deets = unserialize(base64_decode($val[0]));
                	        $user = get_userdata($deets['user_id']);
                	        if (!in_array('\'user_'.$user->user_login.'\'', $users)) {
                	            $users[$user->user_login] = $user->display_name;
            	            }
                	        $lectures[] = array(
                	          'title' => html_entity_decode(the_title('','',false), ENT_NOQUOTES, 'UTF-8'),
                	          'start' => "new Date('".$deets['lecture_date']."')",
                	          'url'   => get_permalink(),
                	          'allDay' => true,
                	          'className' => 'custom_lecture user_'.$user->user_login  
                	        );
                	    }
                	}
                endwhile;
                
                echo 'var cal_lectures = '.json_encode($lectures).';';
                echo 'var cal_users = '.json_encode($users).';';
            ?>
            */
        </script>
    
        <div id="calendar" class="startAsHide">
            <?php wec_calendar_user_view($currentPage); ?>
        </div>
            
	</div><!-- #content -->
</div><!-- #primary -->



<?php
wp_reset_query();
// The Query
//query_posts( array( 'post_type' => 'announcement' ) );
?>
<div id="announcements" class="startAsHide">
	<h2>Announcements</h2>
	<div class="scrolling">
	<ul>
	<?php 
	
		foreach ($announcements as $ann) :
		
    		$attachments = attachments_get_attachments($ann->ID);
		
			$selected_ann_html_page_ids = get_post_meta($ann->ID, 'html-pages');
			
			if (!empty($selected_ann_html_page_ids[0])) {
				$html_ann_pages = get_pages(array('post_type'=>'html-page','include'=>$selected_ann_html_page_ids[0]));
				} else {
				$html_ann_pages = array();
			}
			$announcementTitle = $ann ->post_title;
			$announcementContent = $ann -> post_content;
			
			$sectionID = $ann -> post_parent;
    		$sectionPost = get_post($sectionID);
    		$sectionTitle = $sectionPost -> post_title;
    		
    		$divName;
    		if ($sectionID === 0) :
    			$divName = "allSections"; //no specific section for this professor
    		else:
    			$divName = $sectionTitle;
    		endif;
			
			//list the announcement titles and content in divs of their section name
			echo "<li class='boxing' class =" . "'$divName'" . ">";
				echo "<h2>";
				echo $announcementTitle;
				echo "</h2>";
				echo wpautop($announcementContent);
				foreach($html_ann_pages as $aPage) {
					echo "<a target=\"_blank\" href=\"" . $aPage->guid . "\">". $aPage->post_title . "</a>" . "<br />";
				}
				foreach($attachments as $attchmnt) {
					echo "<a target=\"_blank\" href=\"" . $attchmnt['location'] . "\">". $attchmnt['title'] . "</a>" . "<br />";
				}
			echo "</li>";
	/*()
		while ( have_posts() ) : the_post();
			
			$announcementTitle = $post ->post_title;
			
			$parentID = $post -> post_parent;
    		$parentPost = get_post($parentID);
    		$parentTitle = $parentPost -> post_title;
    		
    		$divName;
    		if ($announcementTitle === $parentTitle) :
    			$divName = "allSections";
    		else:
    			$divName = $parentTitle;
    		endif;
    		//echo "the div class name will be " . $divName;
			
			echo "<li class='box' class =" . $divName . ">";
				echo "<h2>";
				echo $announcementTitle;
				echo "</h2>";
				$content = get_the_content();
				echo wpautop($content);
				echo "<hr />";
			echo "</li>";
	*/
	?>
	<?php endforeach; ?>
	</ul>
	</div>
</div><!-- #announcments -->

<?php

//this query will need to get the section based off of the current calendar selected
wp_reset_query();
// The Query
query_posts( array( 'post_type' => 'section' ) );


?>

<div id="course_material" class="startAsHide">
	<h2>Course Material</h2>
	<div class="scrolling">
	<ul>
	<?php while ( have_posts() ) : the_post(); ?>
	    
		<?php
		$selected_html_page_ids = get_post_meta($post->ID, 'html-pages');
		if (!empty($selected_html_page_ids[0])) {
			$html_pages = get_pages(array('post_type'=>'html-page','include'=>$selected_html_page_ids[0]));
			} else {
			$html_pages = array();
		}
		if (!empty($html_pages)) { ?>
		    <li>
		    <?php
        		//$html_pages = get_pages(array('post_type'=>'html-page','include'=>$selected_html_page_ids[0]));
        		foreach($html_pages as $aPage) {
        			echo "<a target='_blank' href=" . $aPage->guid . ">". $aPage->post_title . "</a>" . "<br />";
        		}
    		?>
		    </li>
		<?php }
					
		//echo "<a target='_blank' href=" . $attachments[$i]['location'] . ">". $attachments[$i]['title'] . "</a>" . " - " . $attachments[$i]['caption'] . "<br />";
		//echo "<h3>" . $post ->post_title  . "</h3>";
		$attachments = attachments_get_attachments();
		$totalAttachments = count($attachments);
		if ($totalAttachments) : ?>
		    <li>
		    <?php
				for($i=0; $i < $totalAttachments; $i++):
					echo "<a target='_blank' href=" . $attachments[$i]['location'] . ">". $attachments[$i]['title'] . "</a>" . " - " . $attachments[$i]['caption'] . "<br />";
				endfor;
			?>
			</li>
		<?php endif; ?>
		
	<?php endwhile; ?>
	</ul>
	</div>
</div><!-- #course_material -->

<div id="calendar-list">
<br />
<?php 
        /*$caledarMap = array();
        $queryCalendars = mysql_query("SELECT * FROM wpv2_wec_calendar WHERE name != 'Default Calendar'");
        while ($row = mysql_fetch_assoc($queryCalendars)) {
    		$calendarMap[($row['calendarID'])] = $row['name'];
		}
		//var_dump($calendarMap);*/
?>
		<?php
		//############## this is grabbing the vanden bout / lebrake calendar directly which is ID 3
        $queryObject = new WEC_Query('calendarID=3');
        //Start the loop
        while($queryObject->haveEvents()): $queryObject->the_event();
	        //display some stuff
	        ?>
	        <div id="<?php echo $queryObject->getEventID().$queryObject->getRecurrenceID(); ?>" class="single-event-listing">
    	        <div class="eventDate-topright"> <?php $queryObject->startDate('D, F jS, Y'); ?></div>
    	        <h3 class="eventData" style="float:left;"> <?php $queryObject->eventTitle(); ?></h3>
    	        <br />
    	        <p class="eventLocation" class="eventData"><?php 
    	        $queryObject->eventLocation();
    	        ?>
    	        </p> 
    	        <?php
    	        //echo "location: " . $thisEventLocation;
    	        if( function_exists( 'attachments_get_attachments' ) )
                {
                    $attachments = attachments_get_attachments($queryObject->getPostID());
                    $total_attachments = count( $attachments );
                    if( $total_attachments ) : ?>
                        <ul class="eventData" class="attachments">
                            Attachments
                            <?php for( $i=0; $i<$total_attachments; $i++ ) : ?>
                                <li><a href="<?php echo $attachments[$i]['location']; ?>" TARGET="_blank"><?php echo $attachments[$i]['title']; ?></a> - <caption><?php echo $attachments[$i]['caption']; ?></caption></li>
                            <?php endfor; ?>
                        </ul>
                    <?php endif;
                }
    	        ?>
    	        </p>
    	        <p class="eventData" class="eventDescription"> <?php $queryObject->eventDescription(); ?></p>
	        
    	        <hr />
	        </div>
	        <?php
        endwhile;
?>
</div>

<!-- #main -->

<?php get_footer(); ?>

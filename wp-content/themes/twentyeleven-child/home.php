<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 */
query_posts( $arr = array ('post_type' => 'unit', 'posts_per_page' => '100','orderby'=>'menu_order','order'=>'ASC'));


get_header(); 
?>

<div id="primary">

<div id="content" class="widecolumn">

    <ul id="units">

    <?php

    $postArr = array();
    while ( have_posts() ) : the_post();

        echo '<li id="'.$post->post_name.'">';
	
		$unitStatus = get_post_meta($post->ID, 'enable_module');
		if($unitStatus[0] == 1)
		{
			echo    '<a class="levela" href="'.$post->guid.'">'.$post->post_title.'</a>';
        	echo '<ul>';
		}
			
		else
		{
			echo    '<p class="levela-disabled">'.$post->post_title.'</p>';
        	echo '<ul>';
		}

			$modules = get_children( array('post_parent' => $post->ID, 'post_type' => 'module','orderby'=>'menu_order','order'=>'ASC') );
		
    	foreach ($modules as $module) {
        	if (has_post_thumbnail( $module->ID ) )
        	{
        		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $module->ID ), 'single-post-thumbnail' );
        	}
    	
		    $ratio = $image[2]/$image[1];
		    if ($ratio >= 1) {
			    $width = 50 - intval((1/$ratio) * 43);
			    $paddingTop = 'padding-top:0px;';
			    $paddingLeft = 'padding-left:'.($width/2).'px;';
			    $paddingRight = 'padding-right:'.($width/2).'px;';
		    } else {
		        $height = 43 - intval($ratio * 50);
			    $paddingTop = 'padding-top:'.($height/2).'px;';
			    $paddingLeft = 'padding-left:0px;';
			    $paddingRight = 'padding-right:0px;';
		    }
		    
	        echo '<li class="level2">';
			$status = get_post_meta($module->ID, 'enable_module');
			
			if($status[0] == '1' || $status[0] == 'enable')
			{
	        	echo    '<a  id="'.$module->post_name.'" class="level2a" href="'.$module->guid.'"><img style="'.$paddingTop.$paddingLeft.$paddingRight.'" src="'.$image[0].'" />'.$module->post_title.'</a>';
	        echo '</li>';
			}
			
			else
			{
				echo    '<p  id="'.$module->post_name.'" class="level2a_disabled" ><img style="'.$paddingTop.$paddingLeft.$paddingRight.'" src="'.$image[0].'" />'.$module->post_title.'</p>';
	        echo '</li>';
			}	
    	}
    	
    	echo    '</ul>';
    	echo '</li>';

    endwhile;

    ?>

    </ul>
    
</div>
</div>

<?php get_footer(); ?>
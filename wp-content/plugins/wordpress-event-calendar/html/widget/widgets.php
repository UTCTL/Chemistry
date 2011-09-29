<?php 
class wec_widget extends WP_Widget {

    var $outputString = '';
    var $defaultHTML = '';
    var $defaultQuery = 'limit=3';
    
    function wec_widget() {
        $widget_ops = array('classname'=>'wordpress_event_calendar', 'description'=>__("Show events from WordPress Event Calendar"));
        $control_ops = array('width'=>300, 'height'=>300);
        $this->WP_Widget('wordpresseventcalendar', __('WordPress Event Calendar'), $widget_ops, $control_ops);
    }
    
    function widget($args, $instance) {
        extract($args);
        
        //Before the widget
        echo $before_widget;

        
        $html = empty($instance['html']) ? $this->defaultHTML : $instance['html'];
        $lineTwo = empty($instance['query']) ? $this->defaultQuery : $instance['query'];

        
        $queryObject = new WEC_Query($instance['query']);
        
        while ($queryObject->haveEvents()):
            $queryObject->theEvent();
            
            $tags = array('#NAME#', '#TITLE#', '#DATE#', '#TIME#');
            $replacements = array($queryObject->getTheTitle(), $queryObject->getTheTitle(), $queryObject->getTheDate(), $queryObject->getStartTime());

            
            $string = $instance['html'];
            str_replace($tags, $replacements, $string);
            
            //Append the latest line to the output, but first replace the tags with the right info
            $this->outputString .= $string;

            
        endwhile;
        
        echo $this->outputString;
        
        // After the widget
        echo $after_widget;
    }
    
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['html'] = trim(strip_tags(stripslashes($new_instance['html'])));
        $instance['query'] = strip_tags(stripslashes($new_instance['query']));

        
        return $instance;
    }
    
    function form($instance) {
        //Defaults
        $instance = wp_parse_args((array) $instance, array('html'=>$this->defaultHTML, 'query'=>$this->defaultQuery));
        
        $html = htmlspecialchars($instance['html']);
        $query = htmlspecialchars($instance['query']);
        
        //Output the options
        
?>
<p style="text-align:right;">
    <label for="<?php $this->get_field_id('html'); ?>" style="float: left;">
        HTML:
    </label>
    <textarea style="width: 250px;" id="<?php echo $this->get_field_id('html'); ?>" name="<?php $this->get_field_name('html'); ?>">
<?php echo $html; ?>
    </textarea>
    <label for="<?php $this->get_field_id('query'); ?>" style="float: left;">
        Query:
    </label>
    <input type="text" id="<?php echo $this->get_field_id('query'); ?>" name="<?php $this->get_field_name('query'); ?>" value="<?php echo $query; ?>"/>
</p>
<?php 
}

function appendWriteData($string) {
    $this->outputString .= $string;
}
}

/**
 * Register Hello World widget.
 *
 * Calls 'widgets_init' action after the Hello World widget has been registered.
 */
function wec_widgetAdd() {
    register_widget('wec_widget');
    register_widget('HelloWorldWidget');
}

add_action('widgets_init', 'wec_widgetAdd');


/*
 * Plugin Name: Hello World Example
 * Version: 1.0
 * Plugin URI: http://jessealtman.com/2009/06/08/tutorial-wordpress-28-widget-api/
 * Description: Hello World example widget using the the WordPress 2.8 widget API. This is meant strictly as a means of showing the new API using the <a href="http://jessealtman.com/2009/06/08/tutorial-wordpress-28-widget-api/">tutorial</a>.
 * Author: Jesse Altman
 * Author URI: http://jessealtman.com/
 */
class HelloWorldWidget extends WP_Widget {
    /**
     * Declares the HelloWorldWidget class.
     *
     */
    function HelloWorldWidget() {
        $widget_ops = array('classname'=>'widget_hello_world', 'description'=>__("Example widget demoing WordPress 2.8 widget API"));
        $control_ops = array('width'=>300, 'height'=>300);
        $this->WP_Widget('helloworld', __('Hello World Example'), $widget_ops, $control_ops);
    }
    
    /**
     * Displays the Widget
     *
     */
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? '&nbsp;' : $instance['title']);
        $lineOne = empty($instance['lineOne']) ? 'Hello' : $instance['lineOne'];
        $lineTwo = empty($instance['lineTwo']) ? 'World' : $instance['lineTwo'];
        
        # Before the widget
        echo $before_widget;
        
        # The title
        if ($title)
            echo $before_title.$title.$after_title;
            
        # Make the Hello World Example widget
        echo '<div style="text-align:center;padding:10px;">'.$lineOne.'<br />'.$lineTwo."</div>";
        
        # After the widget
        echo $after_widget;
    }
    
    /**
     * Saves the widgets settings.
     *
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags(stripslashes($new_instance['title']));
        $instance['lineOne'] = strip_tags(stripslashes($new_instance['lineOne']));
        $instance['lineTwo'] = strip_tags(stripslashes($new_instance['lineTwo']));
        
        return $instance;
    }
    
    /**
     * Creates the edit form for the widget.
     *
     */
    function form($instance) {
        //Defaults
        $instance = wp_parse_args((array) $instance, array('title'=>'', 'lineOne'=>'Hello', 'lineTwo'=>'World'));
        
        $title = htmlspecialchars($instance['title']);
        $lineOne = htmlspecialchars($instance['lineOne']);
        $lineTwo = htmlspecialchars($instance['lineTwo']);
        
        # Output the options
        echo '<p style="text-align:right;"><label for="'.$this->get_field_name('title').'">'.__('Title:').' <input style="width: 250px;" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.$title.'" /></label></p>';
        # Text line 1
        echo '<p style="text-align:right;"><label for="'.$this->get_field_name('lineOne').'">'.__('Line 1 text:').' <input style="width: 200px;" id="'.$this->get_field_id('lineOne').'" name="'.$this->get_field_name('lineOne').'" type="text" value="'.$lineOne.'" /></label></p>';
        # Text line 2
        echo '<p style="text-align:right;"><label for="'.$this->get_field_name('lineTwo').'">'.__('Line 2 text:').' <input style="width: 200px;" id="'.$this->get_field_id('lineTwo').'" name="'.$this->get_field_name('lineTwo').'" type="text" value="'.$lineTwo.'" /></label></p>';
    }
    
}// END class


?>

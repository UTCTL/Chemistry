<?php
if( !class_exists( 'Events_List_Widget' ) ) {
	/**
	 * Event List Widget
	 *
	 * Creates a widget that displays the next upcoming x events
	 */

	class Events_List_Widget extends WP_Widget {
		
		public $pluginDomain = 'the-events-calendar';
		
		function Events_List_Widget() {
				/* Widget settings. */
				$widget_ops = array( 'classname' => 'eventsListWidget', 'description' => __( 'A widget that displays the next upcoming x events.', $this->pluginDomain) );

				/* Widget control settings. */
				$control_ops = array( 'id_base' => 'events-list-widget' );

				/* Create the widget. */
				$this->WP_Widget( 'events-list-widget', 'Events List Widget', $widget_ops, $control_ops );
			}
		
			function widget( $args, $instance ) {
				global $wp_query;
				extract( $args );

				/* User-selected settings. */
				$title = apply_filters('widget_title', $instance['title'] );
				$limit = $instance['limit'];
				$noUpcomingEvents = $instance['no_upcoming_events'];
				$start = $instance['start'];
				$startTime = $instance['start-time'];
				$end = $instance['end'];
				$endTime = $instance['end-time'];
				$venue = $instance['venue'];
				$address = $instance['address'];
				$city = $instance['city'];
				$state = $instance['state'];
				$province = $instance['province'];
				$zip = $instance['zip'];
				$country = $instance['country'];
				$phone = $instance['phone'];
				$cost = $instance['cost'];
				
				if ( eventsGetOptionValue('viewOption') == 'upcoming') {
					$event_url = events_get_listview_link();
				} else {
					$event_url = events_get_gridview_link();
				}
				
				if( function_exists( 'get_events' ) ) {
					$old_display = $wp_query->get('eventDisplay');
					$wp_query->set('eventDisplay', 'upcoming');
					$posts = get_events($limit, The_Events_Calendar::CATEGORYNAME);
				}
				
				/* Before widget (defined by themes). */
				/* Title of widget (before and after defined by themes). */
				if ( $title && !$noUpcomingEvents ) echo $before_widget . $before_title . $title . $after_title;
					
				if( $posts ) {
					/* Display list of events. */
						if( function_exists( 'get_events' ) ) {
							echo '<ul class="upcoming">';
							$templateOverride = locate_template( array( 'events/events-list-load-widget-display.php' ) );
							$templateLoc = $templateOverride ? $templateOverride : dirname( __FILE__ ) . '/views/events-list-load-widget-display.php';
							foreach( $posts as $post ) {
								setup_postdata($post);
								include( $templateLoc );
							}
							echo "</ul>";

							$wp_query->set('eventDisplay', $old_display);
						}
					
						/* Display link to all events */
						echo '<div class="dig-in"><a href="' . $event_url . '">' . __('View All Events', $this->pluginDomain ) . '</a></div>';
				} else if( !$noUpcomingEvents ) _e('There are no upcoming events at this time.', $this->pluginDomain);

				/* After widget (defined by themes). */
				if ( !$noUpcomingEvents ) echo $after_widget;
			}	
		
			function update( $new_instance, $old_instance ) {
					$instance = $old_instance;

					/* Strip tags (if needed) and update the widget settings. */
					$instance['title'] = strip_tags( $new_instance['title'] );
					$instance['limit'] = strip_tags( $new_instance['limit'] );
					$instance['no_upcoming_events'] = strip_tags( $new_instance['no_upcoming_events'] );
					$instance['start'] = strip_tags( $new_instance['start'] );
					if( $instance['start'] == 'on' ) $instance['start-time'] = strip_tags( $new_instance['start-time'] );
					else $instance['start-time'] = '';
					$instance['end'] = strip_tags( $new_instance['end'] );
					if( $instance['end'] == 'on' ) $instance['end-time'] = strip_tags( $new_instance['end-time'] );
					else $instance['end-time'] = '';
					$instance['venue'] = strip_tags( $new_instance['venue'] );
					$instance['country'] = strip_tags( $new_instance['country'] );
					$instance['address'] = strip_tags( $new_instance['address'] );
					$instance['city'] = strip_tags( $new_instance['city'] );
					$instance['state'] = strip_tags( $new_instance['state'] );
					$instance['province'] = strip_tags( $new_instance['province'] );
					$instance['zip'] = strip_tags( $new_instance['zip'] );
					$instance['phone'] = strip_tags( $new_instance['phone'] );
					$instance['cost'] = strip_tags( $new_instance['cost'] );

					return $instance;
			}
		
			function form( $instance ) {
				/* Set up default widget settings. */
				$defaults = array( 'title' => 'Upcoming Events', 'limit' => '5', 'start' => 'on', 'start-time' => '','end' => '', 'end-time' => '', 'venue' => '', 'country' => 'on', 'address' => '', 'city' => 'on', 'state' => 'on', 'province' => 'on', 'zip' => '', 'phone' => '', 'cost' => '');
				$instance = wp_parse_args( (array) $instance, $defaults );			
				include( dirname( __FILE__ ) . '/views/events-list-load-widget-admin.php' );
			}
	}

	/* Add function to the widgets_ hook. */
	add_action( 'widgets_init', 'events_list_load_widgets' );

	/* Function that registers widget. */
	function events_list_load_widgets() {
		global $pluginDomain;
		register_widget( 'Events_List_Widget' );
		// load text domain after class registration
		load_plugin_textdomain( $pluginDomain, false, basename(dirname(__FILE__)) . '/lang/');
	}
}
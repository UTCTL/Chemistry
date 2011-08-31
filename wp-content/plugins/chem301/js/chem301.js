
(function($) {
    
    /*
    if (typeof home_page !== "undefined") {
    
        Shadowbox.init({
            overlayOpacity: 0.8,
            onChange: function(x) {
                window.location.hash = x.content.split('/lecture/')[1];
            }
        }, function(){
            var items = $('a.level2a');
            Shadowbox.setup(items, {
                players:  ['html', 'iframe']
            });
        }
        );
    
        $(window).load(function() {
            if (hash = window.location.hash) {
                Shadowbox.open($(hash).get(0));
            }
        });
        
        $('#units li ul li a').bind('click',function(e){
            $.scrollTo('0px');
            e.preventDefault();
            window.location.hash = $(this).attr('id');
            return false;
        });
    
    }
    */
    
    if (typeof search_page !== "undefined") {
    
        Shadowbox.init({
            overlayOpacity: 0.8,
            onChange: function(x) {
                window.location.hash = x.content.split('/lecture/')[1];
            }
        }, function(){
            var items2 = $('a.entry-title');
            Shadowbox.setup(items2, {
                players:  ['html', 'iframe']
            });
        }
        );
    
        $(window).load(function() {
            if (hash = window.location.hash) {
                Shadowbox.open($(hash).get(0));
            }
        });
        
        $('#units li ul li a').bind('click',function(e){
            $.scrollTo('0px');
            e.preventDefault();
            window.location.hash = $(this).attr('id');
            return false;
        });
    
    }
    
    else if (typeof module_page !== 'undefined') {
        
    	$(document).ready( function() {
            
            $('.show_hide').bind('click',function(){
               $(this).parent().parent().find('.question_A').animate({ 
                   opacity:'toggle',
                   height:'toggle'
               },300);
            });

    	});
	
    }
    
    else if (typeof cal_lectures !== 'undefined') {

        /*
        // eval new Date objects.
        for (i=0;i<cal_lectures.length;i+=1) {
            cal_lectures[i].start = eval(cal_lectures[i].start);
        }

        var current_button = 0;

        var showMonth = function(view) {
            if (showLectures)
                showLectures(current_button);
        };

        // init calendar
        jQuery('#calendar').fullCalendar({
            header: {
        		left: 'prev,next today',
        		center: 'title',
        		right: 'month'
        	},
    		editable: false,
            events: cal_lectures,
            viewDisplay: showMonth,
            eventClick: function(calEvent, jsEvent, view) {
                jQuery(this).attr('href', calEvent.url.replace('/lecture/','/#'));
            }
        });

        // hide all lectures
        jQuery('.custom_lecture').hide();

        // get our button to clone, and remove it from display.
        $button = jQuery('.fc-button-month').remove().removeClass('fc-button-month fc-state-active fc-corner-left fc-corner-right');

        // show all lectures associated with this button.
        var showLectures = function(button) {
            current_button = button;
            user_name = button.data('user_name');
            jQuery('.custom_lecture').hide();
            jQuery('.user_'+user_name).show();
            jQuery('.fc-button').removeClass('fc-state-active');
            jQuery(button).addClass('fc-state-active');
        }

        // init buttons, bind onClick functions, put them on page
        for (user_name in cal_users) {
            display_name = cal_users[user_name];
            user_button = $button.clone();
            user_button.find('.fc-button-content').text(display_name);
            user_button.data('user_name',user_name);
            user_button.addClass('user-'+user_name+'-button');
            user_button.bind({
                click: function(){
                    showLectures(jQuery(this));
                },
                mouseover: function(){
                    jQuery(this).addClass('fc-state-hover');
                },
                mouseleave: function(){
                    jQuery(this).removeClass('fc-state-hover');
                } 
            });
            jQuery('.fc-header-right').append(user_button);
        }

        // init the first set of lectures
        for (user_name in cal_users) {
            showLectures(jQuery('.user-'+user_name+'-button'));
            break;
        }
        */
    }

})(jQuery);


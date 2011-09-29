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
    
    if (typeof module_page !== 'undefined') {
        
    	$(document).ready( function() {
	    
            var expand = function($li,oembed) {
                $thumb = $li.find('a.embedly img');
                $caption = $li.find('.caption');
                $thumb.animate({
                    width:oembed.width+'px',
                    height:oembed.height+'px'
                },function(){
                    $thumb.replaceWith(oembed['code']);
                });
                $caption.animate({
                    'font-size':'14px',
                    'width':(oembed.width - 50) + 'px',
                    'padding':'10px'
                });
                $li.data('expanded',true);
            };
        
            var minimize = function($li,oembed) {
                ratio = 190/oembed.thumbnail_width;
                $li.find('a.embedly .embed').replaceWith("<img style=\"width:"+oembed.width+"px;height:"+oembed.height+"px\" src=\""+oembed.thumbnail_url+"\" />");
                $li.find('a.embedly img').animate({
                    width:'190px',
                    height:(ratio*oembed.thumbnail_height)+'px'
                });
                $li.find('.caption').animate({
                    'font-size':'10px',
                    'width':'154px',
                    'padding':'5px'
                });
                $li.data('expanded',false);
            };

            var embedly_callback = function(oembed, dict) {
                if (oembed == null)
                    return;
                if (oembed.type === 'link')
                    embedly_link_callback(oembed, dict);
                else if (oembed.type === 'video')
                    embedly_video_callback(oembed, dict);
            };

            var embedly_video_callback = function(oembed, dict) {
                _img = $("<img src='"+oembed.thumbnail_url+"' />");
                _expand = $("<span class=\"expand\"></span>").click(function(e){
                    e.preventDefault();
                    $li = $(this).parent();
                    if ($li.data('expanded'))
                        minimize($li,oembed);
                    else    
                        expand($li,oembed);
                });
                _title = $("<span class=\"caption\">"+oembed.title+"</span>");
            	
            	$a = $(dict["node"]).click(function(e){
                        e.preventDefault();
                        $li = $(this).parent();
                        if ($(this).data('expanded'))
                            minimize($li,oembed);
                        else
                            expand($li,oembed);
                    })
            	    .addClass('video embedly')
            	    .append(_img)
            	    .wrap('<div class="video_container"></div>');
            	$a.parent()
        	        .append(_expand,_title)
        	        .next('br').replaceWith('');
            	$p = $a.parent().parent();
            	if (($ex = $p.find('.external_resources')).length <= 0) {
            	    $ex = $('<ul class="external_resources">External Resources</ul>');
            	    $p.append($ex);
            	}
            	$ex.append('<li><a href="'+oembed.url+'">'+oembed.url+'</a></li>');
            };

            var embedly_link_callback = function(oembed, dict) {
                $a = $(dict["node"]);
                $a.next('br').replaceWith('');
            	$p = $a.parent().parent();
            	if (($ex = $p.find('.external_resources')).length <= 0) {
            	    $ex = $('<ul class="external_resources">External Resources</ul>');
            	    $p.append($ex);
            	}
            	$ex.append('<li><a href="'+oembed.url+'">'+oembed.url+'</a></li>');
            };

            var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
            $desc = $('#description .module_block');
            $.each($desc,function(i,el){
                $el = $(el);
                $html = $el.html();
                $el.html($html.replace(exp,'<a href="$1"></a>'));
            });
            
            $('#description .module_block a').embedly({key:'92481528b30711e0adda4040d3dc5c07'}, embedly_callback);
            
            $('.show_hide').bind('click',function(){
               $(this).parent().parent().find('.question_A').animate({ 
                   opacity:'toggle',
                   height:'toggle'
               },300);
            });
            

    	});
	
    }
})(jQuery);
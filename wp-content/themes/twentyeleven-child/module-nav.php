<style>

#module-nav {
    padding: 1em;
    margin:0;
    background-color: rgba(255, 255, 255, .15);
    box-shadow:0 0 22px rgba(0,0,0,0.5);
    border-radius: 1.5em 0 1em 0;
    position: relative;
    z-index:999;
    width: 14em;
    float: left;
    list-style:none;
}
    #module-nav > li:first-child {
        margin-top:0;
    }
    #module-nav > li {
        font-size:1.2em;
        margin-top:0.5em;
    }
        #module-nav > li > ul {
            margin: 0 0 0 1em;
        }
            #module-nav > li > ul > li {
                font-size:0.75em;
                line-height:1.4em;
            }
    #module-nav a {
        color:#FFF;
        font-size:0.9em;
    }
    
    #module-nav p {
    	color: rgba(255, 255, 255, 0.3);
    	font-size:0.9em;
    	margin-bottom: 0px;
    }
    
    #module-nav a.current_page {
        color:#EBA711;
        text-decoration:underline   ;
    }
    
</style>

<ul id="module-nav">
    <?php
    $units = get_posts( array('post_type' => 'unit','orderby'=>'menu_order','order'=>'ASC') );
    foreach ($units as $unit) :
        if ($post->ID == $unit->ID) {
            $current = 'class="current_page" ';
        } else {
            $current = '';
        }
        ?>

        <li>
            <a <?php echo $current; ?>href="<?php echo $unit->guid; ?>"><?php echo $unit->post_title; ?></a>
            <ul>
            <?php
            $modules = get_children( array('post_parent' => $unit->ID, 'post_type' => 'module','orderby'=>'menu_order','order'=>'ASC') );
            foreach ($modules as $module) :
                if ($post->ID == $module->ID) {
                    $current = 'class="current_page" ';
                } else {
                    $current = '';
                }
                
                $status = get_post_meta($module->ID, 'enable_module');
			
			if($status[0] == '1' || $status[0] == 'enable')
			{
				?>
				<li><a <?php echo $current; ?>href="<?php echo $module->guid; ?>"><?php echo $module->post_title; ?></a></li>
				<?php
			}
			
			else
			{
				?>
				<li><p><?php echo $module->post_title; ?></p></li>
				<?php
			}
				
                ?>
        
            <?php endforeach; ?>
            </ul>
        </li>
    
    <?php endforeach;?>
</ul>
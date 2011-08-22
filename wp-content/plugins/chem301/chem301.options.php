<style>

.placeholder {
	background-color: #cfcfcf;
}

.actions {
    margin:2em 0;
}
    .actions .disabled {
        cursor:default;
    }
    .actions .saved_icon {
        vertical-align: bottom;
        height: 23px;
    }

.ui-nestedSortable-error {
	background:#fbe3e4;
	color:#8a1f11;
}

ol {
	margin: 0;
	padding: 0;
	padding-left: 30px;
}

ol.sortable, ol.sortable ol {
	margin: 0 0 0 50px;
	padding: 0;
	list-style-type: none;
}

ol.sortable {
	margin: 2em 0;
	width: 400px;
    display: block;
}

.sortable li {
	margin: 7px 0 0 0;
	padding: 0;
}

.sortable li div  {
    color:#FFFFFF;
	padding: 3px;
	margin: 0;
	cursor: move;
}

li.unit div {
    border: 1px solid rgba(0,0,0,1.00);
    background-color:rgba(0,0,0,0.3);
    color:rgba(0,0,0,1.00);
}

li.module div {
    border: 1px solid rgba(0,0,0,0.75);
    background-color:rgba(0,0,0,0.2);
    color:rgba(0,0,0,0.90);
}

li.submodule div {
    border: 1px solid rgba(0,0,0,0.50);
    background-color:rgba(0,0,0,0.1);
    color:rgba(0,0,0,0.80);
}

</style>

<div class="wrap">
    <div id="icon-options-general" class="icon32"><br /></div>
    <h2>Chem 301: Site Settings</h2>
    <form action="" method="">
        <?php wp_nonce_field('update-options'); ?>

        <input type="hidden" name="action" value="update" />
        <div class="actions">
            <input type="submit" disabled="true" class="button-primary save_ordering disabled" value="Save Ordering" />
            <img class="saved_icon" src="<?php echo WP_PLUGIN_URL; ?>/chem301/img/saved.gif" />
        </div>

        <?php 
            if( function_exists( 'get_posts' ) ) : ?>
            
            <?php 
                $units = get_posts(array('post_type'=>'unit','numberposts'=>-1,'orderby'=>'menu_order','order'=>'ASC'));
                $x = 0;
                            
                if ($units && count($units) > 0) {        
                    echo '<ol class="sortable">';
                    
                    for ($i = 0; $i < count($units); $i += 1) {
                        $unit = $units[$i];
                        
                        echo '<li id="list_'.$unit->ID.'" class="unit">';
                        echo    '<div>'.$unit->post_title.'</div>';
                        
                            $modules = get_posts(array('post_type'=>'module','numberposts'=>-1,'orderby'=>'menu_order','order'=>'ASC','post_parent'=>$unit->ID));
                            
                            if ($modules && count($modules) > 0) {
                                echo '<ol>';
                                
                                for ($j = 0; $j < count($modules); $j += 1) {
                                    $module = $modules[$j];
                                
                                    echo '<li id="list_'.$module->ID.'" class="module">';
                                    echo    '<div>'.$module->post_title.'</div>';
                                    
                                        $submodules = get_posts(array('post_type'=>'submodule','numberposts'=>-1,'orderby'=>'menu_order','order'=>'ASC','post_parent'=>$module->ID));
                                        
                                        if ($submodules && count($submodules) > 0) {
                                            echo '<ol>';
                                            
                                            for ($k = 0; $k < count($submodules); $k += 1) {
                                                $submodule = $submodules[$k];
                                                
                                                echo '<li id="list_'.$submodule->ID.'" class="submodule no-nest">';
                                                echo    '<div>'.$submodule->post_title.'</div>';
                                                echo '</li>';
                                            }
                                            
                                            echo '</ol>';
                                        }
                                    
                                    echo '</li>';
                                }
                                
                                echo '</ol>';
                            }
                        
                        echo '</li>';
                    }
                    
                    echo '</ol>';
                }
                
            endif;
        ?>
        
        <div class="actions">
            <input type="submit" disabled="true" class="button-primary save_ordering disabled" value="Save Ordering" />
            <img class="saved_icon" src="<?php echo WP_PLUGIN_URL; ?>/chem301/img/saved.gif" />
        </div>
    </form>
</div>
<?php

    global $fs_page_url;
    $box = $this->last_input;
    ?>
    <form method="post" action="<?php echo $page_url; ?>">
      <?php show_nonce(); ?>
      <input type="hidden" id='tab' name='tab' value='boxes' />
      <input type="hidden" id='action' name='action' value='<?php echo ACT_EDIT_BOX; ?>' />
      <input type="hidden" id='item' name='item' value='<?php echo $box['item']; ?>' />
      
      <table class="form-table">
        <tbody>
        
        <tr>
    			<th valign="top" scope="row"><label for="tag-key"><?php _e('Key', 'Fields'); ?></label></th>
    			<td><input type="text" aria-required="true" size="40" value="<?php echo $box['key'] ?>" id="tag-key" name="key" />
    			<p class="description"><?php _e('Keys should be in lowercase and contain only alphabet, numbers and dashes "-"', 'Fields'); ?></p></td>
    		</tr> 
    		
        <tr>
    			<th valign="top" scope="row"><label for="tag-title"><?php _e('Title', 'Fields'); ?></label></th>
    			<td><input type="text" aria-required="true" size="40" value="<?php echo $box['title']; ?>" id="tag-title" name="title" />
          </td>
    		</tr> 

        <tr>
    			<th valign="top" scope="row"><label for="tag-position"><?php _e('Position', 'Fields'); ?></label></th>
    			<td>
    		    <?php $this->list_position($box['position']); ?>
      		</td>
    		</tr>
    		    		
        <!--<tr>
    			<th valign="top" scope="row"><label for="tag-description"><?php _e('Description', 'Fields'); ?></label></th>
    			<td><textarea style="width: 50%;" rows="5" id="tag-description" name="description"><?php echo $box['description']; ?></textarea></td>
    		</tr>-->
    		        
        <tr>
    			<th valign="top" scope="row"><label for="groups"><?php _e('Included groups', 'Fields'); ?></label></th>
    			<td><?php $this->list_groups(is_array($box['groups'])?$box['groups']:0); ?>
    			<p class="description"><?php _e('Select which groups are included in your box', 'Fields'); ?></p></td>
    		</tr>      		

        <tr>
    			<th valign="top" scope="row"><label for="post_types"><?php _e('Supported post types', 'Fields'); ?></label></th>
    			<td>
    			 <?php $this->list_post_types(is_array($box['post_types'])?$box['post_types']:0); ?>	
      			<p class="description"><?php _e('Select which post types are supported by your box', 'Fields'); ?></p>
      			<label for='tag-include'><?php _e('Include', 'Fields'); ?></label><br />
      			<input type='text' size='60' name='include' id='tag-include' value='<?php echo $box['include'];?>'></input>
      			<p class='description'><?php _e('Include these posts (comma separated list of posts IDs)', 'Fields'); ?></p>
      			<label for='tag-exclude'><?php _e('Exclude', 'Fields'); ?></label><br />
      			<input type='text' size='60' name='exclude' id='tag-exclude' value='<?php echo $box['exclude'];?>'></input>
      			<p class='description'><?php _e('Exclude these posts (comma separated list of posts IDs)', 'Fields'); ?></p>
    			</td>
    		</tr>

        </tbody>
      </table>
      <p><input class="button-primary" type="submit" value="<?php _e('Update Box' ,'fields'); ?>" /></p>
    </form>
    <?php 

?>
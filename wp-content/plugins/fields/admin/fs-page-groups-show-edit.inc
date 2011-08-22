<?php
    global $fs_page_url;
    $group = $this->last_input;
    ?>
    <form method="post" action="<?php echo $fs_page_url; ?>">
      <?php show_nonce(); ?>
      <input type="hidden" id='tab' name='tab' value='groups' />
      <input type="hidden" id='action' name='action' value='<?php echo ACT_EDIT_GROUP; ?>' />
      <input type="hidden" id='item' name='item' value='<?php echo $group['item']; ?>' />
      
      <table class="form-table">
        <tbody>
        
        <tr>
    			<th valign="top" scope="row"><label for="tag-group-key"><?php _e('Key', 'Fields'); ?></label></th>
    			<td><input type="text" aria-required="true" size="40" value="<?php echo $group['key']; ?>" id="tag-group-key" name="key" />
    			<p class="description"><?php _e('Keys should be in lowercase and contain only alphabet, numbers and dashes "-".', 'Fields'); ?></p></td>
    		</tr> 
    		
        <tr>
    			<th valign="top" scope="row"><label for="tag-group-title"><?php _e('Title', 'Fields'); ?></label></th>
    			<td><input type="text" aria-required="true" size="40" value="<?php echo $group['title']; ?>" id="tag-group-title" name="title" />
          </td>
    		</tr> 
    		
        <tr>
    			<th valign="top" scope="row"><label for="tag-group-order"><?php _e('Order', 'Fields'); ?></label></th>
    			<td><input type="text" aria-required="true" size="40" value="<?php echo $group['order']; ?>" id="tag-group-order" name="order" />
          </td>
    		</tr>
    		
        <tr>
    			<th valign="top" scope="row"><label for="tag-group-layout"><?php _e('Layout', 'Fields'); ?></label></th>
    			<td>
    		    <?php $this->show_layout($group['layout']); ?>
          </td>
    		</tr>

        <!--<tr>
    			<th valign="top" scope="row"><label for="tag-group-description"><?php _e('Description', 'Fields'); ?></label></th>
    			<td><textarea style="width: 50%;" rows="5" id="tag-group-description" name="description"><?php echo $group['description']; ?></textarea>
    		</tr>-->

        </tbody>
      </table>
      <p><input class="button" type="submit" value="<?php _e('Update Group' ,'fields'); ?>" /></p>
    </form>
    <?php
    $this->show_group_fields($group);
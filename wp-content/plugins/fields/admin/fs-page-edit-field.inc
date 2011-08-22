<?php

   $field = $this->last_input;
   $group = $field['group'];
    ?>
    <form method="post" action="<?php echo $page_url; ?>">
      <?php show_nonce(); ?>
      <input type="hidden" id='tab' name='tab' value='groups' />
      <input type="hidden" id='action' name='action' value='<?php echo ACT_EDIT_FIELD; ?>' />
      <input type="hidden" id='item' name='item' value='<?php echo $field['item']; ?>' />
      <input type="hidden" id='sub_item' name='sub_item' value='<?php echo $field['sub_item']; ?>' />
      
      <table class="form-table">
      <tbody>
        <tr>
      		<th valign="top" scope="row"><label for="tag-group-key"><?php _e('Key'); ?></label></th>
      		<td><input type="text" aria-required="true" value="<?php echo $field['key'] ?>" id="tag-key" name="key" />
      		<p class="description"><?php _e('A field key must be unique within its group and should be in lowercase and contain only alphabet, numbers and dashes "-".', 'Fields'); ?></p></td>
      	</tr>
      	
        <tr>
      		<th valign="top" scope="row"><label for="tag-group-title"><?php _e('Title'); ?></label></th>
      		<td><input type="text" aria-required="true" value="<?php echo $field['title']; ?>" size="40" id="tag-title" name="title" /></td>
      	</tr>

        <tr>
      		<th valign="top" scope="row"><label for="tag-group-title"><?php _e('Note'); ?></label></th>
      		<td><input type="text" aria-required="true" value="<?php echo $field['note']; ?>" size="40" id="tag-note" name="note" /></td>
      	</tr>
      	
        <tr>
      		<th valign="top" scope="row"><label for="tag-order"><?php _e('Order'); ?></label></th>
      		<td><input type="text" aria-required="true"  value="<?php echo $field['order']; ?>" id="tag-order" name="order" /></td>
      	</tr>
      	
        <tr>
      		<th valign="top" scope="row"><label for="tag-type"><?php _e('Type'); ?></label></th>
      		<td><?php $this->show_type_select($field['type']); ?></td>
      	</tr>

        <!-- Additional -->
        <?php
          foreach (FS_FieldTypes::instance()->get_types() as $field_type)
          {
            $field_type->show_options($field);
          }
        ?> 		
      	
      </tbody>
      </table>
      
      <p class="submit"><input class="button" type="submit" value="<?php _e('Update Field' ,'fields'); ?>" />
      <a class="back-link" href="<?php echo build_group_url($group, ACT_EDIT_GROUP); ?>"><?php printf('Back to %1$s', $group['title']); ?></a>
      </p>
    </form>
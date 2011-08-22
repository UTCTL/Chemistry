    <!-- add box form -->      
    <div id="col-left">
      <div class="col-wrap">
      <div class="form-wrap">
        <h3><?php _e('Add New Box'); ?></h3>
        <form method="post" action=<?php global $fs_page_url; echo $fs_page_url; ?>>
          <?php show_nonce(); ?>
          <input type="hidden" id="tab" name="tab" value="boxes"/>
      		<input type="hidden" id="action" name="action" value="<?php echo ACT_ADD_BOX; ?>" />
          <div class="form-field form-required">
          	<label for="tag-key"><?php _e('Key', 'Fields'); ?></label>
          	<input type="text" aria-required="true" value="<?php echo $this->last_input['key']; ?>" id="tag-key" name="key" autofocus="yes" />
          	<p>Keys should be in lowercase and contain only alphabet, numbers and dashes '-'.</p>
          </div>        		
    
          <div class="form-field form-required">
          	<label for="tag-title"><?php _e('Title', 'Fields'); ?></label>
          	<input type="text" aria-required="true" value="<?php echo $this->last_input['title']; ?>" id="tag-title" name="title"/>
          </div>        		

          <div class="form-field">
          	<label for="tag-position"><?php _e('Position', 'Fields'); ?></label>
          	<?php $this->list_position(); ?>
          	<p></p>
          </div>
          
          <div class="form-field">
          	<label for="tag-groups"><?php _e('Included groups', 'Fields'); ?></label>
          	<?php $this->list_groups(is_array($this->last_input['groups'])?$this->last_input['groups']:0); ?>
          	<p>Select which groups are included in your box</p>
          </div>            
    
          <div class="form-field">
          	<label for="tag-post-types"><?php _e('Supported post types', 'Fields'); ?></label>
          	<?php $this->list_post_types(is_array($this->last_input['post_types'])?$this->last_input['post_types']:0); ?>
          	<p><?php _e('Select which post types are supported by your box', 'Fields'); ?></p>
      			<label for='tag-include'><?php _e('Include', 'Fields'); ?></label>
      			<input type='text' size='60' name='include' id='tag-include' value='<?php echo $box['include'];?>'></input>
      			<p class='description'><?php _e('Include these posts (comma separated list of posts IDs)', 'Fields'); ?></p>
      			<label for='tag-exclude'><?php _e('Exclude', 'Fields'); ?></label>
      			<input type='text' size='60' name='exclude' id='tag-exclude' value='<?php echo $box['exclude'];?>'></input>
      			<p class='description'><?php _e('Exclude these posts (comma separated list of posts IDs)', 'Fields'); ?></p>          	
          </div>            

          <!--<div class="form-field">
          	<label for="tag-description"><?php _e('Description', 'Fields'); ?></label>
          	<textarea rows="5" id="tag-description" name="description"><?php echo $this->last_input['description']; ?></textarea>
          	<p></p>
          </div>-->
      			    
      		<p><input class="button" type="submit" value="<?php _e('Add New Box' ,'fields'); ?>"/></p>
      	</form>
      </div><!-- form-wrap -->
      </div><!-- col-wrap -->
    </div><!-- col-left -->
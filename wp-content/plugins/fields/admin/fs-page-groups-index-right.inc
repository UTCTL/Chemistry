    <!-- add group form -->      
    <div id="col-left">
      <div class="col-wrap">
      <div class="form-wrap">
        <h3><?php _e('Add New Group'); ?></h3>
        <form method="post" action=<?php global $fs_page_url; echo $fs_page_url; $group = $this->last_input; ?>>
          <?php show_nonce(); ?>
          <input type="hidden" id="tab" name="tab" value="groups"/>
      		<input type="hidden" id="action" name="action" value="<?php echo ACT_ADD_GROUP; ?>"/>
          <div class="form-field form-required">
          	<label for="tag-key"><?php _e('Key', 'Fields'); ?></label>
          	<input type="text" aria-required="true" value="" id="tag-key" name="key" value="<?php echo $group['key']; ?>" autofocus="yes" />
          	<p><?php _e('Keys should be in lowercase and contain only alphabet, numbers and dashes "-".', 'Fields'); ?></p>
          </div>        		
    
          <div class="form-field form-required">
          	<label for="tag-title"><?php _e('Title', 'Fields'); ?></label>
          	<input type="text" aria-required="true" value="<?php echo $group['title']; ?>" id="tag-title" name="title"/>
          </div>

          <div class="form-field form-required">
          	<label for="tag-order"><?php _e('Order', 'Fields'); ?></label>
          	<input type="text" aria-required="true" value="<?php echo isset($group['order'])?$group['order']:0; ?>" id="tag-order" name="order"/>
          	<p><?php _e('Smallest values stay on top', 'Fields'); ?></p>
          </div>
          
          <div class="form-field form-required">
          	<label for="tag-order"><?php _e('Layout', 'Fields'); ?></label>
          	<?php $this->show_layout($group['layout']); ?>
          	<p><?php _e('The one-column layout has labels on top of the fields instead of on the left', 'Fields'); ?></p>
          </div>          
          
          <!--<div class="form-field form-required">
          	<label for="tag-description"><?php _e('Description', 'Fields'); ?></label>
          	<textarea rows="5" id="tag-description" name="description"><?php echo $group['description']; ?></textarea>
          	<p></p>
          </div>-->

      		<p><input class="button-primary" type="submit" value="<?php _e('Add New Group' ,'fields'); ?>"/></p>
      	</form>
      </div><!-- form-wrap -->
      </div><!-- col-wrap -->
    </div><!-- col-left -->
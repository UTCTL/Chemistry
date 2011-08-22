    <div id="col-right">
      <div class="col-wrap">
      <table class="widefat need-pad">
        <thead>
          <?php $this->show_table_header(); ?>
        </thead>
        
        <tbody>
          <?php $this->show_groups(); ?>
        </tbody>
        
        <tfoot>
          <?php $this->show_table_header(); ?>
        </tfoot>
      </table>
      <p><?php _e('Groups are sets of fields that can be included in boxes. Groups are displayed as tabs in boxes.'); ?></p>
      </div>
    </div>
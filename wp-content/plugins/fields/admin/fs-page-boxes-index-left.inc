    <div id="col-right">
      <div class="col-wrap">
      <table class="widefat need-pad">
        <thead>
          <?php $this->show_table_header(); ?>
        </thead>
        
        <tbody>
          <?php $this->show_boxes(); ?>
        </tbody>
        
        <tfoot>
          <?php $this->show_table_header(); ?>
        </tfoot>
      </table>
      <p><?php _e('Boxes can include groups and support a number of selected post types'); ?></p>
      </div>
    </div>
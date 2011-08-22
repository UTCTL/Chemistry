jQuery(document).ready(function() {

    $date_text     = jQuery('#date_selected'),
    $lecture_month = jQuery('#lecture_month'),
    $lecture_day   = jQuery('#lecture_day'),
    $lecture_year  = jQuery('#lecture_year');
    $lecture_date  = jQuery('#lecture_date');
    _date = new Date($lecture_date.val());
    
    if (($date_picker = jQuery('#chem301_datepicker')).length > 0) {
        $date_picker.datepicker({
                onSelect: function(dateText, inst) {
                    _selected_date = new Date(dateText).toLocaleDateString();
                    $date_text.text(_selected_date);
                    $lecture_month.val(inst.selectedMonth);
                    $lecture_day.val(inst.selectedDay);
                    $lecture_year.val(inst.selectedYear);
                    $lecture_date.val(dateText);
                }
            }).datepicker('setDate',_date);
    }
    
    $list = jQuery('ol.sortable').nestedSortable({
    			disableNesting: 'no-nest',
    			forcePlaceholderSize: true,
    			handle: 'div',
    			helper:	'clone',
    			items: 'li',
    			maxLevels: 3,
    			opacity: .6,
    			placeholder: 'placeholder',
    			revert: 250,
    			tabSize: 20,
    			tolerance: 'pointer',
    			toleranceElement: '> div'
    		});
    
    jQuery('.save_ordering').bind('click',function(e){
        e.preventDefault();
        jQuery('.save_ordering').each(function(i,el){
            jQuery(this).attr('disabled','true').removeClass('disabled');
        });
        data = {
            action: 'update_module_ordering',
            posts: $list.nestedSortable('toArray', {startDepthCount: 0})
        };
        if (data.posts) {
            jQuery.post(fsAjax.url, data, function(response,result,info) {
                if (result == 'success') {
                    jQuery('.saved_icon').each(function(i,el){
                        jQuery(el).show();
                    });
                } else {
                    jQuery('.save_ordering').each(function(i,el){
                        jQuery(el).removeAttr('disabled').removeClass('disabled');
                    });
                }
            });
        }
    });
    jQuery('.sortable').bind('click',function(e){
        jQuery('.save_ordering').each(function(i,el){
            jQuery(el).removeAttr('disabled').removeClass('disabled');
        });
        jQuery('.saved_icon').each(function(i,el){
            jQuery(el).hide();
        });
    });
    
});
"use strict";

var focusID = null;

jQuery(":input").focus(function () {
  focusID = this.id;
});

function supports_input_autofocus() 
{
  var i = document.createElement('input');
  return 'autofocus' in i;
}

function showAdditionals()
{
  if (typeof(calce_types) != "undefined")
  {
    var value = jQuery("#tag-field-type").val();
    jQuery(".additional").hide();
    jQuery('.' + calce_types[value]).show();
    
    jQuery('table.form-table tr:visible:even').addClass('even');
    jQuery('table.form-table tr:visible:odd').addClass('odd'); 
  }
}

jQuery(document).ready(function($)
{
  if (!supports_input_autofocus())
  {
    if (focusID === null)
    {
      $('input[autofocus="yes"]').focus();
    }
  }

  showAdditionals();  
  jQuery("#tag-field-type").change(function(e) {
    showAdditionals();     
  });

  jQuery('.error, .updated').live('click', function(){
    jQuery(this).fadeOut('fast');
  });
  
});
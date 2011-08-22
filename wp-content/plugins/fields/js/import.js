function addPreviewTables(data)
{
  var index = 1;
  var tbody = jQuery('#fs-preview-boxes > tbody');
  tbody.children().remove();
  var rowClass;
  
  if (data.ok == true)
  {    
    jQuery('#fs-preview-row').show();
    
    if (data.preview.boxes)
    {      
      jQuery.each(data.preview.boxes, function(i,item)
      {
        if (index == 1)
          rowClass = " class='alternate'";
        else
          rowClass = '';
        index = 3 - index;
        tbody.append('<tr' + rowClass + '>' +
          '<td>' + item.action + '</td>' +
          '<td>' + item.key + '</td>' +
          '<td>' + item.title + '</td>' +
          '<td>' + item.groups + '</td>' +
          '<td>' + item.post_types + '</td>'
        );
      });
    }
    
    index = 1;
    tbody = jQuery('#fs-preview-groups > tbody');
    tbody.children().remove();
    if (data.preview.groups)
    {
      jQuery.each(data.preview.groups, function(i,item)
      {
        if (index == 1)
          rowClass = " class='alternate'";
        else
          rowClass = '';
        index = 3 - index;
        tbody.append('<tr' + rowClass + '>' +
          '<td>' + item.action + '</td>' +
          '<td>' + item.key + '</td>' +
          '<td>' + item.title + '</td>' +
          '<td>' + item.order + '</td>' +
          '<td>' + item.fields + '</td>'
        );
      });
    }
  }
  else
  {
    jQuery('.wrap.nosubsub h3').before("<div class='error below-h2'><p>" + data.message + "</p></div>");
  }
}

jQuery(document).ready(function($)
{

  $('#fs-preview').click(function(event)
  {
    if (!$(this).hasClass('disabled'))
    {
      $('.wrap.nosubsub .error, .wrap.nosubsub .updated').remove();
      $('#fs-preview').addClass('disabled');
      $.ajax({
        type: 'POST',
      	url: fsAjax.url,
      	data: {
      		action : 'fs_import_preview',    
      		_wpnonce : fsAjax.nonce,
      		s: $('#tag-s').val()
      	},
        success: function(data, textStatus, XMLHttpRequest)
      	{
          addPreviewTables(data);
      	},
      	error: function(MLHttpRequest, textStatus, errorThrown)
        {
          $('.wrap.nosubsub h3').before("<div class='error below-h2'><p>" + importStrings.error + "</p></div>");
        },
        complete: function(XMLHttpRequest, textStatus)
        {          
          $('#fs-preview').removeClass('disabled');
        },
      	dataType: 'json'
      });
    }
    event.preventDefault();
    return false;;
  });

});
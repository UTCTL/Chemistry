(function()
{
	tinymce.create('tinymce.plugins.fs_shortcode',
	{
		createControl : function(id, controlManager)
		{
			if (id == 'fs_shortcode')
			{
				var button = controlManager.createButton('fs_shortcode_button',
				{
					title : 'Add a Field shortcode',
					image : '../wp-includes/images/smilies/icon_mrgreen.gif',
					onclick : function() 
					{
					}
				});
				return button;
			}
			return null;
		}
	});

	tinymce.PluginManager.add('mygallery', tinymce.plugins.mygallery);
})()

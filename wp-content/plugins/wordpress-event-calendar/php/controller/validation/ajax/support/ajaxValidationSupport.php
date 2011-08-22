<?php
function wec_ajax_invalid_field_style()
{
    return 'background-color: #FF9F9F;';
}

function wec_testAjax($message = null)
{
    if ( isset ($message))
    {
        die ('alert("'.$message.'")');
    }
    else
    {
        die ('alert("We died")');
    }

}
?>

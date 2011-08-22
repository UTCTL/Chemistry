<?php

abstract class optionsActions
{
    function runSetAction($specifiedAction)
    {
        $optionsHander = new optionsHandler();
		$feedHandler = new feedHandler();
        switch($specifiedAction)
        {

            case 'saveOptions':
                $optionsHander->saveOptions();
                break;

            case 'feedsPage':
                wec_customFeedOptions();
                break;

            case 'addFeed':
                $feedHandler->add();
                break;
				
			case 'editFeedPage':
				wec_edit_feed_page();
				break;
				
			case 'updateFeed':
				$feedHandler->update();
				break;
				
            case 'deleteFeed':
               	$feedHandler->delete();
                break;

            case 'options':
                wec_mainOptionsPage();
                break;

            case 'uninstall':
                uninstallPage();
                break;

            case 'runUnInstaller':
                wec_uninstall();
                break;

            case 'runReInstall':
                wec_reinstaller();
                break;

            case 'documentation':
                wec_documentation();
                break;

            default:
                wec_mainOptionsPage();
                break;



        }
    }


function runAction($action = null)
{
    if ( isset ($action))
    {
        optionsActions::runSetAction($action);
    } 
	else
    {
        if ( isset ($_POST['wec_action']))
        {
            optionsActions::runSetAction($_POST['wec_action']);
        }
        elseif ( isset ($_GET['wec_page']))
        {
            optionsActions::runSetAction($_GET['wec_page']);
        }
        else
        {
            optionsActions::runSetAction(null);
        }

    }
}

}

?>

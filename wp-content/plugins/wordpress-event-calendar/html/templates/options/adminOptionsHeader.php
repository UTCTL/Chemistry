<?php
function wec_adminOptionsHeader()
{
?>
<ul class="subsubsub">
    <li>
    	<?php
        $optionsViewIsCurrent = false;
        if ( isset ($_GET['wec_page']))
        {
            if ($_REQUEST['wec_page'] == 'options')
            {
                $optionsViewIsCurrent = true;
            }
        }
        elseif(!isset($_GET['wec_page']) && !isset($_POST['wec_action']))
        {
            $optionsViewIsCurrent = true;
        }
		elseif(isset($_POST['wec_action'])){
			if($_POST['wec_action'] == 'saveOptions'){
				 $optionsViewIsCurrent = true;
			}
		}
        ?>
		
		
        <a <?php if ($optionsViewIsCurrent) echo 'class="current"';?> href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?page=calendarOptions.php&amp;wec_page=options">Options</a><strong>|</strong>
    </li>
	
	<!--
    <li>
    	<?php
        $feedsViewIsCurrent = false;
        if ( isset ($_GET['wec_page']))
        {
            if ($_GET['wec_page'] == 'feedsPage')
            {
                $feedsViewIsCurrent = true;
            }
        }
		elseif(isset($_POST['wec_action'])){
			if($_POST['wec_action'] == 'addFeed' || $_POST['wec_action'] == 'deleteFeed' || $_POST['wec_action'] == 'editFeedPage' || $_POST['wec_action'] == 'updateFeed'){
				 $feedsViewIsCurrent = true;
			}
		}
        ?>
		
        <a <?php if ($feedsViewIsCurrent) echo 'class="current"';?> href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?page=calendarOptions.php&amp;wec_page=feedsPage">Feeds</a><strong>|</strong>
    </li> -->
    <li>
    	<?php
        $documentationViewIsCurrent = false;
        if ( isset ($_GET['wec_page']))
        {
            if ($_GET['wec_page'] == 'documentation')
            {
                $documentationViewIsCurrent = true;
            }
        }
        ?>
        <a <?php if ($documentationViewIsCurrent) echo 'class="current"';?> href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?page=calendarOptions.php&amp;wec_page=documentation">Documentation</a><strong>|</strong>
    </li>
    <li>
    <?php
        $uninstallViewIsCurrent = false;
        if ( isset ($_GET['wec_page']))
        {
            if ($_GET['wec_page'] == 'uninstall')
            {
                $uninstallViewIsCurrent = true;
            }
        }
		elseif(isset($_POST['wec_action'])){
			if($_POST['wec_action'] == 'uninstall' || $_POST['wec_action'] == 'runUnInstaller' || $_POST['wec_action'] == 'runReInstall'){
				 $feedsViewIsCurrent = true;
			}
		}
        ?>
        <a <?php if ($uninstallViewIsCurrent) echo 'class="current"';?> href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?page=calendarOptions.php&amp;wec_page=uninstall">Uninstall</a>
    </li>
</ul>
<?php
}
?>

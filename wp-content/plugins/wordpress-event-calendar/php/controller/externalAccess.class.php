<?php 
class externalAccess {
    var $returnData;
    var $query;
    var $formattingRules;
    var $container;
    
    function __construct() {
        $this->returnData = '';
    }
    
    function doExternalAccess() {
    
        if (!isset($_REQUEST['container'])) {
            if (!$this->iFrame) {
                $this->appendAlert('No container specified');
                $this->alertData();
            }
        } else {
            $this->container = $_REQUEST['container'];
        }
        
        if (isset($_REQUEST['formattingRules'])) {
            $temp = $_REQUEST['formattingRules'];
            $this->formattingRules = explode(';;', $temp);
            
            //   $this->appendWriteData('Date format: ' . $this->formattingRules[0]);
            //   $this->appendWriteData( 'Time format: ' . $this->formattingRules[1]);
            //   $this->appendWriteData( 'Formatting rules: ' . $this->formattingRules[2]);
        } else {
            $this->formattingRules[0] = get_option('date_format');
            $this->formattingRules[1] = get_option('time_format');
            $this->formattingRules[2] = '<strong>#TITLE#</strong><br/>#DATE# #TIME#';
        }
        
        if (!isset($_REQUEST['query'])) {
            $this->appendWriteData('Failure: No query was specified');
            $this->printData();
        } else {
            $this->query = $_REQUEST['query'];
            $queryObject = new WEC_Query($this->query);

            
            if (!isset($this->formattingRules[1])) {
                $this->formattingRules[1] = '';
            }
            
            if (!isset($this->formattingRules[2])) {
                $this->formattingRules[2] = '';
            }
            
            while ($queryObject->haveEvents()):
                $queryObject->theEvent();
                
                $tags = array('#NAME#', '#TITLE#', '#DATE#', '#TIME#');
                $replacements = array($queryObject->getTheTitle(), $queryObject->getTheTitle(), $queryObject->getTheDate($this->formattingRules[0]), $queryObject->getStartTime($this->formattingRules[1]));
                
                //Append the latest line to the output, but first replace the tags with the right info
                $this->appendWriteData(str_replace($tags, $replacements, $this->formattingRules[2]));
                
            endwhile;
        }
        
        $this->printData();
        
    }
    
    function printData() {
        die('document.getElementById("'.$this->container.'").innerHTML="'.$this->returnData.'"');
    }
    
    function alertData() {
        die($this->returnData);
    }
    
    function appendWriteData($data) {
        $this->returnData .= $data;
    }
    
    function appendAlert($data) {
        $this->returnData .= 'alert("'.$data.'");';
    }
    
    function getTable() {
    
        $categories = $_REQUEST['category'];
        $catArray = explode(',', $categories);
        $categories = implode('&', $catArray);

        
        $query = 'calendarID='.$categories;
        
        if (isset($_REQUEST['limit'])) {
            $query .= ', limit='.$_REQUEST['limit'];
        }
        
        $queryObject = new WEC_Query($query);
        
?>
 
<table id="chatSchedule">
    <?php 
    while ($queryObject->haveEvents()):
        $queryObject->theEvent();
        
        echo '<tr><td class="tableCol1">'.$queryObject->getTheDate('F j').'</td><td class="tableCol2">'.$queryObject->getStartTime('g:i a').' EST </td><td class="tableCol3"><span>'.$queryObject->getTheTitle().'</span></td></tr>';
    
        
    endwhile;
    
    echo '</table>';
    
    die();
    }
    
    }
    
    ?>
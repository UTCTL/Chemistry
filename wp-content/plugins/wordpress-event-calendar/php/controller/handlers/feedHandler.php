<?php
class feedHandler
{
	function add(){
		$feedValidator = new feedValidator();
		$feed = new feed();
		
		$continue = true;
		$errorMessage = '';
		
		if($feedValidator->validFeedName($_POST['feedName'])){
			$feed->setName($_POST['feedName']);
		}
		else{
			$continue = false;
			$errorMessage .= 'You have entered an invalid name for this feed<br />';
		}
		
		
		if($feedValidator->validFeedSlug($feedValidator->cleanSlug($_POST['feedSlug']))){
			$feed->setSlug($feedValidator->cleanSlug($_POST['feedSlug']));
		}
		else{
			$continue = false;
			$errorMessage .= 'You have entered an invalid slug for this feed, it is already used for another feed or calendar<br />';
		}
		
		if($continue){
			$feed->setFeedParameters($_POST['feed_parameters']);
			$feed->setDescription($_POST['feedDescription']);
			$feed->add();
			wec_customFeedOptions();
		}
		else{
			raiserror($errorMessage);
			wec_customFeedOptions();
		}
	
		
	}
	
	function getAllFeeds(){
		$feedDA = new feedDA();
		$feeds = $feedDA->lookupAllEditableFeeds();
		
		$arrayOfFeeds = array();
		$i = 0;
		
		if(isset($feeds)){
			foreach($feeds as $feed){
				$tempFeed = new feed($feed['feedID']);
				$arrayOfFeeds[$i] = $tempFeed;
				$i++;
			}
		}
		else{
			$arrayOfFeeds = null;
		}
	
		return $arrayOfFeeds;
	}
	
	function delete(){
		$feed = new feed($_POST['feedID']);
		$feed->delete();
		wec_customFeedOptions();
	}
	
	function update(){
		$feed = new feed($_POST['feedID'], false);
		
		$continue = true;
		$errorMessage = '';
		
		$feedValidator = new feedValidator();
		
		if($feedValidator->validFeedNameOnEdit($_POST['feedName'], $_POST['feedID'])){
			$feed->setName($_POST['feedName']);
		}
		else{
			$continue = false;
			$errorMessage .= 'You have entered an invalid name for this feed<br />';
		}
		
		
		if($feedValidator->validFeedSlugOnEdit($feedValidator->cleanSlug($_POST['feedSlug']), $_POST['feedID'])){
			$feed->setSlug($feedValidator->cleanSlug($_POST['feedSlug']));
		}
		else{
			$continue = false;
			$errorMessage .= 'You have entered an invalid slug for this feed, it is already used for another feed or calendar<br />';
		}
		
		if($continue){
			$feed->setFeedParameters($_POST['feed_parameters']);
			$feed->setDescription($_POST['feedDescription']);
			$feed->update();
			adminAlertFade($feed->getName() . ' has been updated');
			wec_customFeedOptions();
		}
		else{
			raiserror($errorMessage);
			wec_customFeedOptions();
		}
	
	}
	
	function read($feedID){
		$feedDA = new feedDA();
		return $feedDA->lookupFeedByID($feedID);
	}
	


}
?>
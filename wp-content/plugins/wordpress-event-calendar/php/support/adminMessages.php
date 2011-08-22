<?php
if(!function_exists('raiserror')){
	function raiserror($message){
		?>	
			<div class='updated'><p><strong><?php echo $message; ?></strong></p></div>	
		<?php
	}
}

if(!function_exists('adminError')){
	function adminError($message){
		?>	
			<div class='updated'><p><strong><?php echo $message; ?></strong></p></div>
		<?php
	}
}

if(!function_exists('adminAlertFade')){
	function adminAlertFade($message){
		$divName = md5($message);
	?>	
		<div class='updated' id="<?php echo $divName; ?>"><p><strong><?php echo $message; ?></strong></p></div>
		<script type="text/javascript">
			$('<?php echo $divName; ?>').fade({ delay: 5.0, duration: 0.5});
		</script>
	
	<?php
	}
}

if(!function_exists('adminAlert')){
	function adminAlert($message){
		adminError($message);
	}
}


if(!function_exists('javascriptMessage')){
	function javascriptMessage(){
	?>
	<noscript>
		<div class='updated' id='javascriptWarn'>
			<p>
				JavaScript appears to be disabled in your browser. For best performance, please enable JavaScript, or switch to a more modern browser
			</p>
		</div>
	</noscript>
	
	<?php
	}
}

?>
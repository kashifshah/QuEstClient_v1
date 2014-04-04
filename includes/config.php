<?php
	# Defines the absolute location of the installed software
	#ini_set('include_path', './' . PATH_SEPARATOR . "./common/". PATH_SEPARATOR . ini_get('include_path'));

	#$site_base = '/var/www/html/QuEstClient_v1';
	$site_base = 'http://www.quest.dcs.shef.ac.uk/QuEstClient_v1';
	#defines the path for the includes folder relative to the base of the installed software
	$incBase = 'includes/';
	
	#functions to include common content
	function addSmallHeader ($title="MQ Metric Builder") { global $incBase; include ($incBase.'smallHeader.php'); }
	function addHeader ($title="MQ Metric Builder") { global $incBase; include ($incBase.'header.php'); }
	function addFooter () { global $incBase; include ($incBase.'footer.php'); }
	function addLangCodes () { global $incBase; include ($incBase.'isoLangCodes.php'); }
	function addCountryCodes () { global $incBase; include ($incBase.'isoCountryCodes.php'); }
?>

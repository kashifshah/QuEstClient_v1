<?
	include('includes/xmlrpc.inc'); 
	include('includes/xmlrpcs.inc'); 
	include('includes/xmlrpc_wrappers.inc'); 
	// Loads functions for adding the HTML wrapper
	include('includes/config.php');
	
	// Adds the header
	addHeader('Machine Translation');
	
	// Explode the post data into an array of lines
	$input = explode("\n", trim($_POST['questcontent']));

	function getQUEST ($content) {
		// specify the location for the QuEST request. Note that this must be an absolute URL,
		// not a relative path
		$QuEST_location = "http://www.qt21.eu/infrastructure/quest_dummy.php";

		// open the connection
		$curl_connection = curl_init($QuEST_location);
		// Set timeout at 60 seconds. Is this enough?
		curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 60);
		// Ensure that the results are loaded to the variable, not echoed.
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		// Prevent any certificate errors
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
		// Allow any header redirects to be processed and followed
		curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);

		// specify the data to pass to QuEST and load it (taking whatever is passed to this page as the data)
		$post_data = "data=".$content;
		curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_data);
                 
                // Added by Kashif Shah - 
                // Calling xml rpc server 
                
		 		require_once('ripcord.php'); // function library 
                $client = ripcord::xmlrpcClient("http://143.167.8.76:35722"); // server listening at this address
               
                 $rankedString  .= $client->runQuest->getPredictions($post_data); // calling server function
                 
               //  echo <pre> $rankedString </pre>
				 echo "<pre> $rankedString </pre>", "<br>" ;
	                 // end - Kashif Shah
                //$rankedString = curl_exec($curl_connection);

		// uncomment the following section for diagnostic results
		/*
		print_r(curl_getinfo($curl_connection));
		echo curl_errno($curl_connection) . '-' . curl_error($curl_connection);
		*/
		
		curl_close($curl_connection);
		
		// Get each returned line separately
		$output = explode("\n", $rankedString);

		// Loop through the lines
		foreach ($output as $line) {

			// If it isn't a header line…
			if (!preg_match("#^id\tsource#", $line)) {

				// add a trailing tab (we'll strip it out later)
				$line .="\t";

				// insert <td>s for the id and source
				$replace = '<td class="id">\\1</td><td class="source">\\2</td>';
				$line = preg_replace("#^([^\t]+)\t\"?(.+?)\"?\t#", $replace, $line);

				// insert all other <td>s, pulling the ranking to build the CSS class name
				$replace = '<td class="rank\\1">\\1</td><td class="item\\1">\\2</td>';
				$line = preg_replace("#(\d)\t\"?(.+?)\"?\t#", $replace, $line);
				$lines .= "\t<tr>".$line."</tr>\n";
			}

			// echo the results
			echo($lines);
		}
	}
        
       
?>



<div>
<!--
    <h3>Formatted QuEST output</h3>
	<table style="width:100%;">
		<tr><th class="id">ID</th><th class="source">Source</th><th class="ranked" colspan="2">Moses</th><th class="ranked" colspan="2">Google</th><th class="ranked" colspan="2">Lucy</th></tr>
-->
 <?
	// Loop through all the input data

        // Added by Kashif Shah 
        $file = file_get_contents('./input_quest.txt', true); // Reading input file 
        $input = explode("\n", $file); // dividing the file into lines 
        // end - Kashif Shah
	foreach ($input as $inputline) {

		// clear $line
		$line = "";

		// if it is a header line…
		if (preg_match("#^id\tsource#", $inputline)) {
			// …store it as the header
			$headerline = $inputline;
		} else {
			// …otherwise add the actual data line to the header line and send it to QuEST
			$line = $headerline."\n".$inputline;
                      //  getQUEST($line);
                        // added by Kashif Shah
                        flush(); // needed to display immediatly the return value from server 
                        // end - Kashif Shah
		}
	}
?>
	</table>
</div>



<div>
    
    <h3>Get Predictions of translated text:</h3>
   
<?    
	echo ("$translatedString");
	$input = explode("\n", trim($_POST['translatedString']));
	//$input = explode("\n", $translatedString); // dividing the file into lines 
        // end - Kashif Shah
	foreach ($input as $inputline) {

		// clear $line
		$line = "";

		// if it is a header line…
		if (preg_match("#^id\tsource#", $inputline)) {
			// …store it as the header
			$headerline = $inputline;
		} else {
			// …otherwise add the actual data line to the header line and send it to QuEST
			$line = $headerline."\n".$inputline;
                        getQUEST($line);
                        // added by Kashif Shah
                        flush(); // needed to display immediatly the return value from server 
                        // end - Kashif Shah
		}
	}
?>

</div>

<? addFooter(); ?>
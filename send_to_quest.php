<?php
	include('includes/xmlrpc.inc'); 
	include('includes/xmlrpcs.inc'); 
	include('includes/xmlrpc_wrappers.inc'); 
	// Loads functions for adding the HTML wrapper
	include('includes/config.php');
	
	// Adds the header
	addHeader('Machine Translation');
	 $translatedString = "";
	
	// Explode the post data into an array of lines
	$input = explode("\n", trim($_POST['questcontent']));

	function getRank ($content) {
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
		$post_data =$content;
		curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_data);
                 
                // Added by Kashif Shah - 
                // Calling xml rpc server 
                
		 		require_once('ripcord.php'); // function library 
                $client = ripcord::xmlrpcClient("http://143.167.8.76:35722"); // server listening at this address
               
                 $rankedString  = $client->runQuest->callQuest_wth_line($post_data); // calling server function
              
		
		// Get each returned line separately
		$output = explode("\t", $rankedString);
		  //$output = explode("\t", $rankedString);
                
              //  echo "<font color=#ff0000>$output[0]</font>", "<tab>";
              //  echo "<font color=green>$output[1]</font>", "<br>";
                 if (ob_get_level() == 0) ob_start();
                echo "<table  border=0 width=100%>\n";
                echo "<tr>\n"
                ."<td width=10%> $output[0]</td>"
                ."<td width=15%> $output[1] </td>"
                ."<td width=15%> $output[3] </td>"
                ."<td width=10%> $output[2]</td>"
                ."<td width=15%> $output[5] </td>"
                ."<td width=10%> $output[4]</td>"
                ."<td width=15%> $output[7] </td>"
                ."<td width=10%> $output[6]</td>"
    			."</tr>\n";
    			echo '</table>';             
                
               ob_flush();
    			 flush();
    			 usleep(50000);            
                ob_end_flush();
                //return $predictionString;
                $ao = trim($output[0]). "\t" .trim($output[1]). "\t" .trim($output[2]). "\n";
                //$ao = trim($output[0]). "\t" .trim($output[1]). "\n";
                return $ao;
                

		
	}
        
      
?>



<div>

		<?php
			
			//session_start();
		//	echo "in ranking php file";
			if( $_FILES['file2']['name'] == "" ) {
                die( "Could not upload file!");
        	}
        	else {
        	// Loop through all the input data
        		$file = file_get_contents($_FILES['file2']['name'], true);
        	}
			
			$inputq = explode("\n", $file); // dividing the file into lines 
			
			//if (isset($_SESSION['trans'])){
			//	$minput = trim($_SESSION['trans']);
				//echo "trans value is = " . $minput;
				//}
			//$input = explode("\n", trim($_GET['trans']));
			
			 //   $minput ="id\tthis is souce\tthis is taget1\tthis is target2\tthis is target3"; 
			//	$inputq = explode("\n", $minput); // dividing the String into lines 
				foreach ($inputq as $inputlineq) {
    			if(!empty($inputlineq)){
    				$inputq = iconv(mb_detect_encoding($inputlineq), 'UTF-8', $inputlineq);
    				$pred .= getRank($inputq);
    				//echo $inputq;
    				//echo "<pre> $inputq </pre>"; 
    				flush();
			
					}
				}
				
	//	echo "<pre> $pred </pre>";	
		session_start();
		$_SESSION['trans'] = $pred;
    	//}			
		echo "<br><br>"
		
		?>

</div>

<?php addFooter(); ?>

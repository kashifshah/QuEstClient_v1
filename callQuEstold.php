<?php
include('includes/config.php');
addHeader('Machine Translation');

function getBing($content){
            
               echo $content;

		// specify the data to pass to QuEST and load it (taking whatever is passed to this page as the data)
				try{
			
					$post_data = $content;
					require_once('ripcord.php'); // function library 
		 	 		$client = ripcord::xmlrpcClient("http://143.167.8.76:35722"); // server listening at this address
               	}
               	catch (Exception $e) {
			    	echo 'Caught exception: ',  $e->getMessage(), "\n";
				}

                //$translatedString  = $client->runQuest->getTranslation2($post_data);
		$translatedString  = $client->runQuest->Test($post_data);
                //echo "<pre> $translatedString </pre>", "<br>" ;
               // echo $translatedString, "<br>";
                $output = explode("\t", $translatedString);
                
              //  echo "<font color=#ff0000>$output[0]</font>", "<tab>";
              //  echo "<font color=green>$output[1]</font>", "<br>";
                
                if (ob_get_level() == 0) ob_start();
                
                echo "<table  border=0 width=100%>\n";
                echo "<tr>\n"
                ."<td width=40%> $output[0]</td>"
                ."<td width=40%> $output[1]</td>"
    			."</tr>\n";
    			
    			 echo '</table>'; 
    			 ob_flush();
    			 flush();
    			 usleep(50000);            
                ob_end_flush();
               // flush();
                //return "$translatedString";
                $ao = trim($output[0]). "\t" .trim($output[1]). "\n";
                return $ao;
                 
}



?>

<div>
		<h3>Translation</h3>

		<?php
			//header('Content-Type: text/plain; charset=utf-8');
			if( $_FILES['file']['name'] == "" ) {
                die( "Could not upload file!");
        	}
        	else {
        	// Loop through all the input data
        		$file = file_get_contents($_FILES['file']['name'], true);
			echo "file uploaded" , "\n";
			echo "<br><br>";
        	}
        	
        	$input = explode("\n", $file); // dividing the file into lines 
			$translated = "";
		//echo "file exploded";
		//echo $input;	
    		//$file = file_get_contents('./input_quest_de.txt', true); // Reading input file 
    		//$input = explode("\n", $file); // dividing the file into lines 
    		foreach ($input as $inputline) {
			//echo $inputline;
    			if(!empty($inputline)){
    				//$inputt = iconv(mb_detect_encoding($inputline), 'UTF-8', $inputline);
    			 	$inputt = mb_convert_encoding($inputline, 'UTF-8',mb_detect_encoding($inputline, 'UTF-8, ISO-8859-1', true));	
				//echo "calling bing";
				$translated .= getBing($inputt);
    				//$translated .= "$translated\r\n";
    				//echo $translated;
        			flush();
        		}
		}
		//echo "<pre>$translated</pre>";
		//session_start();
		//$_SESSION['trans'] = $translated;
    				
		echo "<br><br>"
		?>


		<form action="quest_features.php" method="get" enctype="multipart/form-data">
		<input type="hidden" name="trans" value="$_POST['translated'];">
    	<input type="submit" value="Get Features" />
		</form>
		
		<form action="quest_predictions.php" method="get" enctype="multipart/form-data">
		<input type="hidden" name="trans" value="$_POST['translated'];">
    	<input type="submit" value="Get Predictions" />
		</form>
		
		
		<FORM><INPUT Type="button" VALUE="Back" onClick="history.go(-1);return true;"></FORM>
		
		
    

</div>

<?php addFooter(); ?>

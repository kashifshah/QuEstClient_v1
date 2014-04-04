<?php
//error_reporting(E_ERROR | E_PARSE);
include('includes/config.php');
//require_once('ripcord.php');
addHeader('Machine Translation');
function getBing($content){

		//	echo $content;
            
            // specify the data to pass to QuEST and load it (taking whatever is passed to this page as the data)
				try{
			
					$post_data = $content;
					require_once('ripcord.php'); // function library 
					$client = ripcord::xmlrpcClient("http://143.167.8.76:35722"); // server listening at this address
		 	 		
               	}
               	catch (Exception $e) {
			    	echo 'Caught exception: ',  $e->getMessage(), "\n";
				}
				
				
				try{
                                    $translatedString  = $client->runQuest->getTranslation($post_data);
                                    //$translatedString  = $client->runQuest2->Test($post_data);
				}catch (Exception $e) {
			    	echo 'Caught exception: ',  $e->getMessage(), "\n";
				}
				
               // $translatedString  = $client->runQuest->getTranslation($post_data);
                //echo "<pre> $translatedString </pre>", "<br>" ;
               // echo $translatedString, "<br>";
                $output = explode("\t", "$translatedString");
                
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


		//mb_internal_encoding("UTF-8");
		mb_internal_encoding("iso-8859-1");
    		mb_http_output( "UTF-8" );
    		ob_start("mb_output_handler");
		//echo mb_internal_encoding();

		//	if( $_FILES['file']['name'] == "" ) {
                //die( "Could not upload file!");
        	//}
        	//else {
        	// get the input data
        	//	$file = file_get_contents($_FILES['file']['name'], true);
        	//}
                
                
               
   // Configuration - Your Options
      $allowed_filetypes = array('.txt'); // These will be the types of file that will pass the validation.
      $max_filesize = 524288; // Maximum filesize in BYTES (currently 0.5MB).
      $upload_path = 'files/'; // The place the files will be uploaded to (currently a 'files' directory).
 
   $filename = $_FILES['file']['name']; // Get the name of the file (including file extension).
   $ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.
 
   // Check if the filetype is allowed, if not DIE and inform the user.
   if(!in_array($ext,$allowed_filetypes))
      die('The file you attempted to upload is not allowed.');
 
   // Now check the filesize, if it is too large then DIE and inform the user.
   if(filesize($_FILES['file']['name']) > $max_filesize)
      die('The file you attempted to upload is too large.');
 
   // Check if we can upload to the specified path, if not DIE and inform the user.
   //if(!is_writable($upload_path))
     // die('You cannot upload to the specified directory, please CHMOD it to 777.');
 
   // Upload the file to your specified path.
   //if(move_uploaded_file($_FILES['file']['name'],$upload_path . $filename))
     //    echo 'Your file upload was successful, view the file <a href="' . $upload_path . $filename . '" title="Your File">here</a>'; // It worked.
      //else
        // echo 'There was an error during the file upload.  Please try again.'; // It failed :(.
 

               echo "file uploaded"; 
        	$file = file_get_contents($_FILES['file']['tmp_name'], true);
        	$input = explode("\n", $file); // dividing the file into lines 
			$translated = "";
			
    		//$file = file_get_contents('./input_quest_de.txt', true); // Reading input file 
    		//$input = explode("\n", $file); // dividing the file into lines 
    		foreach ($input as $inputline) {
    			if(!empty($inputline)){
				//echo $inputline;
    				//$inputt = iconv(mb_detect_encoding($inputline), 'UTF-8', $inputline);
    				$inputt = mb_convert_encoding($inputline, 'UTF-8',mb_detect_encoding($inputline, 'UTF-8, ISO-8859-1', true)); 
				$translated .= getBing($inputt);
    				//$translated .= "$translated\r\n";
    				//echo $translated;
        			flush();
        		}
			}
		echo "<pre>$translated</pre>";
		session_start();
		$_SESSION['trans'] = $translated;
    				
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

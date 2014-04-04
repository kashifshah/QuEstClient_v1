<?php
include('includes/config.php');
addHeader('Machine Translation');

function getQuEst($content){
            
            // specify the data to pass to QuEST and load it (taking whatever is passed to this page as the data)
				try{
			
					$post_data = $content;
					require_once('ripcord.php'); // function library 
		 	 		$client = ripcord::xmlrpcClient("http://143.167.8.76:35722"); // server listening at this address
               	}
               	catch (Exception $e) {
			    	echo 'Caught exception: ',  $e->getMessage(), "\n";
				}

                $predictionString  = $client->runQuest->getPredictions($post_data);
                //echo "<pre> $predictionString </pre>", "<br>" ;
               // echo $translatedString, "<br>";
                $output = explode("\t", $predictionString);
                
              //  echo "<font color=#ff0000>$output[0]</font>", "<tab>";
              //  echo "<font color=green>$output[1]</font>", "<br>";
                 if (ob_get_level() == 0) ob_start();
                echo "<table  border=0 width=100%>\n";
                echo "<tr>\n"
                ."<td width=40%> $output[0]</td>"
                ."<td width=40%> $output[1]</td>"
                ."<td width=20%> $output[2]</td>"
    			."</tr>\n";
    			//flush();
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
			session_start();
			if (isset($_SESSION['trans'])){
				$minput = trim($_SESSION['trans']);
				//echo "trans value is = " . $minput;
				//}
			//$input = explode("\n", trim($_GET['trans']));
				$inputq = explode("\n", $minput); // dividing the String into lines 
				foreach ($inputq as $inputlineq) {
    			if(!empty($inputlineq)){
    				$inputq = iconv(mb_detect_encoding($inputlineq), 'UTF-8', $inputlineq);
    				$pred .= getQuEst($inputq);
    				//echo $inputq;
    				//echo "<pre> $inputq </pre>"; 
    				flush();
			
					}
				}
				
		echo "<pre> $pred </pre>";	
		session_start();
		$_SESSION['trans'] = $pred;
    	}			
		echo "<br><br>"
		
		?>


<form action="quest_ranking.php" method="get" enctype="multipart/form-data">
		<input type="hidden" name="trans" value="$_POST['pred'];">
    	<input type="submit" value="Get Ranking" />
		</form>
		
<FORM><INPUT Type="button" VALUE="Back" onClick="history.go(-1);return true;"></FORM>
</div>

<?php addFooter(); ?>
		

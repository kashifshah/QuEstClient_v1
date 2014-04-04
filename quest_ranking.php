<?php
include('includes/config.php');
addHeader('Machine Translation');


function record_sort($records, $field, $reverse=false)
{
    $hash = array();
    
    foreach($records as $key => $record)
    {
        $hash[$record[$field].$key] = $record;
    }
    
    ($reverse)? krsort($hash) : ksort($hash);
    
    $records = array();
    
    foreach($hash as $record)
    {
        $records []= $record;
    }
    
    return $records;
}

?>




<div>

		<?php
			session_start();
			if (isset($_SESSION['trans'])){
				$minput = trim($_SESSION['trans']);
			//	echo "trans value is = " . $minput;
				}
				
		
		 // $minput = "source1 \t target1 \t 2 \n source2 \t target2 \t 3 \n source3 \t target3 \t 1 \n ";		
		//  echo "<pre> $minput </pre>";
		  
		  $inputq = explode("\n", $minput); // dividing the String into lines 
		 // echo "<pre> $inputq </pre>";
		//$inputqr = explode("\t", $inputq);
				//asort($inputq);
		   foreach ($inputq as $input) {
		   
    			$inputr = explode("\t", $input);
    			 for ($i=0; $i<=2; $i++) {
          			$foo[$i][$x] = $inputr[$i];
    				}
    			
    		}
    		
    		 $line_of_text = explode("\n", $minput);
    		for ($x=0; $x<=2; $x++)
			{
    			$line = explode("\t",$line_of_text[$x]);

    			// save it by coulmns otherwise it will saved like rows
    			for ($i=0; $i<=2; $i++) {
          			$foo[$i][$x] = $line[$i];
    			}
			}
    		
    		$order_by = 2;
    		$sort_by = SORT_REGULAR;
    		$a = $foo[$order_by];

			// sort
			asort($a, $sort_by);
			
			
			
			echo "<table cellpudding=0 cellspacing=0 border=1>\n";
			echo "<tr>\n";
         
          echo "<td>source</td>\n";
          echo "<td>target</td>\n";
          echo "<td>Prediction</td>\n";
           echo "<td>Rank</td>\n";
        		echo "</tr>\n";
			
			
			foreach ($a as $k => $v) {
   				echo "<tr>\n";
      			
      			// you can print here a for loop (0 to num of columns[=3])
      			echo "<td>".$foo[0][$k]."</td>\n";
      			echo "<td>".$foo[1][$k]."</td>\n";
      			echo "<td>".$foo[2][$k]."</td>\n";
     			echo "<td>$k</td>\n";
    			echo "</tr>\n";
			}
			echo "</table>\n";
		
		?>
		

<FORM><INPUT Type="button" VALUE="Back" onClick="history.go(-1);return true;"></FORM>
</div>

<?php addFooter(); ?>

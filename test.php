<?php
	// Loads functions for adding the HTML wrapper
	include('includes/config.php');
	//require_once('includes/config.php');
	// Adds the header
	addHeader("Machine Translation");
	?>



<div>
    
    <h3>Get Translation, Features and Prediction:</h3>
    
    Select a file to upload: <br />
    Please make sure that file has an extention .txt and  contain a sentence per line and is in following format with ||| as delimiter:<br />
    id ||| source sentence to be translated <br />
    e.g <br />
    1 ||| this is first sentence <br />
    2 ||| this is second sentence <br />

    If input sentences are already translated, please add additional field as follows: <br />

   id ||| source sentence to be translated ||| translated sentence <br />
   e.g <br />
    1 ||| this is first sentence ||| THIS IS FIRST SENTENCE TRANSLATION <br />
    2 ||| this is second sentence ||| THIS IS SECOND SENTENCE TRANSLATION <br />
   


    <form action="callQuEst.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file" size="100" />
        <br />
	<select name=“lang_pair” value="options">
	<option value=“”>Choose the language pair</option>
	<option value=“es_en”>Spanish-English</option>
	<option value=“de_en”>German-English</option>
	</select>
        <input type="submit" value="Upload File" />
    </form>
    
    
    <h3>Get Ranking of multiple targets given same source:</h3>
    Format (tab separated):<br />
    e.g <br />
    1&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp source-sentence &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp target1 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp target2 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp target3 <br />
    
    
    <form action="send_to_quest.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file2" size="100" />
        <br />
        <input type="submit" value="Upload File and Rank" />
    </form>
    
	
		


</div>


<?php addFooter(); ?>

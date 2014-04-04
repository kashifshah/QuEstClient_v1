<?php
/**
 * 
 * This sample is reading text data
 * and perform a sort to a 2 dimensional array
 * just like a normal sql do to "order by asc" 
 * 
 */

$foo = array();

/*
# SORT_REGULAR - compare items normally (don't change types)
# SORT_NUMERIC - compare items numerically
# SORT_STRING - compare items as strings
*/
$sort_by = SORT_REGULAR;

/*
# 0 - order by name column
# 1 - order by age column
# 2 - order by rank column
# 3 - order by color column
*/
$order_by = 1;

// source file
$line_of_text[1] = 'a1name|f2age|h3rank|jcolor';
$line_of_text[2] = 'b1name|d2age|i3rank|k4color';
$line_of_text[0] = 'c1name|e2age|g3rank|l4color';

// make array
for ($x=0; $x<=2; $x++)
{
    $line = explode('|',$line_of_text[$x]);

    // save it by coulmns otherwise it will saved like rows
    for ($i=0; $i<=3; $i++) {
          $foo[$i][$x] = $line[$i];
    }
}

// get the key order
$a = $foo[$order_by];

// sort
asort($a, $sort_by);

// start print
echo "<table cellpudding=0 cellspacing=0 border=1>\n";
        echo "<tr>\n";
          echo "<td>key</td>\n";
          echo "<td>name</td>\n";
          echo "<td>age</td>\n";
          echo "<td>rank</td>\n";
          echo "<td>color</td>\n";
        echo "</tr>\n";

// print by key order
foreach ($a as $k => $v) {
    echo "<tr>\n";
      echo "<td>$k</td>\n";
      // you can print here a for loop (0 to num of columns[=3])
      echo "<td>".$foo[0][$k]."</td>\n";
      echo "<td>".$foo[1][$k]."</td>\n";
      echo "<td>".$foo[2][$k]."</td>\n";
      echo "<td>".$foo[3][$k]."</td>\n";
    echo "</tr>\n";
}
echo "</table>\n";
?>
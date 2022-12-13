<?php
   $input1 = array( "a"=>"orange", "b"=>"mango", "c"=>"banana");
   $input2 = array( "a"=>"orange", "b"=>"apple", "c"=>"banana");
   print_r(array_diff_assoc($input1, $input2));
?>
This will produce the following result −

Array
(
    [b] => mango
)

compare technician with the date homeowner chose and assign to the one with lesser task
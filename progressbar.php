<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"> 

<html lang="en"> 
<head> 
    <title>Progress Bar</title> 
</head> 
<body> 
<!-- Progress bar holder --> 
<div id="progress" style="width:500px;border:1px solid #ccc;"></div> 
<!-- Progress information --> 
<div id="information" style="width"></div> 

<?php 
if( isset($_REQUEST['kapp_delay_time']) ) $kapp_delay_time=$_REQUEST['kapp_delay_time'];
else $kapp_delay_time=10;
$total = $kapp_delay_time; //10; // Total processes 
for( $i=1; $i<=$total; $i++){ // Loop through process 
    // Calculate the percentation 
    $percent = intval($i/$total * 100)."%"; 
     
    // Javascript for updating the progress bar and information 
    echo '<script language="javascript"> 
    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#ddd;\">&nbsp;</div>"; 
    document.getElementById("information").innerHTML="'.$i.' row(s) processed."; 
    </script>'; 

	// This is for the buffer achieve the minimum size in order to flush data
    echo str_repeat(' ',1024*64); 

	// Send output to browser immediately 
    flush(); 

	// Sleep one second so we can see the delay 
    sleep(1); 
	
	if( $i == $total) {
		echo '<script language="javascript">alert("completed OK");</script>'; 
		echo "<script>self.close();</script>";
	}
} 
// Tell user that the process is completed 
echo '<script language="javascript">document.getElementById("information").innerHTML="completed"</script>'; 

?> 
</body> 
</html>
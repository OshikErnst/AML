<?php
if(isset($_POST['get_option']))
{
 global wpdb;

 $sites = $wpdb->get_row( "SELECT * FROM aml_sites where ID = " . $_POST['get_option']);

 while($row=mysql_fetch_array($sites))
 {
  echo "<option>".$row['city']."</option>";
 }
 exit;
}
?>
<?php


  $nick = $_GET['nick'];
  $text = $_GET['text'];
  $data = $_GET['data'];










    //Connect to database

    mysql_connect("localhost", "aivars", "cby1*lyz") or

        die(Chr(0) . Chr(1) . Encrypt(SaXoro("Could not connect. The SQL server is down.","Wait")));

    mysql_select_db("aivars");




    if(($text)and($data))
    {
      $result = mysql_query("INSERT INTO OCRChars (user, text, pic, IP) VALUES ('" . $nick . "', '" . $text . "', '" . $data . "', '" . $_SERVER['REMOTE_ADDR'] . "')")
        or die('Error while adding');
    }
    
    die('OK');
    





?>

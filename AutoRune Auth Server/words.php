<? //Shows how many words we have

function db_query($query, $link) {
  $qid = mysql_query($query);
  if (! $qid) {
    echo("Can't execute query: <pre>$query</pre>");
  }
  return $qid;
}



function db_fetch_array($qid) {
  return mysql_fetch_array($qid);
}

function sqlQueryValue($query) {
  $result = false;
  if ($qid = db_query($query, $GLOBALS['DBH']))
    if ($r = db_fetch_array($qid)) $result = $r[0];
  return $result;
}

function sqlQuery($query) {
  return $qid = db_query($query, $GLOBALS['DBH']);
}


function sqlQueryData($query) {
  $result = false;
  $i = 0;
  if ($qid = db_query($query, $GLOBALS['DBH']))
    while ($r = db_fetch_array($qid)) $result[$i++] = $r;
  return $result;
}






  mysql_connect("localhost", "aivars", "cby1*lyz") or

        die(Chr(0) . Chr(1) . Encrypt(SaXoro("Could not connect. The SQL server is down.","Wait")));

    mysql_select_db("aivars");
?>
So far we have:<b><?
  $c = sqlQueryValue("SELECT Count(1) FROM OCRChars");
  echo $c;
?></b> words in database.<br><br>
<?
  $d = sqlQueryData("SELECT User AS user, Count(1) AS count FROM OCRChars GROUP BY User ORDER BY COUNT DESC");
  echo "<TABLE border=1 cellpadding=1 cellspacing=0><TR><TD><b>User</b></TD><TD><b>Words submitted</b></TD></TR>";
  foreach($d as $row)
  {
    if(!$row['user'])
      $row['user'] = 'Anonymous';
    echo "<TR><TD>" . $row['user'] . "</TD><TD>" . $row['count'] . "</TD></TR>";
  }
  echo "</TABLE>";
?>

<br><br>Random word: <br>
<?
$c = sqlQueryValue("SELECT Count(1) FROM OCRChars");
//echo $c;
$r = rand(1, $c);
$d = sqlQueryData("SELECT user, text, pic as data FROM OCRChars LIMIT $r, 1");
echo "<TABLE border=1 cellpadding=1 cellspacing=0>
      <TR><TD>User</TD><TD>Word</TD><TD>Picture</TD></TR>";
echo "<TR><TD>" . $d[0]['user'] . "</TD><TD>" . $d[0]['text'] . "</TD><TD><img src=\"disppic.php?text=" . $d[0]['data'] . "\" width=\"255\" height=\"40\"></TD></TR></TABLE>";

?>



<br><br>Most popular words: <br>
<?
  $d = sqlQueryData("SELECT text AS text, Count(1) AS count FROM OCRChars GROUP BY text ORDER BY COUNT DESC LIMIT 50");
  echo "<TABLE border=1 cellpadding=1 cellspacing=0><TR><TD><b>Word</b></TD><TD><b>Count</b></TD></TR>";
  foreach($d as $row)
  {
    echo "<TR><TD>" . $row['text'] . "</TD><TD>" . $row['count'] . "</TD></TR>";
  }
  echo "</TABLE>";
?>

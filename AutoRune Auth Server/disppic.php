<?  //Displays picture

function StringToImage($im, $s, $forecol, $bgcol)
{
  $col = $bgcol;
  $count = '';
  $x = 0;
  $y = 0;
  for($f = 0; $f < strlen($s); $f++)
  {
    if((($s[$f] == 'b')or($s[$f] == 'w'))and($count<>''))
    {
      for($z=1; $z<= intval($count); $z++)
      {
        imagesetpixel($im, $x, $y, $col);
        $x++;
        if($x >= 255){
          $x = 0;
          $y++;
          if($y > 40)
            die('Boo, incorrect parameter');
        }
      }
      $count = '';
    }
    if($s[$f] == 'b')
    {
      $col = $bgcol;
    }else if($s[$f] == 'w')
    {
      $col = $forecol;
    }else
    {
      $count .= $s[$f];
    }
  }
}


header ("Content-type: image/png");

$im = @imagecreate (255,40);
$background_color = imagecolorallocate ($im, 0, 0, 0); //black background
$fore_color = imagecolorallocate ($im, 255, 255,255);//white text

//imagesetpixel($im, 10, 10, $fore_color);
//imagesetpixel($im, 12, 12, $fore_color);
//imagesetpixel($im, 14, 14, $fore_color);

StringToImage($im, $_GET['text'], $fore_color, $background_color);


imagepng ($im);


?>

<?php
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 <head>
  <title> Text-to-Binary (and back!) Converter </title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  <style type="text/css">
  <!--
    body { font-family: "arial", "helvetica", sans-serif; font-size: 10pt; }
  -->
  </style>
 </head>
 <body>
<?php
  // Declare functions
    function txt2bin($str) 
    {
      $text_array = explode("\r\n", chunk_split($str, 1));
      for ($n = 0; $n < count($text_array) - 1; $n++) 
      {
        $newstring .= substr("0000".base_convert(ord($text_array[$n]), 10, 2), -8);
      }
      $newstring = chunk_split($newstring, 8, " ");
      return $newstring;
    }

  function bin2txt($str) {
    $str = str_replace("\r\n", "", str_replace(" ", "", $str));
    $text_array = explode("\r\n", chunk_split($str, 8));
    for ($n = 0; $n < count($text_array) - 1; $n++) 
    {
      $newstring .= chr(base_convert($text_array[$n], 2, 10));
    }
    $newstring = htmlspecialchars($newstring);
    return $newstring;
  }
  // Check to see if form was submitted yet
  if (isset($_POST['submit'])) 
  {
   $text = $_POST['text'];
   $convert = $_POST['convert'];
    // Yes, so make sure they filled something in
    if($text == '') 
    {
      die("<p>Fill in the form, dinglefritz! ;)</p>\n");
    }
    // Looks good, so clean up data
    $text = urldecode(stripslashes($text));
    // Make copy of original text for later display
    $orig_text = htmlspecialchars($text);
    // Time to process the form
    if ($convert == "txt2bin") 
    {
      // Convert from text to binary
      $text = txt2bin($text);
    } 
    elseif ($convert == "bin2txt") 
    {
      // Convert from binary to text
      $text = bin2txt($text);
    } else {
      // This shouldn't happen
      die("<p>Hmmm. Now THAT'S no good. How about go back and try again?</p>\n");
    }
    // Display result
    echo("<p>$orig_text converts to:</p>\n");
    echo("<p>$text</p>\n");
} 
else 
{
  // Form has not been submitted, so display greeting
?>
  <center>
  <p>Welcome to the Text to Binary (and back!) Converter!</p>
  </center>
<?php
} // End big if
?>
  <!-- begin form -->
  <center>
  <p>Please insert text below:</p>
  <form method="post" action="<?php echo($PHP_SELF); ?>">
    <textarea name="text" rows="10" cols="45"></textarea><br />
    <input type="radio" name="convert" value="txt2bin" checked="checked" /> Convert from text to binary<br />
    <input type="radio" name="convert" value="bin2txt" /> Convert from binary to text<br />
    <input type="submit" name="submit" value="Convert!" />
    <input type="reset" value="Clear" />
  </form>
  </center>
  <!-- begin footer; it would be nice if you would leave this on. ;) -->
<?php

?>
 </body>
</html>

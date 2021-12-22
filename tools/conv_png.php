<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<title>Converter to PNG | Learning Pico System</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="content-language" content="ja" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<style type="text/css">
body {
  font-size: 10pt;
  padding: 0px 0px 0px 0px;
  }
</style>
</head>
<body>
Converter to create 12-bit color data from PNG images: r(4bit),g(4bit),b(4bit)<br>
<br>
<form enctype="multipart/form-data" action="conv_png.php" method="POST">
  <input type="hidden" name="MAX_FILE_SIZE" value="1048576">
  <input type="hidden" name="mode" value="upload">
  Set PNG Image: <input name="userfile" type="file"> <input type="submit" value="Convert">
</form>
<?php
//ini_set('display_errors', "On");
$res = "";
if(isset($_POST['mode']) && $_POST['mode'] = "upload"){
	$filename = $_FILES['userfile']['name'];
	$imgfile = $_FILES['userfile']['tmp_name'];
	$imgsize = getimagesize($imgfile);
	if($imgsize['mime']=="image/png"){
		$img_w = $imgsize[0];
		$img_h = $imgsize[1];

		printf("<br>Width: %s Height: %s | %s<br>",$img_w,$img_h,$filename);
		$img = imagecreatefrompng($imgfile);
		for($y=0; $y<$img_h; $y++){
			for($x=0; $x<$img_w; $x++){
				$rgb = imagecolorat($img, $x, $y);
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF;

				$r = ($r & 0b11110000) >> 4;
				$g = ($g & 0b11110000) >> 4;
				$b = ($b & 0b11110000) >> 4;
		
				if($y==($img_h-1) && $x==($img_w-1)){
					$res .= sprintf("%d,%d,%d ",$r,$g,$b);
				}
				else{
					$res .= sprintf("%d,%d,%d, ",$r,$g,$b);
				}
			}
			$res .= "\n";
		}
	}
}
else{
	echo "<br><br>\n";
}
?>
<textarea rows="40" cols="80"><?php echo $res; ?></textarea><br>
Wiki <a href="https://github.com/emutyworks/LearningPicoSystem/wiki">https://github.com/emutyworks/LearningPicoSystem/wiki</a>
</body>
</html>
<?php 
header("X-XSS-Protection: 0");
echo "<pre>";
print_r($_POST);
echo "</pre>";
?>
<!DOCTYPE html>
<html>
<head>
	<title>CKEDITOR</title>
	<meta charset="utf-8">
	<script src="ckeditor.js"></script>
</head>
<body>
	
  	<form action="#" method="POST">
        <textarea name="editor" id="editor" rows="10" cols="80">
            <?php echo $_POST["editor"] ?>
        </textarea>

        <input type="submit" value="submit">
    </form>
    <script>
        CKEDITOR.replace('editor',{ 
        	customConfig : "custom/config_1.js",
        });
    </script>
</body>
</html>
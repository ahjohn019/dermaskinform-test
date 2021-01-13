<!DOCTYPE html>
<html>
<body>

<?php include 'imagecontroller.php' ?>

<form action="imagecontroller.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>

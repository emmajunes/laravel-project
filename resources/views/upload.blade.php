<!DOCTYPE html>
<html>
<body>

<form method="post" action="{{route('upload.uploadfile')}}" enctype="multipart/form-data">
  Välj fil att ladda upp:
  <input type="file" name="file">
  <input type="submit" value="Ladda upp fil" name="submit">
</form>

</body>
</html>
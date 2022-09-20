<!DOCTYPE html>
<html>
<body>

<form method="post" action="{{route('upload.uploadfile')}}" enctype="multipart/form-data">
  @csrf
  <h3>Bildverktyg för sociala medier</h3>
  <br>
  Välj fil att ladda upp:
  <input type="file" name="file">

  <br><br>

<label for="logo">Välj färg på loggan:</label>
<select name="logo" id="logo">
  <option value="svart">svart</option>
  <option value="vit">vit</option>
</select>

<br><br>

<label for="logo">Välj anpassad storlek till:</label>
<select name="size" id="size">
  <option value="facebook">facebook</option>
  <option value="instagram">instagram</option>
</select>

<br><br>

<input type="submit" value="Klar" name="submit">

</form>


</body>
</html>
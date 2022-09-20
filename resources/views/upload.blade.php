<!DOCTYPE html>
<html>
  <head>
      <link rel="stylesheet" href="mystyle.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong">
  </head>
<body>

<div>
<form method="post" action="{{route('upload')}}" enctype="multipart/form-data">
  @csrf
  <h1>Bildverktyg för sociala medier</h1>
  <br>
  <strong>Välj fil att ladda upp:</strong>
  <br><br>
  <input type="file" name="file">
  <br><br>

<strong><label for="logo">Välj färg på loggan:</label></strong>
<br><br>
<select name="logo" id="logo">
  <option value="svart">svart</option>
  <option value="vit">vit</option>
</select>

<br><br>

<strong><label for="logo">Välj anpassad storlek till:</label></strong>
<br><br>
<select name="size" id="size">
  <option value="facebook">facebook</option>
  <option value="instagram">instagram</option>
</select>

<br><br>

<input class="submitbutton" type="submit" value="Klar" name="submit">

</form>
</div>

</body>
</html>
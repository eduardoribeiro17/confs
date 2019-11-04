<!DOCTYPE html>
<html>
<head>
  <title>Insere Retornos</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
  <body class="jumbotron">
    <form action="processa_retornos.php" method="post" enctype="multipart/form-data" class="form-inline">
      <div class="custom-file form-control  mx-sm-3 mb-2">
        <input type="file" class="custom-file-input form-control" name="file" id="retornoFile"/>
        <label class="custom-file-label form-control" for="retornoFile">Escolher arquivo</label>
      </div>      
      <button type="submit" class="btn btn-primary mb-2">Processar</button>
    </form>
  </body>
</html> 
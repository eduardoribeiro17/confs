<!DOCTYPE html>
<html>
<head>
  <title>Valor</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body style="margin: 170px 200px;">
  <form class="form-inline" action="relatorio.php" method="post">
    <label for="mes_ano">Mes/Ano</label>  
    <div class="form-group mx-sm-3 mb-2">
      <input type="text" class="form-control" id="mes_ano" name="mes_ano">
    </div>
    <label for="valor">Valor</label>
    <div class="form-group mx-sm-3 mb-2">
      <input type="text" class="form-control" id="valor" name="valor">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Confirma</button>
  </form>
</body>
</html>
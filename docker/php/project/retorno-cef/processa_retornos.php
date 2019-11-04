<?php

// error_reporting(0);
$file = $_FILES['file'];
$nomeArquivo = substr($file['name'], 0, -3). 'csv';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $nomeArquivo);
$saida = fopen('php://output', 'w');

$retorno = array('DATA PAGAMENTO', 'DATA PREVISÃO', 'VALOR PAGO', 'ID CONTA', 'ID FATURA', 'BAIXADA', 'CIDADE');
fputcsv($saida, $retorno);

if (is_file($file['tmp_name'])) {

  $target     = fopen($file['tmp_name'], 'r');
  $linha      = '';
  $linhaZero  = '';

  while(($linha = fgets($target)) !== FALSE) {

    if ($linhaZero == '') {
      $linhaZero = $linha;
      unset($linha);
    } else {

      if ($linha[0] == 'Z')
        break;

      $dataPagamento  = substr($linha, 27, 2) . '/' . substr($linha, 25, 2) . '/' . substr($linha, 21, 4);
      $dataPrevisao   = substr($linha, 35, 2) . '/' . substr($linha, 33, 2) . '/' . substr($linha, 29, 4);
      $valorPago      = substr($linha, 41, 11);
      $idConta        = substr($linha, 64, 7);
      $idFatura       = substr($linha, 71, 6);
      
      $aposAVirgula = substr($valorPago, 9,  11);
      $novoValor = substr($valorPago, 0,  -2);
      $novoValor = $novoValor . '.' . $aposAVirgula;  

      if ($idFatura !== '') {
        if ($idFatura < 22480) {

          $cidade = 'DIVINOPOLIS';
          $dbname = 'DIVINOPOLIS';
          $host = '192.168.0.60';
          $port = '5432';  
          $dbuser = 'postgres';
          $dbpass = '165811';
          $db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sqlBaixa = 'SELECT * FROM baixas WHERE faturas = ' . $idFatura;
          $stmt = $db->query($sqlBaixa);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $baixada = $result > 0 ? 'SIM' : 'NÃO';
        } else if (($idFatura >= 22480) && ($idFatura < 24999)) {

          $cidade = 'PONTE ALTA DO BOM JESUS';
          $dbname = 'PONTEALTA';
          $host = '192.168.0.60';
          $port = '5432';  
          $dbuser = 'postgres';
          $dbpass = '165811';
          $db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sqlBaixa = 'SELECT * FROM baixas WHERE faturas = ' . $idFatura;
          $stmt = $db->query($sqlBaixa);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $baixada = $result > 0 ? 'SIM' : 'NÃO';
        } else if (($idFatura >= 25000) && ($idFatura < 49999)) {

          $cidade = 'ITAPIRATINS';
          $dbname = 'ITAPIRATINS';
          $host = '192.168.0.60';
          $port = '5432';  
          $dbuser = 'postgres';
          $dbpass = '165811';
          $db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sqlBaixa = 'SELECT * FROM baixas WHERE faturas = ' . $idFatura;
          $stmt = $db->query($sqlBaixa);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $baixada = $result > 0 ? 'SIM' : 'NÃO';
        } else if (($idFatura >= 50000) && ($idFatura < 99999)) {

          $cidade = 'TALISMA';  
          $dbname = 'TALISMA';
          $host = '192.168.0.60';
          $port = '5432';  
          $dbuser = 'postgres';
          $dbpass = '165811';
          $db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sqlBaixa = 'SELECT * FROM baixas WHERE faturas = ' . $idFatura;
          $stmt = $db->query($sqlBaixa);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $baixada = $result > 0 ? 'SIM' : 'NÃO';
        } else if (($idFatura >= 100000) && ($idFatura < 139999)) {

          $cidade = 'SILVANOPOLIS';
          $dbname = 'SILVANOPOLIS';
          $host = '192.168.0.60';
          $port = '5432';  
          $dbuser = 'postgres';
          $dbpass = '165811';
          $db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sqlBaixa = 'SELECT * FROM baixas WHERE faturas = ' . $idFatura;
          $stmt = $db->query($sqlBaixa);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $baixada = $result > 0 ? 'SIM' : 'NÃO';
        } else if (($idFatura >= 140000) && ($idFatura < 179999)) {

          $cidade = 'PORTO ALEGRE TO'; 
          $dbname = 'PORTOALEGRETO';
          $host = '192.168.0.60';
          $port = '5432';  
          $dbuser = 'postgres';
          $dbpass = '165811';
          $db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sqlBaixa = 'SELECT * FROM baixas WHERE faturas = ' . $idFatura;
          $stmt = $db->query($sqlBaixa);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $baixada = $result > 0 ? 'SIM' : 'NÃO';
        } else if (($idFatura >= 180000) && ($idFatura < 199999)) {

          $cidade = 'ABREULANDIA';
          $dbname = 'ABREULANDIA';
          $host = '192.168.0.60';
          $port = '5432';  
          $dbuser = 'postgres';
          $dbpass = '165811';
          $db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sqlBaixa = 'SELECT * FROM baixas WHERE faturas = ' . $idFatura;
          $stmt = $db->query($sqlBaixa);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $baixada = $result > 0 ? 'SIM' : 'NÃO';
        } else if (($idFatura >= 200000) && ($idFatura < 219999)) {

          $cidade = 'SANTA RITA';
          $dbname = 'SANTARITA';
          $host = '192.168.0.60';
          $port = '5432';  
          $dbuser = 'postgres';
          $dbpass = '165811';
          $db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sqlBaixa = 'SELECT * FROM baixas WHERE faturas = ' . $idFatura;
          $stmt = $db->query($sqlBaixa);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $baixada = $result > 0 ? 'SIM' : 'NÃO';
        } else if (($idFatura >= 220000) && ($idFatura < 239999)) {

          $cidade = 'NOVO ALEGRE';
          $dbname = 'NOVOALEGRE';
          $host = '192.168.0.60';
          $port = '5432';  
          $dbuser = 'postgres';
          $dbpass = '165811';
          $db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sqlBaixa = 'SELECT * FROM baixas WHERE faturas = ' . $idFatura;
          $stmt = $db->query($sqlBaixa);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $baixada = $result > 0 ? 'SIM' : 'NÃO';
        } else if (($idFatura >= 240000) && ($idFatura < 279999)) {

          $cidade = 'SANTA MARIA';
          $dbname = 'SANTAMARIA';
          $host = '192.168.0.60';
          $port = '5432';  
          $dbuser = 'postgres';
          $dbpass = '165811';
          $db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sqlBaixa = 'SELECT * FROM baixas WHERE faturas = ' . $idFatura;
          $stmt = $db->query($sqlBaixa);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $baixada = $result > 0 ? 'SIM' : 'NÃO';
        } else if (($idFatura >= 280000) && ($idFatura < 349999)) {

          $cidade = 'GOIANORTE';
          $dbname = 'GOIANORTE';
          $host = '192.168.0.60';
          $port = '5432';  
          $dbuser = 'postgres';
          $dbpass = '165811';
          $db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sqlBaixa = 'SELECT * FROM baixas WHERE faturas = ' . $idFatura;
          $stmt = $db->query($sqlBaixa);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $baixada = $result > 0 ? 'SIM' : 'NÃO';
        } else if (($idFatura >= 350000) && ($idFatura < 399999)) {

          $cidade = 'SANTA ROSA';
          $dbname = 'SANTAROSA';
          $host = '192.168.0.60';
          $port = '5432';  
          $dbuser = 'postgres';
          $dbpass = '165811';
          $db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sqlBaixa = 'SELECT * FROM baixas WHERE faturas = ' . $idFatura;
          $stmt = $db->query($sqlBaixa);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $baixada = $result > 0 ? 'SIM' : 'NÃO';
        } else if (($idFatura >= 400000) && ($idFatura < 449999)) {

          $cidade = 'MONTE DO CARMO';
          $dbname = 'TALISMA';
          $host = '192.168.0.60';
          $port = '5432';  
          $dbuser = 'postgres';
          $dbpass = '165811';
          $db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sqlBaixa = 'SELECT * FROM baixas WHERE faturas = ' . $idFatura;
          $stmt = $db->query($sqlBaixa);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $baixada = $result > 0 ? 'SIM' : 'NÃO';
        } else if (($idFatura >= 450000) && ($idFatura < 499999)) {

          $cidade = 'CHAPADA DA NATIVIDADE';
          $dbname = 'CHAPADANATIVIDADE';
          $host = '192.168.0.60';
          $port = '5432';  
          $dbuser = 'postgres';
          $dbpass = '165811';
          $db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sqlBaixa = 'SELECT * FROM baixas WHERE faturas = ' . $idFatura;
          $stmt = $db->query($sqlBaixa);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $baixada = $result > 0 ? 'SIM' : 'NÃO';
        } else if (($idFatura >= 500000) && ($idFatura < 799999)) {

          $cidade = 'PEQUIZEIRO';
          $dbname = 'PEQUIZEIRO';
          $host = '192.168.0.60';
          $port = '5432';  
          $dbuser = 'postgres';
          $dbpass = '165811';
          $db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sqlBaixa = 'SELECT * FROM baixas WHERE faturas = ' . $idFatura;
          $stmt = $db->query($sqlBaixa);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $baixada = $result > 0 ? 'SIM' : 'NÃO';
        } else if (($idFatura >= 800000) && ($idFatura < 955138)) {

          $cidade = 'PONTE ALTA DO TOCANTINS';
          $dbname = 'PONTEALTATO';
          $host = '192.168.0.60';
          $port = '5432';  
          $dbuser = 'postgres';
          $dbpass = '165811';
          $db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sqlBaixa = 'SELECT * FROM baixas WHERE faturas = ' . $idFatura;
          $stmt = $db->query($sqlBaixa);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $baixada = $result > 0 ? 'SIM' : 'NÃO';
        } else if ($idFatura >= 955139) {

          $cidade = 'BOM JESUS DO TOCANTINS';
          $dbname = 'BOMJESUSTO';
          $host = '192.168.0.60';
          $port = '5432';  
          $dbuser = 'postgres';
          $dbpass = '165811';
          $db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sqlBaixa = 'SELECT * FROM baixas WHERE faturas = ' . $idFatura;
          $stmt = $db->query($sqlBaixa);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $baixada = $result > 0 ? 'SIM' : 'NÃO';
        } else {
          $cidade = 'NULL';
          $baixada = 'NULL';
        }
      }

      $retorno = array($dataPagamento, $dataPrevisao, $novoValor, $idConta, $idFatura, $baixada, $cidade);
      fputcsv($saida, $retorno);  
    }
  }

  fclose($target);
} else {

  echo "<script>alert('Erro: Arquivo não carregado!');</script>";
  echo "<script>window.location.href = 'index.php';</script>";
}
?>
<?php

$limite = $_POST['valor'];
$alvo = $_POST['mes_ano'];;
$auxExplore = explode('-', $alvo);
$ano = $auxExplore[1];
$mes = $auxExplore[0];

$file = fopen($alvo.'.csv', 'r');
$linha = '';
$sequencia = [];
while (($line = fgetcsv($file)) !== FALSE) {
  if ($line[1] != '')
      if (is_numeric($line[1]))
        $linha .= $line[1] . ",";
  array_push($sequencia, $line[0]);
}

fclose($file);

$iterator = new CachingIterator(new ArrayIterator($sequencia));
$trava = false;
foreach($iterator as $key => $value){

    $proximoValue = $iterator->getInnerIterator()->current();
    
    if (is_numeric($value) && is_numeric($proximoValue)) {
      $resultado = $proximoValue - $value;
      if ($resultado > 1) {
        echo ($value + 1) . '<br />';
        $trava = true;
      }
    }
}

if ($trava) {

  echo 'Erro #-> base com erro de sequencia';
  die();
}
// die('base ok');  
// $linha = substr($linha, 15, -1);
$linha = substr($linha, 0, -1);
//  echo $linha;
// die(); 
try {

    $dbname = 'TALISMA';
    $host = '186.192.255.237';
    // $host = '11.1.1.200';
    $port = '5432';  
    $dbuser = 'postgres';
    $dbpass = '165811';
    $db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  // $sqlIDsFaturas = "select idfatura 
  //                       from faturas f, conta c 
  //                       where f.idconta = c.idconta
  //                       and f.ano = '".$ano."'  
  //                       and f.mes = '".$mes."' and c.nomeusuario in (".$linha.")"; 
      
  // $stmt = $db->query($sqlIDsFaturas);
  // $stmt->execute();
  // $resIDsFaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // $linhaIDsFaturas = '';
  // foreach ($resIDsFaturas as $key => $value)
  //   $linhaIDsFaturas .= $value['idfatura'] . ",";
  // $linhaIDsFaturas = substr($linhaIDsFaturas, 0, -1);

  /*$sql = "SELECT
              f.idfatura,
              c.idconta,
              c.nomeusuario AS NOME_USUARIO,
              (SELECT CAST(CAST(sum (valorservico) AS DECIMAL(18,2)) AS VARCHAR(30))::float8 AS valor_fatura  FROM itensfatura i WHERE i.idfatura = f.idfatura),
              (SELECT CAST(CAST(sum (valorservico) AS DECIMAL(18,2)) AS VARCHAR(30))::float8 AS valor_recebido  FROM itensfatura i WHERE i.idfatura = f.idfatura), 
              f.consumoatual AS consumo_real, 
              f.consumofaturado AS consumo_faturado, 
              TO_CHAR(f.dataleitura, 'DD/MM/YYYY') AS data_leitura,
              TO_CHAR(f.dataemissao, 'DD/MM/YYYY') AS data_emissao,
              TO_CHAR(f.datavencimento, 'DD/MM/YYYY') AS data_vencimento,
              TO_CHAR(f.datapagamento, 'DD/MM/YYYY') AS data_recebimento,
              f.mes,
              (SELECT descricao FROM categoriaimovel WHERE idcatimovel = c.catimovel) AS categoria_imovel
              FROM faturas f,   
              conta c
              WHERE ano = '".$ano."'
              AND mes = '".$mes."'
              AND pago = 'G'
              AND f.idconta = c.idconta";
              --and f.idfatura in (".$linhaIDsFaturas.")"; */
  $sql = "SELECT
              f.idfatura,
              c.idconta,
              c.nomeusuario AS NOME_USUARIO,
              (SELECT CAST(CAST(sum (valorservico) AS DECIMAL(18,2)) AS VARCHAR(30))::float8 FROM itensfatura i WHERE i.idfatura = f.idfatura) as total_fatura,
              (SELECT CAST(CAST(sum (valorservico) AS DECIMAL(18,2)) AS VARCHAR(30))::float8 FROM itensfatura i WHERE i.idfatura = f.idfatura and tiposervico = 90) as total_consumo,
              (SELECT CAST(CAST(sum (valorservico) AS DECIMAL(18,2)) AS VARCHAR(30))::float8 FROM itensfatura i WHERE i.idfatura = f.idfatura and tiposervico = 93) as juros_atraso,
              (SELECT CAST(CAST(sum (valorservico) AS DECIMAL(18,2)) AS VARCHAR(30))::float8 FROM itensfatura i WHERE i.idfatura = f.idfatura and tiposervico = 92) as multa_atraso,
              (SELECT CAST(CAST(sum (valorservico) AS DECIMAL(18,2)) AS VARCHAR(30))::float8 FROM itensfatura i WHERE i.idfatura = f.idfatura and tiposervico = 96) as arredondamento_abaixo,
              (SELECT CAST(CAST(sum (valorservico) AS DECIMAL(18,2)) AS VARCHAR(30))::float8 FROM itensfatura i WHERE i.idfatura = f.idfatura and tiposervico = 127) as arredondamento_acima,
              (SELECT CAST(CAST(sum (valorservico) AS DECIMAL(18,2)) AS VARCHAR(30))::float8 FROM itensfatura i WHERE i.idfatura = f.idfatura and tiposervico not in (90, 93, 92, 96, 127)) as outros_servicos,
              (SELECT CAST(CAST(sum (valorservico) AS DECIMAL(18,2)) AS VARCHAR(30))::float8 FROM itensfatura i WHERE i.idfatura = f.idfatura) as total_recebido, 
              f.consumoatual AS consumo_real, 
              f.consumofaturado AS consumo_faturado, 
              TO_CHAR(f.dataleitura, 'DD/MM/YYYY') AS data_leitura,
              TO_CHAR(f.dataemissao, 'DD/MM/YYYY') AS data_emissao,
              TO_CHAR(f.datavencimento, 'DD/MM/YYYY') AS data_vencimento,
              TO_CHAR(f.datapagamento, 'DD/MM/YYYY') AS data_recebimento,
              f.mes,
              (SELECT descricao FROM categoriaimovel WHERE idcatimovel = c.catimovel) AS categoria_imovel
              FROM faturas f,   
              conta c
              WHERE ano = '".$ano."'
              AND mes = '".$mes."'
              AND pago = 'G'
              AND f.idconta = c.idconta
              and f.idfatura in (".$linha.")";

  $stmt = $db->query($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\Exception $e) {
  die("Could not connect to the database.  Please check your configuration. error:" . $e );
}
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo $mes . '-' . $ano; ?></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <style type="text/css">
    @page {
      size: landscape;
      margin: 0;
    }
    @media print {
    html, body {
        font-size: 8;
    }
  </style>  
</head>
<body>
  <h2>TALISMÃ <?php echo $mes . '/' . $ano ?></h2>
  <table class="table table-striped table-sm" style="font-size: small;">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">FATURA</th>
        <th scope="col">CONTA</th>
        <th scope="col">NOME USUARIO</th>
        <th scope="col">VALOR TOTAL</th>
        <th scope="col">VALOR CONSUMO</th>
        <th scope="col">JUROS ATRASO</th>
        <th scope="col">MULTA ATRASO</th>
        <th scope="col">ARRED. ABAIXO</th>
        <th scope="col">ARRED. ACIMA</th>
        <th scope="col">OUTROS SERVIÇOS</th>
        <th scope="col">VALOR RECEBIDO</th>
        <th scope="col">CONSUMO REAL</th>
        <th scope="col">CONSUMO FATURADO</th>
        <th scope="col">DT. LEITURA</th>
        <th scope="col">DT. EMISSAO</th>
        <th scope="col">DT. VENCIMENTO</th>
        <th scope="col">DT. RECEBIMENTO</th>
        <th scope="col">CATEGORIA IMOVEL</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $valorTotal = 0; 
        $i = 1;
        foreach ($result as $key => $value) { 
           if ($valorTotal <= $limite) {
      ?>
        <tr>
          <th scope="row"><?php echo $i; ?></th>
          <td><?php echo $value['idfatura']; ?></td>
          <td><?php echo $value['idconta']; ?></td>
          <td><?php echo $value['nome_usuario']; ?></td>
          <td><?php echo 'R$ ' . number_format($value['total_fatura'], 2, ',', '.'); ?></td>
          <td><?php echo 'R$ ' . number_format($value['total_consumo'], 2, ',', '.'); ?></td>
          <td><?php echo 'R$ ' . number_format($value['juros_atraso'] ?? 0, 2, ',', '.'); ?></td>
          <td><?php echo 'R$ ' . number_format($value['multa_atraso'] ?? 0, 2, ',', '.'); ?></td>
          <td><?php echo 'R$ ' . number_format($value['arredondamento_abaixo'] ?? 0, 2, ',', '.'); ?></td>
          <td><?php echo 'R$ ' . number_format($value['arredondamento_acima'] ?? 0, 2, ',', '.'); ?></td>
          <td><?php echo 'R$ ' . number_format($value['outros_servicos'] ?? 0, 2, ',', '.'); ?></td>
          <td><?php echo 'R$ ' . number_format($value['total_recebido'], 2, ',', '.'); ?></td>
          <td><?php echo $value['consumo_real']; ?></td>
          <td><?php echo $value['consumo_faturado']; ?></td>
          <td><?php echo $value['data_leitura']; ?></td>
          <td><?php echo $value['data_emissao']; ?></td>
          <td><?php echo $value['data_vencimento']; ?></td>
          <td><?php echo $value['data_recebimento']; ?></td>
          <td><?php echo $value['categoria_imovel']; ?></td>
        </tr>
      <?php
            $valorTotal += $value['total_fatura'];   
            $i++;
          }
        } 
      ?>
      <h2><?php echo 'Valor Total: R$ '. number_format($valorTotal, 2, ',', '.'); ?></h2>
    </tbody>
  </table>
</body>
</html>
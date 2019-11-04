<?php 

$dbname = 'ITAGUATINS';
// $host = '186.192.255.237';
$host = '11.1.1.200';
$port = '5432';  
$dbuser = 'postgres';
$dbpass = '165811';
$db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sqlContas = "SELECT 
                c.idconta,
                c.nomeusuario,
                (select l.nome from logradouros l where l.idlogradouro = c.idlogra),
                numero,
                (select descricao from categoriaimovel ct where ct.idcatimovel = c.catimovel),
                c.hidrometro,
                (case dtsupensao
                    WHEN '1900-01-01' THEN 'ATIVO'
                    ELSE 'SUSPENSO'
                end) as situacao
            from conta c
            order by c.nomeusuario, c.idconta, c.catimovel;";
$stmt = $db->query($sqlContas);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Relação de Usuários</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <style type="text/css">
    @page {
      size: portrait;
      margin: auto;
    }
    @media print {
    html, body {
        font-size: 8;
    }
  </style>  
</head>
<body>
  <h2>RELAÇÃO DE USUARIOS - ITAGUATINS</h2>
  <table class="table table-striped table-sm" style="font-size: small;">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">CONTA</th>
        <th scope="col">NOME USUARIO</th>
        <th scope="col">LOGRADOURO</th>
        <th scope="col">NUMERO</th>
        <th scope="col">HIDROMETRO</th>
        <th scope="col">SITUACAO</th>
    </thead>
    <tbody>
      <?php 
        $i = 1;
        foreach ($result as $key => $value) { 
        ?>
        <tr>
          <th scope="row"><?php echo $i; ?></th>
          <td><?php echo $value['idconta']; ?></td>
          <td><?php echo $value['nomeusuario']; ?></td>
          <td><?php echo $value['nome']; ?></td>
          <td><?php echo $value['numero']; ?></td>
          <td><?php echo $value['hidrometro']; ?></td>
          <td><?php echo $value['situacao']; ?></td>
        </tr>
        <?php
            $sqlFaturas = "SELECT
                            f.leituraatual,
                            f.consumofaturado,
                            f.idfatura,
                            f.mes,
                            f.ano,
                            (select 
                                CAST(CAST(sum (i.valorservico) AS DECIMAL(18,2)) AS VARCHAR(30))::float8 AS valor_fatura
                                from itensfatura i
                                where i.idfatura = f.idfatura),
                            (case f.pago
                                when 'A' then 'ABERTO'
                                when 'G' then 'PAGO'
                            end) as situacao
                          from faturas f
                          where idconta = " .$value['idconta'] . "
                          order by f.idfatura desc
                          limit 3";
            $stmt = $db->query($sqlFaturas);
            $stmt->execute();
            $resultFaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <tr style="text-align: center;">
            <td colspan="7">
                <table class="table table-sm">
                      <thead class="thead-dark">
                        <th scope="col">IDFATURA</th>
                        <th scope="col">LEITURA ATUAL</th>
                        <th scope="col">CONSUMO FATURADO</th>
                        <th scope="col">MES/ANO</th>
                        <th scope="col">VALOR</th>
                        <th scope="col">SITUACAO</th>
                      </thead>  
                      <tbody>  
                        <?php foreach ($resultFaturas as $fat => $fatura) { ?>
                          <tr>
                            <td><?php echo $fatura['idfatura']; ?></td>
                            <td><?php echo $fatura['leituraatual']; ?></td>
                            <td><?php echo $fatura['consumofaturado']; ?></td>
                            <td><?php echo $fatura['mes'] . '/' . $fatura['ano']; ?></td>
                            <td><?php echo $fatura['valor_fatura']; ?></td>
                            <td><?php echo $fatura['situacao']; ?></td>
                        </tr>
                        <?php } ?>
                      </tbody>  
                </table>
            </td>
        </tr>
    <?php 
        $i++;
        }
     ?>
    </tbody>
  </table>
</body>
</html>

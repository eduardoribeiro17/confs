<?php
die();
$dbname = 'BOMJESUSTO';
$host = '11.1.1.200';
$port = '5432';  
$dbuser = 'postgres';
$dbpass = '165811';
$db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);

$sqlDezembro = "select idconta from prefaturamento where ano = '2018' and mes = '12' and idsetor in (3,4)";

$stmt = $db->query($sqlDezembro);
$stmt->execute();
$dezembro = $stmt->fetchAll(PDO::FETCH_ASSOC);

 
foreach ($dezembro as $key => $value) {
    $sqlJaneiro = "select latual from prefaturamento where idconta = " . $value['idconta'] . " and ano = '2019' and mes = '01' AND idsetor IN ( 3,4 )";
    $stmt = $db->query($sqlJaneiro);
    $stmt->execute();
    $leituraAtualJaneiro = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $sql = "update prefaturamento set latual = " . $leituraAtualJaneiro['latual'] . " where ano = '2018' and mes = '12' and idconta = " . $value['idconta'] .";";
    $stmt = $db->query($sql);
    // $stmt->execute();
}


    <?php 
die();
$dbname = 'ITUPIRANGA';
// $host = '186.192.255.237';
$host = '11.1.1.200';
$port = '5432';  
$dbuser = 'postgres';
$dbpass = '165811';
$db = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo 'Conectado com o servidor <br />';
// $sqlContasAlvo = "SELECT
//                       f.idfatura,
//                       f.idconta,
//                       i.valorservicoEI
//                       FROM itensfatura i left join faturas f on i.idfatura = f.idfatura
//                     WHERE i.ano = '2019'
//                          and i.tiposervico = 96;";   
// 
$sqlContasAlvo = "SELECT
                      f.idconta,
                      CAST(CAST(sum (valorservico) AS DECIMAL(18,2)) AS VARCHAR(30))::float8 as valorservico
                      FROM itensfatura i left join faturas f on i.idfatura = f.idfatura
                        WHERE i.ano in ('2016')
                         and i.mes in ('07', '08')
                         and i.tiposervico = 96
                         group by f.idconta
                         order by valorservico desc";
          // die($sqlContasAlvo);
echo '<br/> Buscando Contas Alvo...';                         
$stmt = $db->prepare($sqlContasAlvo);
$stmt->execute();
$contasAlvo = $stmt->fetchAll(PDO::FETCH_ASSOC);
$contador = 1;
$totalRetornado = 0;

echo '<br /> Removendo Duplicidade Arredondamento Mes Anterior...';
$sqlLimpa = "DELETE FROM itensfatura WHERE ano = '2019' and mes = '06' and tiposervico in (127)";
$stmt = $db->prepare($sqlLimpa);
$stmt->execute();

echo '<br /> Inserindo Valores... <br/>';
foreach ($contasAlvo as $key => $contaAlvo) {
    
    if ($contaAlvo) {
        
        if ($contaAlvo['idconta']) {

            $sqlFaturaAtual = "SELECT idfatura,sequencia FROM itensfatura WHERE idfatura in (SELECT idfatura FROM faturas WHERE idconta = " . $contaAlvo['idconta'] . ") and ano = '2019' and mes = '06'";
            // echo $sqlFaturaAtual . '<br/>';
            $stmt = $db->prepare($sqlFaturaAtual);
            $stmt->execute();
            $faturaAtual = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($faturaAtual) {
                
                $sqlInsert = "INSERT INTO itensfatura (ano, 
                                                        codigoservico, 
                                                        idempresa, 
                                                        idfatura, 
                                                        mes, 
                                                        orservico, 
                                                        parcela,    
                                                        referencia, 
                                                        sequencia, 
                                                        tiposervico, 
                                                        valorservico) 
                            VALUES ('2019',
                                        0, 
                                        1, 
                                        " . $faturaAtual->idfatura . ", 
                                        '06', 
                                        'A', 
                                        '1/1', 
                                        '', 
                                        " . ($faturaAtual->sequencia + 1) . ", 
                                        127, 
                                        " . $contaAlvo['valorservico'] . ");";
                $stmt = $db->prepare($sqlInsert);
                $result = $stmt->execute();
                echo 'Conta: ' . $contaAlvo['idconta'] . ' -> Fatura: ' . $faturaAtual->idfatura . '-> Valor: ' . $contaAlvo['valorservico'] . '<br />';
                $contador++;
                $totalRetornado += $contaAlvo['valorservico'];
            }
        }
    }    
}

echo '<br /> Removendo Arredondamento Zerado...';
$sqlZerados = "DELETE FROM itensfatura WHERE ano = '2019' and mes = '06' and tiposervico in (127) and valorservico = 0";
$stmt = $db->prepare($sqlZerados);
$stmt->execute();
echo '<br /> Alterando Data Anterior...';
$sqlDataAnterior = "UPDATE faturas SET dataanterior = '2019-05-22', dataleitura = '2019-06-21' WHERE ano = '2019' and mes = '06'";
$stmt = $db->prepare($sqlDataAnterior);
$stmt->execute();

echo 'Total de Contas/Faturas: ' . $contador . '<br />';
// echo 'Total Retomado: ' . $totalRetornado;e
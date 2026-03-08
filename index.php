<?php
require 'vendor/autoload.php';
require 'config.php';
use Dompdf\Options;
use Dompdf\Dompdf;
$options = new Options();
$options->set('isRemoteEnabled',true);

$db = new conect();

$conn = $db->conn();

$sql = $conn->query( "SELECT pagamento.id, propina.classe,propina.classe,propina.valor,curso.nome AS curso, perfil.nome, pagamento.tipo_pagamento, pagamento.criado_em FROM `pagamento` JOIN propina ON pagamento.propina_id = propina.id JOIN curso on propina.curso_id = curso.id JOIN aluno ON pagamento.aluno_id = aluno.id JOIN matricula ON aluno.matricula_id = matricula.id JOIN perfil ON matricula.usuario_id = perfil.usuario_id WHERE pagamento.id = '1' ");


$rows = $sql->fetch_assoc();
$html = '
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Comprovativo Escolar</title>

    <style>

        body{
            font-family: Arial, Helvetica, sans-serif;
            background:#f4f4f4;
        }

        .comprovativo{
            width:750px;
            margin:auto;
            background:white;
            padding:30px;
            border:1px solid #ccc;
        }

        .topo{
            display:flex;
            align-items:center;
            justify-content:space-between;
        }

        .logo{
            width:90px;
        }

        .escola{
            text-align:center;
            flex:1;
        }

        .escola h2{
            margin:0;
        }

        .titulo{
            text-align:center;
            margin-top:20px;
            font-size:20px;
            font-weight:bold;
        }

        .linha{
            border-bottom:2px solid #000;
            margin-top:10px;
        }

        .info{
            margin-top:25px;
        }

        .info p{
            font-size:16px;
            margin:10px 0;
        }

        .assinatura{
            margin-top:60px;
            display:flex;
            justify-content:space-between;
        }

        .assinatura div{
            text-align:center;
        }

        .rodape{
            margin-top:30px;
            text-align:center;
            font-size:13px;
            color:#666;
        }
    </style>
</head>
<body>
    <div class="comprovativo">
        <div class="topo">
            <div class="escola"> 
                <h2>Colégio Felizander</h2>
                <p>Sistema Escolar</p>
            </div>
        </div>
        <div class="titulo">
            COMPROVATIVO DE PAGAMENTO
        </div>
        <div class="linha"></div>
                <div class="info">
                    <p><strong>Nº: </strong> '. $rows['id'].'</p>
                    <p><strong>Nome do Aluno:</strong> '. $rows['nome'].'</p>
                    <p><strong>Classe:</strong> '. $rows['classe'].' ª</p>
                    <p><strong>Curso:</strong> '. $rows['curso'].'</p>
                    <p><strong>Valor Pago:</strong> '. $rows['valor'].' Kz</p>
                    <p><strong>Data:</strong>  '. $rows['criado_em'].'</p>
                    <p><strong>tipo de pagamento :</strong> '. $rows['tipo_pagamento'].'</p>
                </div>
            <div class="assinatura">
        <div>
        <p>________________________</p>
        <p>Assinatura</p>
    </div>
</body>
</html>
';

$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
// Renderiza o HTML como PDF
$dompdf->render();

// Envia o PDF gerado para o navegador
$dompdf->stream();
echo $html;
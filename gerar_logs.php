<?php

function gerarLogs()
{
    for ($i = 0; $i < 100; $i++) {
        $dia = rand(1, 28);
        $mes = rand(1, 12);

        $hora = rand(0, 23);
        $min = rand(0, 59);
        $sec = rand(0, 59);

        $date = '2018-' . $mes . '-' . $dia . ' ' . $hora . ':' . $min . ':' . $sec;

        $date = date('Y-m-d H:i:s', strtotime($date));

        $msg = sprintf("[%s] - %s%s", $date, 'Abertura da Porta OK', PHP_EOL);
        file_put_contents('main.log', $msg, FILE_APPEND);
    }

    return true;
}
<?php

if ( empty( $_FILES['arquivoLog'] ) ) {
    echo json_encode( ['code' => 0, 'text' => 'Por favor, verifique o arquivo.'] );
    exit;
}else{

    echo json_encode( ['code' => 1,  'text' => totalEntradaBanco($_FILES)] );
    exit;
}

function totalEntradaBanco($arquivo)
{
    $ponteiro = fopen ($arquivo['arquivoLog']['tmp_name'], "r");
    $dataAbertura = [];
    while (!feof ($ponteiro)) {

        $linha = trim(fgets($ponteiro));

        if(!empty($linha)) {

            if (preg_match("/^(\[\d{4}-\d{1,2}-\d{1,2} ([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]\] - Abertura da Porta OK)$/",
                $linha)) {

                $linha = explode(' - ', $linha);
                $dataHora = preg_replace(['/^\[+/', '/\]+$/'], '', $linha[0]);

                $dataHora = explode(' ', $dataHora);
                $data = $dataHora[0];
                $hora = $dataHora[1];
                $diaSemana = date('w', strtotime($data));

                if ($diaSemana > 0 && $diaSemana < 6) {

                    if( date('H:i:s', strtotime($hora)) >= date('H:i:s', strtotime('10:00:00')) && date('H:i:s', strtotime($hora)) <= date('H:i:s', strtotime('16:00:00'))){

                        if( array_key_exists($data, $dataAbertura)  ){
                            $dataAbertura[$data] = $dataAbertura[$data] + 1;
                        }else{
                            $dataAbertura[$data] = 1;
                        }
                    }

                }

            }
        }


    }

    fclose ($ponteiro);

    return $dataAbertura;
}

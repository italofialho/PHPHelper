<?php 

class convertData
{

    public $timeStamp;
    public $hours;
    public $timeZone;

    function __construct($timeStamp, $hours = false, $timeZone = "America/Sao_Paulo"){

        $this->timeStamp = strtotime($timeStamp);
        $this->hours = $hours;
        $this->timeZone = $timeZone;
    }

    public function getDiaSemana(){
        $diaSemana = date("w", $this->timeStamp);   
        switch($diaSemana){
            case 0:
                $diaNome = "Domingo";
                break;
            case 1:
                $diaNome = "Segunda";
                break;
            case 2:
                $diaNome = "Terça";
                break;
            case 3:
                $diaNome = "Quarta";
                break;
            case 4:
                $diaNome = "Quinta";
                break;
            case 5:
                $diaNome = "Sexta";
                break;
            default:
                $diaNome = "Sábado";
                break;
        }
        
        return $diaNome;
    }


    public function getMes(){

        $mes = date("m", $this->timeStamp);

        switch($mes){
            case 01:
                $mesNome = "Janeiro";
                break;
            case 02:
                $mesNome = "Fevereiro";
                break;
            case 03:
                $mesNome = "Março";
                break;
            case 04:
                $mesNome = "Abril";
                break;
            case 05:
                $mesNome = "Maio";
                break;
            case 06:
                $mesNome = "Junho";
                break;
            case 07:
                $mesNome = "Julho";
                break;
            case 08:
                $mesNome = "Agosto";
                break;
            case 09:
                $mesNome = "Setembro";
                break;
            case 10:
                $mesNome = "Outubro";
                break;
            case 11:
                $mesNome = "Novembro";
                break;
            default: 
                $mesNome = "Dezembro";
                break;

        }

        return $mesNome;
        
    }

    public function getAno($ano = "Y"){
        return date($ano, $this->timeStamp);
    }

    public function getDia(){
        return date("d", $this->timeStamp);
    }

    public function getHora(){
        if($this->hours == true){
           return date("H:i", $this->timeStamp);
        }
    }

    public function getDataCompleta(){

        date_default_timezone_set($this->timeZone);

        if ($this->hours) {
            return $this->getDiaSemana().", ".$this->getDia()." de ".$this->getMes()." de ".$this->getAno()." - ".$this->getHora();
        } else {
            return $this->getDiaSemana().", ".$this->getDia()." de ".$this->getMes()." de ".$this->getAno();
        }
    }
}
?>
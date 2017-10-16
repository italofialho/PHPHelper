<?php

class convertData
{
    
    public $timeStamp;
    public $hours;
    public $timeZone;
    
    function __construct($timeStamp, $hours = false, $timeZone = "America/Sao_Paulo")
    {
        
        $this->timeStamp = strtotime($timeStamp);
        $this->hours     = $hours;
        $this->timeZone  = $timeZone;
    }
    
    public function getDiaSemana()
    {
        $diaSemana = date("w", $this->timeStamp);
        switch ((int) $diaSemana) {
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
            case 6:
                $diaNome = "Sábado";
                break;
            default:
                return false;
                break;
        }
        
        return $diaNome;
    }
    
    
    public function getMes()
    {
        
        $mes = date("m", $this->timeStamp);
        
        switch ((int) $mes) {
            case 1:
                $mesNome = "Janeiro";
                break;
            case 2:
                $mesNome = "Fevereiro";
                break;
            case 3:
                $mesNome = "Março";
                break;
            case 4:
                $mesNome = "Abril";
                break;
            case 5:
                $mesNome = "Maio";
                break;
            case 6:
                $mesNome = "Junho";
                break;
            case 7:
                $mesNome = "Julho";
                break;
            case 8:
                $mesNome = "Agosto";
                break;
            case 9:
                $mesNome = "Setembro";
                break;
            case 10:
                $mesNome = "Outubro";
                break;
            case 11:
                $mesNome = "Novembro";
                break;
            case 12:
                $mesNome = "Dezembro";
                break;
            default:
                return false;
                break;
                
        }
        
        return $mesNome;
        
    }
    
    public function getAno($ano = "Y")
    {
        return date($ano, $this->timeStamp);
    }
    
    public function getDia()
    {
        return date("d", $this->timeStamp);
    }
    
    public function getHora()
    {
        if ($this->hours == true) {
            return date("H:i", $this->timeStamp);
        }
    }
    
    public function getDataCompleta()
    {
        
        date_default_timezone_set($this->timeZone);
        
        if ($this->hours) {
            return $this->getDiaSemana() . ", " . $this->getDia() . " de " . $this->getMes() . " de " . $this->getAno() . " - " . $this->getHora();
        } else {
            return $this->getDiaSemana() . ", " . $this->getDia() . " de " . $this->getMes() . " de " . $this->getAno();
        }
    }
}
?>
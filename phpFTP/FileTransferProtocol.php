<?php

class FileTransferProtocol
{
    private $host = null;
    private $port = null;
    private $user = null;
    private $pass = null;
    private $login = null;
    private $connection = null;
    private $file = null;
    private $localFile = null;
    private $result = array();
    private $canContinue = true;
    private $debug = null;
    private $totalFiles = 0;
    
    function __construct($ftp_host, $ftp_port = '21', $ftp_user_name, $ftp_user_pass, $debug = null)
    {
        $this->host  = $ftp_host;
        $this->port  = $ftp_port;
        $this->user  = $ftp_user_name;
        $this->pass  = $ftp_user_pass;
        $this->debug = $debug;
        
        ini_set('max_execution_time', 0);
    }
    
    public function sendFile($file, $localFile)
    {
        $this->file      = $file;
        $this->localFile = $localFile;
        
        if ($this->openConnection() && $this->loginOnServer()) {
            if ($this->canContinue === true && !$this->checkIfFileExist()) {
                if (@ftp_put($this->connection, $this->file, $this->localFile, FTP_BINARY)) {
                    array_push($this->result, "Arquivo transferido com sucesso: " . basename($this->localFile));
                } else {
                    array_push($this->result, "Tivemos um problema para transferir o arquivo: " . basename($this->localFile));
                }
            }
            $this->totalFiles++;
        }
    }
    
    private function openConnection()
    {
        if (is_null($this->connection)) {
            $this->connection = ftp_connect($this->host, $this->port);
        } else {
            array_push($this->result, "Já estamos conectados ao servidor FTP.");
        }
        
        if ($this->connection) {
            array_push($this->result, "Encontramos o servidor FTP.");
            return true;
        } else {
            $this->canContinue = false;
            array_push($this->result, "Não foi possivel encontrar o servidor FTP.");
            return false;
        }
    }
    
    public function getResult()
    {
        if ($this->debug == 0) {
            var_dump($this->result);
        } else if ($this->debug == 1) {
            foreach ($this->result as $key => $value) {
                echo ("$value <br>");
            }
            echo ("Total de arquivos processados: $this->totalFiles. <br>");
        } else {
            return $this->result;
        }
    }
    
    private function loginOnServer()
    {
        if ($this->canContinue && (isset($this->connection)) && !is_null($this->connection) && isset($this->user) && !empty($this->user) && isset($this->pass) && !empty($this->pass)) {
            
            if (is_null($this->login)) {
                $this->login = ftp_login($this->connection, $this->user, $this->pass);
            } else {
                array_push($this->result, "Já estamos autenticado no servidor FTP.");
            }
            
            if ($this->login) {
                array_push($this->result, "Conectado ao servidor FTP.");
                return true;
            } else {
                $this->canContinue = false;
                array_push($this->result, "Não foi possivel conectar com o servidor FTP.");
                return false;
            }
        } else {
            $this->canContinue = false;
            array_push($this->result, "Não foi possivel conectar com o servidor FTP. Informações incorretas.");
            return false;
        }
    }
    
    public function closeConnection()
    {
        if ($this->connection) {
            ftp_close($this->connection);
            $this->reset();
            array_push($this->result, "Conexão encerrada com o servidor FTP.");
        } else {
            array_push($this->result, "Conexão já foi encerrada com o servidor FTP.");
        }
        
    }
    
    private function checkIfFileExist()
    {
        $listing = @ftp_nlist($this->connection, $this->file);
        if ($listing == false) {
            array_push($this->result, "Não encontramos o arquivo desejado.");
            return false;
        } else {
            array_push($this->result, "Encontramos o arquivo: " . basename($this->file));
            return true;
        }
    }
    
    public function getLastModifiedDate()
    {
        $buff = ftp_mdtm($this->connection, $this->file);
        
        if ($buff != -1) {
            array_push($this->result, "" . basename($this->file) . " foi modificado pela última vez em: <b>" . date("F d Y H:i:s.", $buff) . "</b>.");
        } else {
            array_push($this->result, "Não foi possível verificar a ultima data de modificação.");
        }
    }
    
    private function reset()
    {
        $this->connection  = null;
        $this->login       = null;
        $this->file        = null;
        $this->localFile   = null;
        $this->canContinue = true;
    }
}


?>
<?php 

class FileTransferProtocol  
{
    private $host;
    private $user;
    private $pass;
    private $login;
    private $connection = null;
    private $file;
    private $localFile;
    private $result = array();
    private $canContinue = true;
    private $debug;

    function __construct($ftp_host, $ftp_user_name, $ftp_user_pass, $debug = null){
        $this->host = $ftp_host;
        $this->user = $ftp_user_name;
        $this->pass = $ftp_user_pass;
        $this->debug = $debug;
    }

    public function sendFile($file, $localFile){
        $this->file = $file;
        $this->localFile = $localFile;

        $this->openConnection();
        $this->loginOnServer();

        if(!$this->checkIfFileExist()){
            if(ftp_put($this->connection, $this->file, $this->localFile, FTP_BINARY)){
                array_push($this->result, "WOOT! Arquivo transferido com sucesso: $this->file.");
            }else{
                array_push($this->result, "Doh! Tivemos um problema para transferir o arquivo.");
            }
        }

        $this->closeConnection();

        return $this->result;
    }

    private function openConnection(){
		if(isset($this->host) && is_null($this->connection)){
            $this->connection = ftp_connect($this->host);
            if($this->connection){
                array_push($this->result, "WOOT! Encontramos o servidor FTP.");
            }else{
                $this->canContinue = false;
                array_push($this->result, "Doh! Não foi possivel encontrar o servidor FTP.");
            }
		}
    }
	
	public function getResult(){
        if($this->debug == 0){
            var_dump($this->result);
        }else if($this->debug == 0){
            foreach ($this->result as $key => $value) {
                echo("$value <br>");
            }
        }else{
            return $this->result;
        }
	}

    private function loginOnServer(){
		if($this->canContinue && !is_null($this->connection) && isset($this->user) && !empty($this->user) && isset($this->pass) && !empty($this->pass) && $this->connection){
            $this->login = ftp_login($this->connection, $this->user, $this->pass);
            if($this->connection){
                array_push($this->result, "WOOT! Conectado ao servidor FTP.");
            }else{
                $this->canContinue = false;
                array_push($this->result, "Doh! Não foi possivel conectar com o servidor FTP.");
            }
		}else{
            $this->canContinue = false;
            array_push($this->result, "Doh! Não foi possivel conectar com o servidor FTP. Informações incorretas");
		}
    }

    private function closeConnection(){
        if($this->connection){
            ftp_close($this->connection);
            array_push($this->result, "WOOT! Conexão encerrada com o servidor FTP.");
        }else{
            array_push($this->result, "Doh! Conexão já foi encerrada com o servidor FTP.");
        }
        
    }

    private function checkIfFileExist(){
        $listing = @ftp_nlist($this->connection, $this->file);
        if($listing == false) {
            array_push($this->result, "Doh! Não encontramos o arquivo desejado.");
            return false;
        }else{
            array_push($this->result, "WOOT! Encontramos o arquivo: $this->file");
            return true;
        }   
    }

    public function getLastModifiedDate(){
        $buff = ftp_mdtm($this->connection, $this->file);
        
        if ($buff != -1) {
            array_push($this->result, "WOOT! $this->file foi modificado pela última vez em: <b>" . date("F d Y H:i:s.", $buff)."</b>");
        } else {
            array_push($this->result, "Doh! Não foi possível verificar a ultima data de modificação.");
        }
    }
}


?>
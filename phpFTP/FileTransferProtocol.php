<?php 

class FileTransferProtocol  
{
    private $host = null;
    private $user = null;
    private $pass = null;
    private $loginc = null;
    private $connection = null;
    private $file = null;
    private $localFile = null;
    private $result = array();
    private $canContinue = true;
    private $debug = null;

    function __construct($ftp_host, $ftp_user_name, $ftp_user_pass, $debug = null){
        $this->host = $ftp_host;
        $this->user = $ftp_user_name;
        $this->pass = $ftp_user_pass;
        $this->debug = $debug;
    }

    public function sendFile($file, $localFile){
        $this->file = $file;
        $this->localFile = $localFile;
        
        if($this->openConnection() && $this->loginOnServer()){
            if($this->canContinue === true && !$this->checkIfFileExist()){
                if(ftp_put($this->connection, $this->file, $this->localFile, FTP_BINARY)){
                    array_push($this->result, "WOOT! Arquivo transferido com sucesso: $this->file.");
                }else{
                    array_push($this->result, "Doh! Tivemos um problema para transferir o arquivo.");
                }
            }

            $this->closeConnection();
        }
    }

    private function openConnection(){
		if(is_null($this->connection)){
            $this->connection = ftp_connect($this->host);
            if($this->connection){
                array_push($this->result, "WOOT! Encontramos o servidor FTP.");
                return true;
            }else{
                $this->canContinue = false;
                array_push($this->result, "Doh! Não foi possivel encontrar o servidor FTP.");
                return false;
            }
        }
    }
	
	public function getResult(){
        if($this->debug == 0){
            var_dump($this->result);
        }else if($this->debug == 1){
            foreach ($this->result as $key => $value) {
                echo("$value <br>");
            }
        }else{
            return $this->result;
        }
	}

    private function loginOnServer(){
		if($this->canContinue && (isset($this->connection)) && !is_null($this->connection) && isset($this->user) && !empty($this->user) && isset($this->pass) && !empty($this->pass)){
            
            $this->login = ftp_login($this->connection, $this->user, $this->pass);
            if($this->login){
                array_push($this->result, "WOOT! Conectado ao servidor FTP.");
                return true;
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
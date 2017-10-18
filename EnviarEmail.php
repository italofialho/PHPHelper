<?php

class EnviarEmail
{
    
    private $pdo;
    private $mail;
    private $log = array();
    
    public $nomeEmail;
    public $paraEmail;
    public $assuntoEmail;
    public $conteudoEmail;
    public $confirmacao;
    public $mensagem;
    public $anexo;
    public $copiaEmail;
    public $copiaOculta;
    public $copiaNome;
    public $nomeCopiaOculta;
    public $configHost;
    public $configPort;
    public $configUsuario;
    public $configSenha;
    public $remetenteEmail;
    public $remetenteNome;
    public $erroMsg;
    public $confirmacaoErro;
    
    
    function __construct()
    {
        require_once('class.phpmailer.php');
        $this->mail = new PHPMailer();
    }
    
    public function prepare()
    {
        $this->mail->IsSMTP();
        $this->mail->Host     = $this->configHost;
        $this->mail->SMTPAuth = true;
        $this->mail->Port     = $this->configPort;
        $this->mail->Username = $this->configUsuario;
        $this->mail->Password = $this->configSenha;
        
        $this->mail->From     = $this->remetenteEmail;
        $this->mail->FromName = $this->remetenteNome;
        
        if (isset($this->paraEmail)) {
            $this->mail->AddAddress($this->paraEmail, $this->nomeEmail);
        }
        
        if (isset($this->copiaEmail)) {
            $this->mail->AddCC($this->copiaEmail, $this->copiaNome);
        }
        
        if (isset($this->copiaOculta)) {
            $this->mail->AddBCC($this->copiaOculta, $this->nomeCopiaOculta);
        }
        
        $this->mail->IsHTML(true);
        $this->mail->CharSet = 'utf-8';
        
        $this->mail->Subject = $this->assuntoEmail;
        $this->mail->Body    = $this->conteudoEmail;
        $this->mail->AltBody = "Por favor verifique seu leitor de email.";
        
        if (!empty($this->anexo)) {
            $this->mail->AddAttachment($this->anexo);
        }
        
        array_push($this->log, "Email preparado para o envio.");
    }
    
    public function send()
    {
        array_push($this->log, "Enviando ...");
        $enviado = $this->mail->Send();
        
        $this->reset();
        
        if ($this->confirmacao == 1) {
            if ($enviado) {
                array_push($this->log, "Email enviado.");
            } else {
                array_push($this->log, $this->erroMsg);
                if ($this->confirmacaoErro == 1) {
                    array_push($this->log, $this->mail->ErrorInfo);
                }
            }
        }
    }
    
    private function reset()
    {
        $this->mail->ClearAllRecipients();
        $this->mail->ClearAttachments();
    }
    
    public function getLog()
    {
        return $this->error;
    }
}


?> 
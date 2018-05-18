<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public function __construct()
    {
        parent::__Construct();

        if(!$this->session->userdata('logged_in')) {
            redirect(base_url());
        }

        $this->layout->debug['active'] = true;
        
        $this->layout->title('Ocomon');
        $this->layout->company = 'Ocomon V3';

        $this->layout->meta(meta('Content-type','text/html; charset=utf-8'));
        $this->layout->meta(meta('content-language','pt-PT'));
        $this->layout->meta(meta('robots','noindex,nofollow'));
        $this->layout->meta(meta('Cache-control','no-cache'));
        $this->layout->meta(meta('pragma','no-cache'));

        
        
        $this->layout->css( array(
            'vendor/bootstrap/css/bootstrap.min',
            'vendor/metisMenu/metisMenu.min',
            'dist/sb-admin-2',
            'vendor/font-awesome/css/font-awesome.min'
        ));

        $this->layout->js(array(
            'css/vendor/jquery/jquery.min',
            'css/vendor/bootstrap/js/bootstrap.min',
            'css/vendor/metisMenu/metisMenu.min',
            'js/sb-admin-2'
        ));

        



    }

    private function send_email($message,$subject,$sendTo){
        require_once APPPATH.'libraries/mailer/class.phpmailer.php';
        require_once APPPATH.'libraries/mailer/class.smtp.php';
        require_once APPPATH.'libraries/mailer/mailer_config.php';
        include APPPATH.'libraries/mailer/template/template.php';
        
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        try
        {
            $mail->SMTPDebug = 1;  
            $mail->SMTPAuth = true; 
            $mail->SMTPSecure = 'ssl'; 
            $mail->Host = HOST;
            $mail->Port = PORT;  
            $mail->Username = GUSER;  
            $mail->Password = GPWD;     
            $mail->SetFrom(GUSER, 'Administrator');
            $mail->Subject = "DO NOT REPLY - ".$subject;
            $mail->IsHTML(true);   
            $mail->WordWrap = 0;


            $hello = '<h1 style="color:#333;font-family:Helvetica,Arial,sans-serif;font-weight:300;padding:0;margin:10px 0 25px;text-align:center;line-height:1;word-break:normal;font-size:38px;letter-spacing:-1px">Hello, &#9786;</h1>';
            $thanks = "<br><br><i>This is autogenerated email please do not reply.</i><br/><br/>Thanks,<br/>Admin<br/><br/>";

            $body = $hello.$message.$thanks;
            $mail->Body = $header.$body.$footer;
            $mail->AddAddress($sendTo);

            if(!$mail->Send()) {
                $error = 'Mail error: '.$mail->ErrorInfo;
                return array('status' => false, 'message' => $error);
            } else { 
                return array('status' => true, 'message' => '');
            }
        }
        catch (phpmailerException $e)
        {
            $error = 'Mail error: '.$e->errorMessage();
            return array('status' => false, 'message' => $error);
        }
        catch (Exception $e)
        {
            $error = 'Mail error: '.$e->getMessage();
            return array('status' => false, 'message' => $error);
        }
        
    }

}

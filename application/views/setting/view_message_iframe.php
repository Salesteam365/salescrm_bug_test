
                <?php 
                    error_reporting(0);
                    ini_set('display_errors', 0);
                    $data= ['mail'=> ['username'=>$email_details['email_id'], 'password'=>$email_details['email_password']]];   
                	$mail_handle=imap_open("{".$email_details['smtp_host'].":993/ssl}",$data['mail']['username'],$data['mail']['password']);
                	if($mail_handle){
                		$headers=imap_headers($mail_handle);
                	    $n=$_GET['inbx']; 
                	    $st = imap_fetchstructure($mail_handle, $n); 
                    	 if (!empty($st->parts)) { 
                    	     for ($i = 0, $j = count($st->parts); $i < $j; $i++) {
                    	         //echo'<pre>';
                    	        $part = $st->parts[$i]; 
                    	         if ($part->subtype == 'HTML'){
                    	             $body = imap_fetchbody($mail_handle, $n, $i+1); 
                    	         } 
                    	         
                    	     } //die;
                    	     
                    	 } else { $body = imap_body($mail, $n); } 
                        echo quoted_printable_decode($body);
                      //echo base64_decode($data);
                   } ?>
              
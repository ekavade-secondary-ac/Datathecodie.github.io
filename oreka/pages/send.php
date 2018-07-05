  <?

        $mailto="ascentengg@gmail.com";
        $file="home.html";
        $pcount=0;
        $gcount=0;
        $subject = "Mail from contact Form";

        $from="d.dagade@ascentengineering.co.in";
        while (list($key,$val)=each($_POST))
        {
        $pstr = $pstr."$key : $val \n ";
        ++$pcount;

        }
        while (list($key,$val)=each($_GET))
        {
        $gstr = $gstr."$key : $val \n ";
        ++$gcount;

        }
        if ($pcount > $gcount)
        {
        $message_body=$pstr;
		$name=$_POST['Name'];
		$company=$_POST['city'];
        $contact=$_POST['mobile'];
        $email=$_POST['Email']; 
        $title=$_POST['title'];
		$message=$_POST['message'];
		
		
        mail($mailto,$subject,$message_body,$message,"From:".$from);

        include("$file");
        }
        else
        {
        $message_body=$gstr;
		$name=$_POST['Name'];
		$company=$_POST['city'];
        $contact=$_POST['mobile'];
        $email=$_POST['Email']; 
        $title=$_POST['title'];
		$message=$_POST['message'];
		
		
        mail($mailto,$subject,$message_body,$message,"From:".$from);
        include("$file");
        }
        ?>
<?php
////////////////////////////////////////////////////////////
// SMS BIASAWAE v0.1                                      //
// oleh : Agus Muhajir                                    //
////////////////////////////////////////////////////////////
// blog/situs/milist :                                    //
//   http://hajirodeon.wordpress.com/                     //
//   http://sisfokol.wordpress.com/                       //
//   http://yahoogroup.com/groups/sisfokol/               //
//   http://yahoogroup.com/groups/linuxbiasawae/          //
////////////////////////////////////////////////////////////
// e-mail :                                               //
//   hajirodeon@yahoo.com                                 //
////////////////////////////////////////////////////////////
// hp/sms :                                               //
//   081-829-88-54                                        //
////////////////////////////////////////////////////////////



//require
require("inc/config.php");
require("inc/fungsi.php");
require("inc/koneksi.php");



//nilai
$filenya = "login.php";
$judul = "SMS BIASAWAE. Silahkan Login dahulu...";


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['btnOK'])
	{
	//ambil nilai
	$username = nosql($_POST["usernamex"]);
	$password = nosql($_POST["passwordx"]);

	//cek null
	if ((empty($username)) OR (empty($password)))
		{
		//diskonek
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//query
		$q = mysql_query("SELECT * FROM admin ".
					"WHERE username = '$username' ".
					"AND password = '$password'");
		$row = mysql_fetch_assoc($q);
		$total = mysql_num_rows($q);

		//cek login
		if ($total != 0)
			{
			session_start();

			//nilai
			$_SESSION['kd_session'] = nosql($row['id']);
			$_SESSION['username_session'] = $username;
			$_SESSION['adm_session'] = "Administrator";


			//diskonek
			xfree($q);
			xclose($koneksi);

			//re-direct
			$ke = "main.php";
			xloc($ke);
			exit();
			}
		else
			{
			//diskonek
			xfree($q);
			xclose($koneksi);

			//re-direct
			$pesan = "Input Salah. Harap Diperhatikan...!!.";
			pekem($pesan, $filenya);
			exit();
			}
		}
	}
//...................................................................................................




//form
echo '<html>
<head>
<title>'.$judul.'</title>
</head>

<body>
<form action="'.$filenya.'" method="post" name="formx">
<p>
<big>
<strong>'.$judul.'</strong>
</big>
</p>

<p>
Username :
<br>
<input name="usernamex" type="text" size="10" maxlength="15">
</p>

<p>
Password :
<br>
<input name="passwordx" type="password" size="10" maxlength="15">
</p>

<p>
<input name="btnOK" type="submit" value="OK &gt;&gt;&gt;">
</p>
</form>
</body>
</html>';
?>
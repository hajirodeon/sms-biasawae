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


session_start();

//require
require("inc/config.php");
require("inc/fungsi.php");
require("inc/koneksi.php");
require("inc/cek.php");

nocache;

//nilai
$filenya = "ganti_password.php";
$judul = "Ganti Password";


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//simpan
if ($_POST['btnSMP'])
	{
	//ambil nilai
	$passlama = nosql($_POST["passlama"]);
	$passbaru = nosql($_POST["passbaru"]);
	$passbaru2 = nosql($_POST["passbaru2"]);

	//cek
	//nek null
	if ((empty($passlama)) OR (empty($passbaru)) OR (empty($passbaru2)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}

	//nek pass baru gak sama
	else if ($passbaru != $passbaru2)
		{
		//re-direct
		$pesan = "Password Baru Tidak Sama. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//query
		$q = mysql_query("SELECT * FROM admin ".
					"WHERE username = '$username_session' ".
					"AND password = '$passlama'");
		$row = mysql_fetch_assoc($q);
		$total = mysql_num_rows($q);

		//cek
		if ($total != 0)
			{
			//perintah SQL
			mysql_query("UPDATE admin SET password = '$passbaru'");

			//diskonek
			xfree($q);
			xfree($qbw);
			xclose($koneksi);

			//auto-kembali
			$pesan = "PASSWORD BERHASIL DIGANTI.";
			$ke = "main.php";
			pekem($pesan, $ke);
			exit();
			}
		else
			{
			//diskonek
			xfree($q);
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "PASSWORD LAMA TIDAK COCOK. HARAP DIULANGI...!!!";
			pekem($pesan, $filenya);
			exit();
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<html>
<head>
<title>'.$judul.'</title>
</head>

<body>
<form action="'.$filenya.'" method="post" name="formx">';

require("inc/header.php");

echo '<TABLE border="0">
<tr valign="top">
<td valign="top">';

require("inc/menu.php");

echo '</td>
<td width="700" align="top">
<p>
<big>
<strong>'.$judul.'</strong>
</big>
</p>

<p>Password Lama : <br>
<input name="passlama" type="password" size="15" maxlength="15">
</p>
<p>Password Baru : <br>
<input name="passbaru" type="password" size="15" maxlength="15">
</p>
<p>RE-Password Baru : <br>
<input name="passbaru2" type="password" size="15" maxlength="15">
</p>
<p>
<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnBTL" type="reset" value="BATAL">
</p>
</td>

</tr>
</TABLE>
<br>';

require("inc/footer.php");

echo '</form>
</body>
</html>';
?>
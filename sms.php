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
$judul = "SMS";
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$nohp = nosql($_REQUEST['nohp']);
$filenya = "sms.php";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika kirim sms
if ($_POST['btnKRM'])
	{
	$s = nosql($_POST['s']);


	//jika kirim baru, sms tunggal
	if ($s == "baru")
		{
		$nohp = $_POST['nohp'];
		$nohpx = "+62$nohp";
		$isi_sms = $_POST['isi_sms'];

		//nek null
		if ((empty($nohp)) OR (empty($isi_sms)))
			{
			//re-direct
			$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
			$ke = "$filenya?s=baru";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//kirim sms, melalui service mysql khusus gammu
			mysql_query("INSERT INTO outbox (DestinationNumber, TextDecoded, CreatorID, SendingDateTime) VALUES ".
					"('$nohpx', '$isi_sms', 'gammu', '$today')");


			//re-direct
			$pesan = "Sekitar 5-15detik, SMS akan diterima oleh : $nohpx.";
			$ke = "$filenya?s=inbox";
			pekem($pesan,$ke);
			exit();
			}
		}


	//jika kirim baru, sms massal
	if ($s == "baru2")
		{
		$groupid = nosql($_POST['GroupsID']);
		$isi_sms = $_POST['isi_sms'];

		//nek null
		if ((empty($groupid)) OR (empty($isi_sms)))
			{
			//re-direct
			$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
			$ke = "$filenya?s=baru2";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//ketahui data siswa
			$qdt = mysql_query("SELECT * FROM pbk ".
						"WHERE GroupID = '$groupid' ".
						"ORDER BY ID ASC");
			$rdt = mysql_fetch_assoc($qdt);

			do
				{
				$dt_kd = nosql($rdt['ID']);
				$dt_nohp = nosql($rdt['Number']);
				$dt_nohpx = "+62$dt_nohp";

				//kirim sms, melalui service mysql khusus gammu
				mysql_query("INSERT INTO outbox (DestinationNumber, TextDecoded, CreatorID, SendingDateTime) VALUES ".
						"('$dt_nohpx', '$isi_sms', 'gammu', '$today')");
				}
			while ($rdt = mysql_fetch_assoc($qdt));


			//re-direct
			$pesan = "SMS Massal berhasil terkirim.";
			$ke = "$filenya?s=inbox";
			pekem($pesan,$ke);
			exit();
			}
		}



	//jika balas
	if ($s == "balas")
		{
		$nohp = $_POST['nohp'];
		$nohpx = "+$nohp";
		$isi_sms = $_POST['isi_sms'];

		//nek null
		if ((empty($nohp)) OR (empty($isi_sms)))
			{
			//re-direct
			$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
			$ke = "$filenya?s=balas&nohp=$nohp";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//kirim sms, melalui service mysql khusus gammu
			mysql_query("INSERT INTO outbox (DestinationNumber, TextDecoded, CreatorID, SendingDateTime) VALUES ".
					"('$nohpx', '$isi_sms', 'gammu', '$today')");


			//re-direct
			$pesan = "Sekitar 5-15detik, SMS akan diterima oleh : $nohpx.";
			$ke = "$filenya?s=inbox";
			pekem($pesan,$ke);
			exit();
			}
		}
	}





//jika hapus
if ($a == "hapus")
	{
	//nilai
	$kd = nosql($_REQUEST['kd']);

	//jika hapus inbox
	if ($s == "inbox")
		{
		mysql_query("DELETE FROM inbox WHERE ID = '$kd'");
		}


	//jika hapus outbox
	if ($s == "outbox")
		{
		mysql_query("DELETE FROM outbox WHERE ID = '$kd'");
		}


	//jika hapus sentitem
	if ($s == "sentitem")
		{
		mysql_query("DELETE FROM sentitems WHERE ID = '$kd'");
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




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
</p>';


echo '<a href="'.$filenya.'?s=baru">Tulis Baru SMS Tunggal</a>.
<br>';


//jika tulis sms baru
if ($s == "baru")
	{
	echo '<big>
	<strong>Silahkan isi Form Berikut, untuk Kirim SMS :</strong>
	</big>
	<br>

	<form action="'.$filenya.'" method="post" name="formx">
	<p>
	No.HP Tujuan :
	<br>
	+62<INPUT type="text" name="nohp" value="" size="20">
	</p>
	<p>
	Isi SMS :
	<br>
	<textarea name="isi_sms" cols="50" rows="2" wrap="virtual"></textarea>
	</p>

	<p>
	<input name="s" type="hidden" value="baru">
	<input name="btnKRM" type="submit" value="KIRIM">
	<input name="btnBTL" type="reset" value="BATAL">
	</p>
	</form>';
	}


//jika tulis sms massal baru
if ($s == "baru2")
	{
	echo '<big>
	<strong>Silahkan isi Form Berikut, untuk Kirim SMS Massal :</strong>
	</big>
	<br>

	<form action="'.$filenya.'" method="post" name="formx">
	<p>
	Groups / Kelas :
	<br>
	<select name="GroupsID">
	<option value="" selected></option>';

	//daftar groups
	$qgru = mysql_query("SELECT * FROM pbk_groups ".
				"ORDER BY name ASC");
	$rgru = mysql_fetch_assoc($qgru);

	do
		{
		//nilai
		$gru_id = nosql($rgru['ID']);
		$gru_nama = balikin($rgru['Name']);

		echo '<option value="'.$gru_id.'">'.$gru_nama.'</option>';
		}
	while ($rgru = mysql_fetch_assoc($qgru));

	echo '</select>
	</p>

	<p>
	Isi SMS :
	<br>
	<textarea name="isi_sms" cols="50" rows="2" wrap="virtual"></textarea>
	</p>

	<p>
	<input name="s" type="hidden" value="baru2">
	<input name="btnKRM" type="submit" value="KIRIM">
	<input name="btnBTL" type="reset" value="BATAL">
	</p>
	</form>';
	}


//jika balas
if ($s == "balas")
	{
	echo '<big>
	<strong>Silahkan isi Form Berikut, untuk Membalas SMS ke NoHP : </strong>
	</big>
	<br>

	<form action="'.$filenya.'" method="post" name="formx">
	<p>
	No.HP Tujuan :
	<br>
	+'.$nohp.'
	</p>
	<p>
	Isi SMS :
	<br>
	<textarea name="isi_sms" cols="50" rows="2" wrap="virtual"></textarea>
	</p>

	<p>
	<INPUT type="hidden" name="nohp" value="'.$nohp.'">
	<INPUT type="hidden" name="s" value="balas">
	<input name="btnKRM" type="submit" value="KIRIM">
	<input name="btnBTL" type="reset" value="BATAL">
	</p>
	</form>';
	}


//jika daftar sms/inbox
if ($s == "inbox")
	{
	//daftar inbox
	$qc1 = mysql_query("SELECT * FROM inbox ".
				"ORDER BY ReceivingDateTime DESC");
	$rc1 = mysql_fetch_assoc($qc1);
	$tc1 = mysql_num_rows($qc1);


	echo '<big>
	<strong>Daftar SMS yang masuk :</strong>
	</big>
	<br>

	<script>setTimeout("location.href=\'sms.php?s=inbox\'", 10000);</script>
	<table width="100%" border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="100"><strong><font color="'.$warnatext.'">Waktu</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Dari</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Isi SMS</font></strong></td>
	<td width="100">&nbsp;</td>
	</tr>';

	if ($tc1 != 0)
		{
		do
			{
			if ($warna_set ==0)
				{
				$warna = $warna01;
				$warna_set = 1;
				}
			else
				{
				$warna = $warna02;
				$warna_set = 0;
				}

			$i_kd = $rc1['ID'];
			$i_waktu = $rc1['ReceivingDateTime'];
			$i_pengirim = $rc1['SenderNumber'];
			$i_sms = $rc1['TextDecoded'];
			$i_Processed = $rc1['Processed'];
			$i_nohpx = substr($i_pengirim,3,20);

			//ketahui siswa-nya
			$qdtx = mysql_query("SELECT * FROM pbk ".
						"WHERE Number = '$i_nohpx'");
			$rdtx = mysql_fetch_assoc($qdtx);
			$dtx_nis = nosql($rdtx['nis']);
			$dtx_nama = balikin($rdtx['Name']);




			//jika masih false, berarti perlu reply
			if ($i_Processed == "false")
				{
				// membaca pesan SMS dan mengubahnya menjadi kapital
				$i_msg = strtoupper($i_sms);

				// proses parsing
				// memecah pesan berdasarkan karakter #
				$pecah = explode("#", $i_msg);

				//format SMS : REG#NIS#NAMA#NOHP

				//ambil deretan sms
				$j_reg = $pecah[0];
				$j_nis = $pecah[1];
				$j_nama = $pecah[2];



				//cek
				$qcc = mysql_query("SELECT * FROM pbk ".
							"WHERE nis = '$j_nis' ".
							"AND Name = '$j_nama'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);


				//jika ada, update nohp.
				if ($tcc != 0)
					{
					mysql_query("UPDATE pbk SET Number = '$i_nohpx' ".
							"WHERE nis = '$j_nis'");

					//isi sms
					$isi_sms = "Selamat, Anda Telah Berhasil Registrasi.";


					// membuat SMS balasan
					mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID) ".
							"VALUES ('$i_pengirim', '$isi_sms', 'Gammu')");


					// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
					mysql_query("UPDATE inbox SET Processed = 'true' ".
							"WHERE ID = '$i_kd'");
					}
				else
					{
					//isi sms
					$isi_sms = "Maaf, Registrasi Terjadi Kegagalan. Harap Diperhatikan...!!.";


					// membuat SMS balasan
					mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID) ".
							"VALUES ('$i_pengirim', '$isi_sms', 'Gammu')");


					// ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
					mysql_query("UPDATE inbox SET Processed = 'true' ".
							"WHERE ID = '$i_kd'");
					}
				}





			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$i_waktu.'</td>
			<td>
			'.$i_pengirim.'
			<br>
			['.$dtx_nis.'. '.$dtx_nama.']
			</td>
			<td>'.$i_sms.'</td>
			<td>
			[<a href="'.$filenya.'?s=balas&nohp='.$i_pengirim.'">BALAS</a>].
			[<a href="'.$filenya.'?s=inbox&a=hapus&kd='.$i_kd.'">HAPUS</a>].
			</td>
			</tr>';
			}
		while ($rc1 = mysql_fetch_assoc($qc1));
		}


	echo '</table>';
	}





//jika outbox
if ($s == "outbox")
	{
	//daftar outbox
	$qc1 = mysql_query("SELECT * FROM outbox ".
				"ORDER BY SendingDateTime DESC");
	$rc1 = mysql_fetch_assoc($qc1);
	$tc1 = mysql_num_rows($qc1);


	echo '<big>
	<strong>Daftar SMS yang sedang proses pengiriman :</strong>
	</big>
	<br>

	<script>setTimeout("location.href=\'sms.php?s=outbox\'", 10000);</script>
	<table width="100%" border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="100"><strong><font color="'.$warnatext.'">Waktu</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Kepada</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Isi SMS</font></strong></td>
	<td width="100">&nbsp;</td>
	</tr>';

	if ($tc1 != 0)
		{
		do
			{
			if ($warna_set ==0)
				{
				$warna = $warna01;
				$warna_set = 1;
				}
			else
				{
				$warna = $warna02;
				$warna_set = 0;
				}

			$i_kd = $rc1['ID'];
			$i_waktu = $rc1['SendingDateTime'];
			$i_kepada = $rc1['DestinationNumber'];
			$i_sms = $rc1['TextDecoded'];
			$i_nohpx = substr($i_kepada,3,20);

			//ketahui siswa-nya
			$qdtx = mysql_query("SELECT * FROM pbk ".
						"WHERE Number = '$i_nohpx'");
			$rdtx = mysql_fetch_assoc($qdtx);
			$dtx_nis = nosql($rdtx['nis']);
			$dtx_nama = balikin($rdtx['Name']);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$i_waktu.'</td>
			<td>
			'.$i_kepada.'
			<br>
			['.$dtx_nis.'. '.$dtx_nama.'].
			</td>
			<td>'.$i_sms.'</td>
			<td>
			[<a href="'.$filenya.'?s=outbox&a=hapus&kd='.$i_kd.'">HAPUS</a>].
			</td>
			</tr>';
			}
		while ($rc1 = mysql_fetch_assoc($qc1));
		}


	echo '</table>';
	}




//jika sentitem
if ($s == "sentitem")
	{
	//daftar
	$qc1 = mysql_query("SELECT * FROM sentitems ".
				"ORDER BY SendingDateTime DESC");
	$rc1 = mysql_fetch_assoc($qc1);
	$tc1 = mysql_num_rows($qc1);


	echo '<big>
	<strong>Daftar SMS yang telah terkirim :</strong>
	</big>
	<br>

	<script>setTimeout("location.href=\'sms.php?s=sentitem\'", 10000);</script>
	<table width="100%" border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="100"><strong><font color="'.$warnatext.'">Waktu</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Kepada</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Isi SMS</font></strong></td>
	<td width="100">&nbsp;</td>
	</tr>';

	if ($tc1 != 0)
		{
		do
			{
			if ($warna_set ==0)
				{
				$warna = $warna01;
				$warna_set = 1;
				}
			else
				{
				$warna = $warna02;
				$warna_set = 0;
				}

			$i_kd = $rc1['ID'];
			$i_waktu = $rc1['SendingDateTime'];
			$i_kepada = $rc1['DestinationNumber'];
			$i_sms = $rc1['TextDecoded'];
			$i_nohpx = substr($i_kepada,3,20);

			//ketahui siswa-nya
			$qdtx = mysql_query("SELECT * FROM pbk ".
						"WHERE Number = '$i_nohpx'");
			$rdtx = mysql_fetch_assoc($qdtx);
			$dtx_nis = nosql($rdtx['nis']);
			$dtx_nama = balikin($rdtx['Name']);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$i_waktu.'</td>
			<td>
			'.$i_kepada.'
			<br>
			['.$dtx_nis.'. '.$dtx_nama.'].
			</td>
			<td>'.$i_sms.'</td>
			<td>
			[<a href="'.$filenya.'?s=sentitem&a=hapus&kd='.$i_kd.'">HAPUS</a>].
			</td>
			</tr>';
			}
		while ($rc1 = mysql_fetch_assoc($qc1));
		}


	echo '</table>';
	}


echo '</td>

</tr>
</TABLE>
<br>';

require("inc/footer.php");

echo '</form>
</body>
</html>';
?>
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
$filenya = "sop.php";
$judul = "SOP Siswa";
$s = nosql($_REQUEST['s']);


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika edit
if ($s == "edit")
	{
	//nilai
	$kdx = nosql($_REQUEST['pbkid']);
	$pbkid = nosql($_REQUEST['pbkid']);

	//query
	$qx = mysql_query("SELECT pbk.*, pbk.ID AS kd, pbk.Name AS pnama, ".
				"pbk_groups.*, pbk_groups.Name AS gnama ".
				"FROM pbk, pbk_groups ".
				"WHERE pbk.GroupID = pbk_groups.ID ".
				"AND pbk.id = '$kdx'");
	$rowx = mysql_fetch_assoc($qx);
	$e_pnama = balikin2($rowx['pnama']);
	$e_gnama = balikin2($rowx['gnama']);
	$e_nis = nosql($rowx['nis']);
	$e_nohp = nosql($rowx['Number']);
	$e_gID = nosql($rowx['GroupID']);


	//bulan
	$qket = mysql_query("SELECT * FROM sop ".
				"WHERE pbkid = '$kdx'");
	$rket = mysql_fetch_assoc($qket);
	$ket_bulan = balikin($rket['bulan']);
	}





//jika batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}







//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$nis = nosql($_POST['nis']);
	$pbkid = nosql($_POST['pbkid']);
	$ket = cegah($_POST['ket']);

	//nek null
	if (empty($ket))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?s=edit&pbkid=$pbkid";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//cek
		$qcc = mysql_query("SELECT * FROM sop ".
					"WHERE pbkID = '$pbkid'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//nek ada
		if ($tcc != 0)
			{
			//update
			mysql_query("UPDATE sop SET bulan = '$ket' ".
					"WHERE pbkID = '$pbkid'");
			}
		else
			{
			//query
			mysql_query("INSERT INTO sop(pbkID, bulan) VALUES ".
					"('$pbkid', '$ket')");
			}




		//ketahui nohp-nya
		$qdtx = mysql_query("SELECT * FROM pbk ".
					"WHERE ID = '$pbkid'");
		$rdtx = mysql_fetch_assoc($qdtx);
		$dtx_nohp = nosql($rdtx['Number']);
		$dtx_nohpx = "+62$dtx_nohp";


		$isi_sms = "SOP Bulan = $ket. untuk NIS:$nis.";

		//kirim sms, melalui service mysql khusus gammu
		mysql_query("INSERT INTO outbox (DestinationNumber, TextDecoded, CreatorID, SendingDateTime) VALUES ".
				"('$dtx_nohpx', '$isi_sms', 'gammu', '$today')");


		//re-direct
		xloc($filenya);
		exit();
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
</p>';


//jika entri
if ($s == "edit")
	{
	echo '<p>
	Groups / Kelas :
	<br>
	'.$e_gnama.'
	</p>

	<p>
	NIS Siswa :
	<br>
	'.$e_nis.'
	</p>

	<p>
	Nama Siswa :
	<br>
	'.$e_pnama.'
	</p>

	<p>
	Bulan
	<br>
	<input name="ket" type="text" value="'.$ket_bulan.'" size="30">
	</p>


	<p>
	<INPUT type="hidden" name="s" value="'.$s.'">
	<INPUT type="hidden" name="pbkid" value="'.$pbkid.'">
	<INPUT type="hidden" name="kd" value="'.$kdx.'">
	<INPUT type="hidden" name="nis" value="'.$e_nis.'">
	<INPUT type="hidden" name="nama" value="'.$e_pnama.'">
	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnBTL" type="submit" value="BATAL">
	</p>';
	}

else
	{
	//query
	$q = mysql_query("SELECT pbk.*, pbk.ID AS kd, pbk.Name AS pnama, ".
				"pbk_groups.*, pbk_groups.Name AS gnama ".
				"FROM pbk, pbk_groups ".
				"WHERE pbk.GroupID = pbk_groups.ID ".
				"ORDER BY pbk_groups.name ASC, ".
				"pbk.nis ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);



	if ($total != 0)
		{
		echo '<table width="700" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="100"><strong><font color="'.$warnatext.'">NIS</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Nama Siswa</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Kelas</font></strong></td>
		<td width="150"><strong><font color="'.$warnatext.'">Bulan</font></strong></td>
		<td width="50">&nbsp;</td>
		</tr>';

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

			$nomer = $nomer + 1;
			$i_kd = nosql($row['kd']);
			$i_gnama = balikin2($row['gnama']);
			$i_pnama = balikin2($row['pnama']);
			$i_nohp = nosql($row['Number']);
			$i_nis = nosql($row['nis']);


			//bulan
			$qdt = mysql_query("SELECT * FROM sop ".
						"WHERE pbkID = '$i_kd'");
			$rdt = mysql_fetch_assoc($qdt);
			$df_bulan = balikin($rdt['bulan']);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$i_nis.'</td>
			<td>'.$i_pnama.'</td>
			<td>'.$i_gnama.'</td>
			<td>'.$df_bulan.'</td>
			<td>
			[<a href="'.$filenya.'?s=edit&pbkid='.$i_kd.'">EDIT</a>].
			</td>
			</tr>';
			}
		while ($row = mysql_fetch_assoc($q));

		echo '</table>
		<table width="700" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td align="right">Total : <strong><font color="#FF0000">'.$total.'</font></strong> Data.</td>
		</tr>
		</table>';
		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>TIDAK ADA DATA.</strong>
		</font>
		</p>';
		}
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
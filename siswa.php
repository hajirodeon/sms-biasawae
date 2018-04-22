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
$filenya = "siswa.php";
$judul = "Buku Telepon Siswa";
$s = nosql($_REQUEST['s']);


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($filenya);
	exit();
	}



//jika edit
if ($s == "edit")
	{
	//nilai
	$kdx = nosql($_REQUEST['kd']);

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
	}



//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$nis = nosql($_POST['nis']);
	$groupsid = nosql($_POST['GroupsID']);
	$pnama = cegah2($_POST['pnama']);
	$nohp = nosql($_POST['nohp']);

	//nek null
	if ((empty($nis)) OR (empty($pnama)) OR (empty($nohp)))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//cek
		$qcc = mysql_query("SELECT * FROM pbk ".
					"WHERE GroupsID = '$groupsid' ".
					"AND nis = '$nis'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//nek ada
		if ($tcc != 0)
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "NIS : $nis, Sudah Ada. Silahkan Ganti Yang Lain...!!";
			pekem($pesan,$filenya);
			exit();
			}
		else
			{
			//jika baru
			if ($s == "baru")
				{
				//query
				mysql_query("INSERT INTO pbk(GroupID, nis, Name, Number) VALUES ".
						"('$groupsid', '$nis', '$pnama', '$nohp')");


				//re-direct
				xloc($filenya);
				exit();
				}
			//jika update
			else if ($s == "edit")
				{
				//query
				mysql_query("UPDATE pbk SET nis = '$nis', ".
						"Name = '$pnama', ".
						"Number = '$nohp', ".
						"GroupID = '$groupsid' ".
						"WHERE id = '$kd'");

				//re-direct
				xloc($filenya);
				exit();
				}
			}
		}
	}


//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM pbk ".
				"WHERE id = '$kd'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($filenya);
	exit();
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
if (($s == "edit") OR ($s == "baru"))
	{
	echo '<p>
	Groups / Kelas :
	<br>
	<select name="GroupsID">
	<option value="'.$e_gID.'" selected>'.$e_gnama.'</option>';

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
	NIS Siswa :
	<br>
	<input name="nis" type="text" value="'.$e_nis.'" size="10">
	</p>

	<p>
	Nama Siswa :
	<br>
	<input name="pnama" type="text" value="'.$e_pnama.'" size="30">
	</p>

	<p>
	No.HP :
	<br>
	+62<input name="nohp" type="text" value="'.$e_nohp.'" size="30">
	</p>


	<p>
	<INPUT type="hidden" name="s" value="'.$s.'">
	<INPUT type="hidden" name="kd" value="'.$kdx.'">
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
		echo '[<a href="'.$filenya.'?s=baru">Entri Baru</a>].
		<br>
		<table width="750" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="1">&nbsp;</td>
		<td width="100"><strong><font color="'.$warnatext.'">Group</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">NIS</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Nama Siswa</font></strong></td>
		<td width="200"><strong><font color="'.$warnatext.'">No.HP</font></strong></td>
		<td width="100">&nbsp;</td>
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

			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
			</td>
			<td>
			<a href="'.$filenya.'?s=edit&kd='.$i_kd.'">
			<img src="img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>'.$i_gnama.'</td>
			<td>'.$i_nis.'</td>
			<td>'.$i_pnama.'</td>
			<td>+62'.$i_nohp.'</td>
			<td>
			[<a href="sms.php?s=balas&nohp=+62'.$i_nohp.'">Kirim SMS</a>].
			</td>
			</tr>';
			}
		while ($row = mysql_fetch_assoc($q));

		echo '</table>
		<table width="750" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="263">
		<input name="jml" type="hidden" value="'.$total.'">
		<input name="s" type="hidden" value="'.$s.'">
		<input name="kd" type="hidden" value="'.$kdx.'">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$total.')">
		<input name="btnBTL" type="submit" value="BATAL">
		<input name="btnHPS" type="submit" value="HAPUS">
		</td>
		<td align="right">Total : <strong><font color="#FF0000">'.$total.'</font></strong> Data.</td>
		</tr>
		</table>';
		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>TIDAK ADA DATA. Silahkan Entry Dahulu...!!</strong>
		</font>
		<br>
		[<a href="'.$filenya.'?s=baru">Entri Baru</a>].
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
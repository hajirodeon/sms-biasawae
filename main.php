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



//nilai
$filenya = "main.php";
$judul = "Menu Utama";




//form
echo '<html>
<head>
<title>'.$judul.'</title>
</head>

<body>
<form action="'.$filenya.'" method="post" name="formx">';

require("inc/header.php");

echo '<TABLE border="0">
<tr valign="top">
<td>';

require("inc/menu.php");

echo '</td>
<td width="700">
<p>
<big>
<strong>'.$judul.'</strong>
</big>
</p>

<p>
Selamat Datang.
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
<?php
include "inc/config.php";

if (@$_GET['download']){
    $url    = 'https://api.bulutfon.com/incoming-faxes/'.$_GET['download'].'?access_token='.$token;
    echo $url;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $test = curl_exec($curl);
    curl_close($curl);
}


$url    = 'https://api.bulutfon.com/incoming-faxes?access_token='.$token;
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
$curl_response = curl_exec($curl);
curl_close($curl);
$result = json_decode($curl_response, true);
$faxes = $result['incoming_faxes'];



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gelen Faxlar</title>
    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,900,700,600,300,200&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

    <!-- Main CSS -->
    <link href="css/main.css" rel="stylesheet">
    <!-- Font CSS -->
    <link href="css/fonts.css" rel="stylesheet">
</head>
<body>
<!-- Container -->
<div id="container">
    <!-- Arama Textbox-->
    <input type="text" class="search" placeholder="Filtrele">
    <!-- Başlıklar -->
    <div id="title">
        <div class="sender">Gönderen</div>
        <div class="sender">Alan</div>
        <div class="sender">Tarih</div>
        <div class="sender">İşlem</div>
    </div>
    <!-- Liste Başlangıç -->
    <ul class="list">
        <?php
        foreach($faxes as $fax){
        ?>

        <li>
            <div class="sender"><?php echo $fax['sender']; ?></div>
            <div class="receiver"><?php echo $fax['receiver']; ?></div>
            <div class="time">
                <?php
                $yeni   = strtotime($fax['created_at']);
                $son    = date('Y-m-d H:i:s', $yeni);
                echo $son;

                ?>
            </div>
            <div class="details">
                <a class="button" href="?download=<?php echo $fax['uuid']; ?>"></a>
            </div>
        </li>
        <?php } ?>
        <!--
        <li>
            <div class="sender">905068118260</div>
            <div class="receiver">905068118260</div>
            <div class="time">01.01.2016 - 23:30</div>
            <div class="details"><span>DETAY</span></div>
        </li>
        -->
    </ul>
    <!-- Liste Bitiş -->
</div>
<!-- Container Bitiş -->
<!-- JavaScript Dosyaları -->
<script type="text/javascript" src="js/list.js"></script>
<script type="text/javascript">
    var options = {
        valueNames: [ 'receiver', 'sender', 'time' ]
    };
    var hackerList = new List('container', options);
</script>
</body>
</html>
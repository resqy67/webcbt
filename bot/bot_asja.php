<?php
//untuk merespon perintah yang di kirim dari telegram ke server bot kita

$TOKEN = "1546995537:AAHeQxnhHGedIi_sw34ufoZZA6aZrCbTfek";  //token api bot telegram anda (ubah dan sesuaikan)
$apiURL = "https://api.telegram.org/bot$TOKEN";
$update = json_decode(file_get_contents("php://input"), TRUE);
$chatID = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];

/* /star merupakan perintah yang akan di ketikan di telegram anda */

if (strpos($message, "/start") === 0) {
 
    $message="<b>Assalamualaikum wr.wb</b>%0A";
    $message.="<b>Silakan klik perintah dibawah ini:</b>%0A";
    $message.=" /ping %0A";
    $message.=" /persyaratan %0A";
    $message.=" /untuk apa uang Rp. 30.000? %0A";
    

  file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$message."&parse_mode=HTML");
}
else if(strpos($message, "/ping") === 0){
     file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Assalamualaikum wr.wb</b>&parse_mode=HTML");
}
else if(strpos($message, "/persyaratan") === 0){
     file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>FC Kartu Keluarga, FC KTP, FC Buku Tabungan (masing-masing 2 lembar) Materai 10.000 dan Uang sebesar Rp. 30.000.</b>&parse_mode=HTML");
}
else if(strpos($message, "/untuk") === 0){
     file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>FC berkas Rp. 2000, CD Room Rp. 5000, Burning 15.000, Map Rp. 2000, Materai 4 lembar Rp. 28.000, total Rp. 52.000. Dapat potongan (covid-19) Rp. 22.000 </b>&parse_mode=HTML");
}
else{
    
}

?>
<?php

$IF="eno1";

echo "calculating speed upload speed \n\n";

for ($i = 1; $i <= 10; $i++) {

        $start = intval( file_get_contents("/sys/class/net/".$IF."/statistics/tx_bytes") );

        sleep(1);

        $new = intval( file_get_contents("/sys/class/net/".$IF."/statistics/tx_bytes") ) - $start;

        echo $new."\n\n";
        $medias[]=$new;

}

$average = array_sum($medias) / count ($medias) /125000;

echo "\n\nAverage is ".$average." Mbits/s \n\n";

?>

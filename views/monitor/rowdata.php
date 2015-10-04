<?php

$list = get_param($events, null, []);

if (!count($list)) {
    echo <<<ESET
    <tr class="warning">
        <td colspan="6">Нет данных</td>
    </tr>
ESET;
}

foreach ($list as $item) {

    $date = $item['ev_date'];
    $time = $item['ev_time'];
    $fio  = $item['fio'];
    $tabn = $item['tabnum'];
    $dept = $item['department'];
    $action = $item['evt'];
    
    echo <<<UROW
        <tr>
            <td>$date</td>
            <td>$time</td>
            <td>$fio</td>
            <td>$tabn</td>
            <td>$dept</td>
            <td>$action</td>
        </tr>
UROW;
}

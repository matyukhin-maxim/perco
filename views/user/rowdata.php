<?php

$list = get_param($events, null, []);

if (!count($list)) {
	echo <<<ESET
    <tr class="warning">
        <td colspan="3">Нет данных</td>
    </tr>
ESET;
}

foreach ($list as $item) {

	$date = $item['ev_date'];
	$time = $item['ev_time'];
	$action = $item['evt'];

	echo <<<UROW
        <tr>
            <td>$date</td>
            <td>$time</td>
            <td>$action</td>
        </tr>
UROW;
}

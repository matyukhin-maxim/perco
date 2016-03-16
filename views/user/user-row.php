<?php

$list = get_param($persons, null, []);

if (!count($list)) {
	echo <<<ESET
    <tr class="warning">
        <td colspan="3">Нет данных</td>
    </tr>
ESET;
}

foreach ($list as $item) {

	$tabn = get_param($item, 'tabnum');
	$depot = get_param($item, 'title');
	$id = get_param($item, 'id');
	$fio = join(' ', get_array_part($item, 'lname fname pname'));

	$class = get_param($item, 'deleted') == '1' ? 'danger' : '';

	echo <<<UROW
        <tr class="$class">
            <td>$tabn</td>
            <td><a href="/user/info/$id/" target="_blank">$fio</a></td>
            <td>$depot</td>
        </tr>
UROW;
}

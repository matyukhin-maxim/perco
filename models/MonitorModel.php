<?php

class MonitorModel extends CModel {

	public function getDepots() {

		$query = 'SELECT id, title FROM departments ORDER BY title';
		$result = $this->select($query);

		return array_column($result, 'title', 'id');
	}

	public function getActions($params, $limit = 100) {

		// если параметр с отделами пустой,
		// то будем считать что фильтр не задан,
		// и в запросе этот параметр учитывать не будем
		$fdepots = get_param($params, 'depot') ? 'and d.id in :depot ' : '';
		//if (!get_param($params, 'depot')) {
		//    $fdepots = ' ';
		//    unset($params['depot']);
		//}


		$query = "
        select 
                p.tabnum, d.title department, p.id,
                concat_ws(' ', p.lname, p.fname, p.pname) fio,
                a.title evt,
                e.ev_date, e.ev_time, e.ev_type
        from events e 
        left join person p on e.person_id = p.id
        left join departments d on p.department = d.id
        left join actions a on e.ev_type = a.id
        where 	e.ev_date between :bdate and :edate
            and e.ev_time between :btime and :etime
            and e.ev_type in :action
            and p.lname like :lname
            and p.fname like :fname
            and p.tabnum like :tabn
            $fdepots
        order by e.ev_date desc, e.ev_time desc ";


		if ($limit !== -1) {
			// -1 mean that we need all data
			$query .= " limit :limit";
			$params['limit'] = $limit;
		}

		$params['lname'] = toLike(get_param($params, 'lname', ''));
		$params['fname'] = toLike(get_param($params, 'fname', ''));
		$params['tabn'] = toLike(get_param($params, 'tabn', ''));
		$params['action'] = get_param($params, 'action') ?: [1, 2];

		$data = $this->select($query, $params);

		return $data;
	}

	public function getLastSync() {

		$data = $this->select('SELECT date_format(max(sync_date), "%d.%m.%Y %H:%i") mx FROM versions');
		$row = get_param($data, 0);
		return get_param($row, 'mx');
	}

}
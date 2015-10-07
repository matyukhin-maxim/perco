<?php

class ParadoxDB {

    private $stream;
    public $pxdoc;

    function __construct($path_to_db, $load_blob = false) {

        $this->pxdoc = px_new();
        $this->stream = fopen($path_to_db, "r");

        if (!$this->stream) {
            throw new Exception("Can't open file stream '$path_to_db'");
        }

        if (!px_open_fp($this->pxdoc, $this->stream)) {
            throw new Exception("Open file stream as paradox problem!");
        }
        
        if ($load_blob) {
            // create path to blob file (is the same name as our file, but with MB extension)
            // as we in linux, there is case sencetive path, so we need 'smart' replace extension
            
            $info = pathinfo($path_to_db);
            $info['extension'] = ctype_upper($info['extension']) ? '.MB' : '.mb'; // as smart as i can...  :-D
            $blob = $info['dirname'] . '/' . $info['filename'] . $info['extension'];
            px_set_blob_file($this->pxdoc, $blob);
        }
    }

    public function getCount() {

        return $this->pxdoc ? px_numrecords($this->pxdoc) : -1;
    }
    
    public function getRecord($rid) {
        
        return $this->pxdoc ? px_get_record($this->pxdoc, $rid) : [];
    }
    
    public function getAll($stop = -1) {
        
        $result = [];
        $cnt = $this->getCount();
        while (--$cnt >= 0 && $cnt > $stop) {
            $result[$cnt] = $this->getRecord ($cnt);
        }
        
        return $result;
    }
    
    public function closeDB() {
        
        if ($this->stream)
            fclose($this->stream);
        
        if ($this->pxdoc) {
            px_close($this->pxdoc);
            px_delete($this->pxdoc);
        }
        
        $this->stream = null;
        $this->pxdoc = null;
    }

    public function __destruct() {
        
        $this->closeDB();
    }

}

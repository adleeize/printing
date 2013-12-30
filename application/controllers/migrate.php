<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migrate extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->load->library('migration');

        if (!$this->migration->current()) {
            show_error($this->migration->error_string());
        }
    }
}

/* End of file migrate.php */
/* Location: ./application/controllers/migrate.php */
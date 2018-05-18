<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Dashboard extends MY_Controller {

    public function __Construct() {
        parent::__Construct();
        $this->layout->page = 'Dashboard';
    }

    public function index() {
        $this->layout->output();
    }


}

/* End of file */

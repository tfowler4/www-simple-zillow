<?php

/**
 * home controller
 */
class Home extends AbstractController {
    const CONTROLLER_NAME  = 'Home';
    const PAGE_TITLE       = 'Home';
    const PAGE_DESCRIPTION = 'Home Description';

    public function __construct($params) {
        parent::__construct();
        $this->_setPageTitle();
        $this->_setParameters($params);
    }

    public function index() {
        loadView('header/index', $this->_data);
        loadView('home/index', $this->_data);
    }
}
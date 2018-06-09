<?php

use MatthiasMullie\Minify;

/**
 * base controller class
 */
abstract class AbstractController {
    protected $_pageTitle;
    protected $_pageDescription;
    protected $_siteName;
    protected $_controllerName;
    protected $_viewPath = FOLDER_VIEWS;
    protected $_dbh;
    protected $_data = array();
    protected $_params;

    public function __construct() {
        $this->_dbh = Database::getHandler();
        $this->_setSiteName();

        $currController        = '';
        $this->_controllerName = static::CONTROLLER_NAME;

        if ( !empty(SessionData::get('controller')) ) {
            $currController = SessionData::get('controller');
            SessionData::set('prev_controller', $currController);
        }

        SessionData::set('controller', $this->_controllerName);

        if ( $currController != $this->_controllerName ) {
            SessionData::remove('form');
        }
    }

    /**
     * load a model file
     *
     * @param  string $modalName [ name of model ]
     * @param  string $params    [ parameters for ]
     *
     * @return obj [ model class object ]
     */
    protected function _loadModel($modalName, $params = '') {
        $modalName = strtolower($modalName);
        $modelFile = ucfirst($modalName) . 'Model';

        return new $modelFile($this->_dbh, $params);
    }

    /**
     * load the header page
     *
     * @return void
     */
    protected function _loadHeader() {
        if ( defined('SERVER"') && SERVER == 'live' ) {
            ob_start('ob_gzhandler');
        }

        $this->_loadView('header/index', $this->_data);
        $this->_loadView('modals/global');

        if ( defined('SERVER"') && SERVER == 'live' ) {
            ob_end_flush();
        }
    }

    /**
     * load the footer page
     *
     * @return void
     */
    protected function _loadFooter() {
        if ( defined('SERVER"') && SERVER == 'live' ) {
            ob_start('ob_gzhandler');
        }

        $footerModel = $this->_loadModel('footer');
        $this->_loadView('footer/index', $footerModel);

        if ( defined('SERVER"') && SERVER == 'live' ) {
            ob_end_flush();
        }
    }

    /**
     * load entire page view with header, footer, and content view
     *
     * @param  string $view  [ name of view ]
     * @param  obj    $model [ model file ]
     *
     * @return void
     */
    protected function _loadPageView($view, $model) {
        $this->_data['alert']       = $this->alert;

        // Begin Compression
        if ( defined('SERVER"') && SERVER == 'live' ) {
            ob_start('ob_gzhandler');
        }

        // load header
        $this->_loadHeader();

        // load main content
        $this->_loadView($view, $model);

        // load footer
        $this->_loadFooter();

        if ( defined('SERVER"') && SERVER == 'live' ) {
            ob_end_flush();
        }
    }

    /**
     * set name of web application site
     *
     * @return void
     */
    protected function _setSiteName() {
        if ( defined('SITE_NAME') && !empty(SITE_NAME) ) {
            $this->_siteName = SITE_NAME;
        } else {
            $this->_siteName = 'Unnamed Site';
        }
    }

    /**
     * set title of page
     *
     * @return void
     */
    protected function _setPageTitle($pageTitle = '') {
        if ( defined('static::PAGE_TITLE') && !empty(static::PAGE_TITLE) ) {
            $this->_pageTitle = static::PAGE_TITLE;
        } else {
            $this->_pageTitle = 'No Title Set';
        }

        if ( !empty($pageTitle) ) {
            $this->_pageTitle = $pageTitle;
        }

        $this->_pageTitle = $this->_pageTitle . ' | ' . $this->_siteName;
    }

    /**
     * set description of page
     *
     * @return void
     */
    protected function _setPageDescription($pageDescription = '') {
        if ( defined('static::PAGE_DESCRIPTION') && !empty(static::PAGE_DESCRIPTION) ) {
            $this->_pageDescription = static::PAGE_DESCRIPTION;
        } else {
            $this->_pageDescription = 'No Description Set';
        }

        if ( !empty($pageDescription) ) {
            $this->_pageDescription = $pageDescription;
        }
    }

    /**
     * set url parameters
     *
     * @return void
     */
    protected function _setParameters($params) {
        if ( !empty($params) ) {
            foreach ( $params as $index => $param ) {
                $params[$index] = urldecode($param);
            }
        }

        $this->_params = $params;
    }
}
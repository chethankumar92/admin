<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Loader to includes defaults
 * 
 * /application/core/Loader.php
 * 
 */
class MY_Loader extends CI_Loader {

    private $styles = array(
        'font-awesome.min',
        'ionicons.min',
        'AdminLTE/AdminLTE.min',
        'AdminLTE/skins/_all-skins.min',
        'AdminLTE/custom'
    );
    private $scripts = array(
        "AdminLTE/app.min",
        "AdminLTE/demo",
        "modules/main"
    );
    private $title = "AdminLTE";
    private $description = "";
    private $meta = array(
        array(
            "charset" => "UTF-8"
        ),
        array(
            "name" => "viewport",
            "content" => "width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
        )
    );
    private $plugins = array(
        "js" => array(
            'jQuery/jquery-2.2.3.min',
            'bootstrap/js/bootstrap.min',
            'iCheck/icheck.min',
            'slimScroll/jquery.slimscroll.min',
            'fastclick/fastclick',
            'parsley/parsley',
            'ladda/js/spin',
            'ladda/js/ladda',
            'bootstrap-notify/bootstrap-notify.min'
        ),
        "css" => array(
            'bootstrap/css/bootstrap.min',
            'iCheck/square/blue',
            'parsley/parsley',
            'ladda/css/ladda-themeless.min'
        ),
        "scss" => array()
    );

    public function template($template, $vars = array(), $return = FALSE, $is_login = FALSE, $extra = array()) {
        $instance = &get_instance();
        $instance->load->model('AdminUser', 'admin_user', TRUE);
        $instance->admin_user->setId($instance->session->userdata('logged_in_auid'));

        $header = $this->view('header', array(
            "logout_action" => site_url("logout/log_out"),
            "logged_in_user" => $instance->admin_user
                ), TRUE);

        $sidebar = $this->view('sidebar', array(
            "query" => $this->uri,
            "logged_in_user" => $instance->admin_user
                ), TRUE);

        $body = $this->view($template, array_merge($vars, array(
            "page_header" => $this->page_header(array(
                "title" => $this->title,
                "description" => $this->description,
                    ), $this->uri->segments)
                )), TRUE);

        $settings = $this->view('settings', array(), TRUE);
        $footer = $this->view('footer', array(), TRUE);

        return $this->view("main", array(
                    "styles" => $this->styles,
                    "scripts" => $this->scripts,
                    "plugins" => $this->plugins,
                    "title" => $this->title,
                    "meta" => $this->meta,
                    "is_login" => $is_login,
                    "header" => $header,
                    "sidebar" => $sidebar,
                    "body" => $body,
                    "settings" => $settings,
                    "footer" => $footer,
                    "extra" => $extra
                        ), $return);
    }

    function getStyles() {
        return $this->styles;
    }

    function getScripts() {
        return $this->scripts;
    }

    function getTitle() {
        return $this->title;
    }

    function getDescription() {
        return $this->description;
    }

    /**
     * 
     * @return array
     */
    function getMeta() {
        return $this->meta;
    }

    function getPlugins() {
        return $this->plugins;
    }

    function addStyles($styles, $key = 0) {
        array_splice($this->styles, $key, 0, $styles);
    }

    function addScripts($scripts, $key = 0) {
        array_splice($this->scripts, $key, 0, $scripts);
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    /**
     * 
     * @param array $meta
     */
    function setMeta(array $meta) {
        $this->meta = $meta;
    }

    function addMeta(array $meta) {
        $this->meta[] = $meta;
    }

    function addPlugins($plugins, $type, $key = 0) {
        if (!isset($this->plugins[$type])) {
            $this->plugins[$type] = array();
        }
        array_splice($this->plugins[$type], $key, 0, $plugins);
    }

    function page_header($vars, $segments) {
        $breadcrumb = $this->view('page_header/breadcrumb', array(
            "segments" => $segments
                ), TRUE);
        return $this->view("page_header/page_header", array_merge(array(
                    "breadcrumb" => $breadcrumb
                                ), $vars), TRUE);
    }

}

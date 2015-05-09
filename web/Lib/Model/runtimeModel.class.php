<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of runtimeModel
 *
 * @author Administrator
 */
class runtimeModel {
    private $site_config=array();
    private $assign = array();
    public function __construct() {
        $this->site_config=C("sites");
        $this->site_config["logo"]=  $this->site_config['domain']. $this->site_config['logo'];
    }

    public function assign($keys, $vals = null) {
        if ($keys === null) {
            $this->assign = array();
        }
        if ($vals === null && is_string($keys)) {
            unset($this->assign[$keys]);
        } elseif ($vals !== null && is_string($keys)) {
            $this->assign[$keys] = $vals;
        } elseif (is_array($keys)) {
            array_merge($this->assign, $keys);
        }
        return $this;
    }
    public function site_config($keys, $vals = null){
        if ($keys === null) {
            $this->site_config = array();
        }
        if ($vals === null && is_string($keys)) {
            unset($this->site_config[$keys]);
        } elseif ($vals !== null && is_string($keys)) {
            $this->site_config[$keys] = $vals;
        } elseif (is_array($keys)) {
            array_merge($this->site_config, $keys);
        }
        return $this;
    }

    public function get_contents($tpl){
        $content=file_get_contents(TMPL_PATH."runtime/{$tpl}.html");
        if(!$content){
            return "";
        }
        $site_config=  $this->site_config;
        $assign=  $this->assign;
        $patterns=array("/\{\{\s*site_([a-zA-Z0-9_]*)\s*\}\}/e","/\{\{\s*([a-zA-Z0-9_]*)\s*\}\}/e");
        $replaces=array('$site_config["\\1"]','$assign["\\1"]');
        $content=  preg_replace($patterns, $replaces, $content);
        return $content;
    }

}

<?php
    class HomeController extends Controllers{
        public function __construct(){
            parent::__construct();
        }

        public function home ($params){
            $data['page_id'] = 'p_home';
            $data['page_title'] = '.: Liga FF :.';
            $data['page_tag'] = 'Home';
            $data['page_name'] = 'home';
            $data['page_scripts']='<script src="'.assets().'js/home.js"></script>';
            $this->views->getView($this, 'home', $data);
        }

    }
?>
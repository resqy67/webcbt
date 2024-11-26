<?php
class Asdw extends CI_Controller {

 function __construct()
 {
   parent::__construct();
    $this->lang->load('basic', $this->config->item('language'));
	$this->load->helper('url');
    $this->load->helper('word_import_helper');
	$this->load->model('word_import_model','',TRUE);
 }

 function index()
 {
	echo"asdsa";
 }



}

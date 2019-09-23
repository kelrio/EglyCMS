<?php

defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');

$this->lang->load('panel/content_lang', $language);
$this->load->helper('language');

$this->load->database();
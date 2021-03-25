<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
//Đường dẫn tới thư mục chứa bộ thư viện của mà bạn lưu.
require_once APPPATH . 'third_party/google-api-php-client/src/Google/autoload.php';
 
class Google extends Google_Client {
 function __construct($params = array()) {
 parent::__construct();
 }
}
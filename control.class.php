<?php
// +----------------------------------------------------------------------
// | Constructed by Jokin [ Think & Do & To Be Better ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2019 Jokin All rights reserved.
// +----------------------------------------------------------------------
// | Author: Jokin <Jokin@twocola.com>
// +----------------------------------------------------------------------

class control {

  // 配置项
  static private $config = [];

  // 数据库连接
  static private $database = null;

  // 初始化
  public function __construct() {
    // 配置文件相关
    if (is_file('./config.inc.php')) {
      // 引入配置文件
      include './config.inc.php';
      //载入配置文件
      self::$config = $config;
    }else{
      self::error('无法找到配置文件');
    }
    // 基础设置
    date_default_timezone_set('PRC');
  }

  // 生成Token
  public function generateToken(string $username, string $password) {
    $username = htmlspecialchars($username);
    $password = htmlspecialchars($password);
    // 避免过短密码
    if (mb_strlen($username) > 16 || mb_strlen($password) > 16) {
      return false;
    }
    if (mb_strlen($username) < 5 || mb_strlen($password) < 8) {
      return false;
    }
    // 获取用户密码
    $this->dbAccess();
    self::$database->where('username', $username);
    $userinfo = self::$database->getOne('user_accounts');
    // 获取用户信息失败
    if (!$userinfo) {
      return false;
    }
    // 密码不正确
    if ($userinfo['password'] !== self::generatePassword($password)){
      return false;
    }
    $uid = $userinfo['uid'];
    // 查找用户名在Token表中是否存在
    $this->dbAccess();
    self::$database->where('uid', $uid);
    $userinfo = self::$database->getOne('tokens_v2');
    if ($userinfo) {
      if ($userinfo['status'] !== 1){
        // 更新Token
        $time = time();
        $token = md5($time . $password).'@'.$username;
        $data = array(
          'token'   => $token,
          'status'  => 1
        );
        self::$database->where('uid', $uid);
        $res = self::$database->update('tokens_v2', $data);
        if ($res) {
          return $token;
        }else{
          // 写入数据库失败
          return false;
        }
      }else{
        return $userinfo['token'];
      }
    }else{
      // 用户不存在
      return false;
    }
  }

  // 注册账户
  public function registerAccount(string $username, string $password) {
    $username = htmlspecialchars($username);
    $password = htmlspecialchars($password);
    // 避免过短密码
    if (mb_strlen($username) > 16 || mb_strlen($password) > 16) {
      return false;
    }
    if (mb_strlen($username) < 2 || mb_strlen($password) < 6) {
      return false;
    }
    $pattern = "/^[a-zA-Z0-9_]+$/";
    $preg = preg_match($pattern, $username);
    if (!$preg) {
      return false;
    }
    // 查询用户是否存在
    $this->dbAccess();
    self::$database->where('username', $username);
    $userinfo = self::$database->getOne('user_accounts');
    // 已经存在用户
    if ($userinfo) {
      return false;
    }
    // 生成密码
    $password = self::generatePassword($password);
    // 写入用户表
    $data = array(
      'username'  => $username,
      'password'  => $password,
      'status'    => 1 // 有效用户
    );
    $this->dbAccess();
    $uid = $db = self::$database->insert('user_accounts', $data);
    if (!$db) {
      return false;
    }
    return true;
  }

  // 提交Flag
  public function subflag(string $username, string $password, string $flag) {
    $username = htmlspecialchars($username);
    $password = htmlspecialchars($password);
    $flag = htmlspecialchars(trim($flag));
    if (mb_strlen($username) > 16) {
      return 100;
    }
    if (mb_strlen($username) < 2) {
      return 100;
    }
    if (mb_strlen($password) > 16) {
      return 100;
    }
    if (mb_strlen($password) < 6) {
      return 100;
    }
    if (mb_strlen($flag) > 1000) {
      return 100;
    }
    // 查询用户信息
    $this->dbAccess();
    self::$database->where('username', $username);
    $userinfo = self::$database->getOne('user_accounts');
    if (!$userinfo) {
      return 100;
    }
    if ($userinfo['password'] != self::generatePassword($password)) {
      return 100;
    }
    $uid = $userinfo['uid'];
    // 获取上次提交时间
    $this->dbAccess();
    self::$database->where('uid', $uid);
    self::$database->orderBy('sub_at', 'Desc');
    $db = self::$database->getOne('submissions');
    // 控制提交间隔（1分钟）
    if ($db && time() - strtotime($db['sub_at']) < 60){
      return 101;
    }
    // 是否重复提交正确flag
    $this->dbAccess();
    self::$database->where('uid', $uid);
    self::$database->where('flag', $flag);
    self::$database->where('status', 1);
    $db = self::$database->getOne('submissions');
    if ($db) {
      return 202;
    }
    // 查询flag是否正确
    $this->dbAccess();
    self::$database->where('flag', $flag);
    $db = self::$database->getOne('flags');
    if ($db) {
      $status = 1;
    }else{
      $status = 0;
    }
    // 注册提交信息
    $data = array(
      'uid'     => $uid,
      'flag'    => $flag,
      'status'  => $status,
    );
    $this->dbAccess();
    $db = self::$database->insert('submissions', $data);
    if (!$db){
      return false;
    }
    // 成功
    if ($status ==1) {
      return 200;
    }else{
      return 201;
    }
  }

  // 获取排行榜
  public function getCharts() {
    $this->dbAccess();
    $result = self::$database->rawQuery("SELECT a.uid,a.username,sum(f.points) as count FROM `gass_fc_submissions` as s, `gass_fc_user_accounts` as a, `gass_fc_flags` as f WHERE a.uid=s.uid AND s.status=1 AND s.flag=f.flag GROUP BY username ORDER BY count DESC, uid ASC LIMIT 100");
    return $result;
  }

  // 连接数据库
  public function dbAccess(){
    self::$database = new MysqliDb (Array (
                'host' => self::$config['DB_HOST'],
                'username' => self::$config['DB_USER'],
                'password' => self::$config['DB_PSWD'],
                'db'=> self::$config['DB_NAME'],
                'port' => self::$config['DB_PORT'],
                'prefix' => self::$config['DB_PREFIX'],
                'charset' => self::$config['DB_CHARSET']));
  }

  // 生成密码
  static function generatePassword(string $pwd) : string {
    $pwd = md5($pwd.'tcAppsCheckIn@)!(');
    return $pwd;
  }

  // 生成JSON
  static function generateJson($body, int $code = 200, string $msg = 'success') : string {
    $json = array(
      'body'        => $body,
      'code'        => $code,
      'msg'         => $msg
    );
    $json = json_encode($json);
    return $json;
  }

  // 报错
  static function error(string $error) {
    die($error);
  }

}
?>

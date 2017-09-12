<?php

namespace App\Auth;

use App\Config\SingletonCore;

/**
 * セッション管理
 */
final class Session extends SingletonCore {
    protected function __construct(){
        //セッションスタート
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public function state()
    {
        //idがセッションに登録されており、60分以内の場合は真（ログイン状態）
        if ($this->get('state') && $this->get('time') + 3600 > time()) {
            $this->put(array('time' => time()));
        } else {
            // ログインしていない場合
            return false;
        };

        return true;
    }

    // セッション情報を登録
    public function put($params = array()){
        foreach ($params as $name => $value) {
            $_SESSION[$name] = $value;
        }
    }

    // セッション情報を取得
    public function get($name){
        return $_SESSION[$name];
    }

    // セッション情報を全て取得(オブジェクト形式)
    public function getAll($obj = true){
        if($obj){
            return json_decode(json_encode($_SESSION)); // 連想配列をオブジェクトに変換
        }

        return $_SESSION;
    }

    // セッション情報を破棄
    public function destroy()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $_SESSION = array();

        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }

        if (isset($_SESSION)) {
            session_destroy();
        }
    }
}
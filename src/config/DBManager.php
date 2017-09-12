<?php

namespace App\Config;

use Mapyo\EloquentOnly\Eloquent;
use Exception;

/**
 * データベース接続処理
 */
final class DBManager extends SingletonCore {

    // xml ファイル
    private $xml = __DIR__ . '/../../database.xml';
    // 実行環境
    // private $env = 'production';
    private $env = 'local';
    // private $env = 'test';

    // Database Config Object
    private $config;

    protected function __construct(){
        // XMLから読み込む
        $xml = simplexml_load_file($this->xml);
        // オブジェクトへ変換
        $xmlObj = get_object_vars($xml);
        // 環境毎の設定を取り出す
        $this->config = $xmlObj[$this->env];
    }

    public function init(){
        // 接続処理
        try {
            Eloquent::init([
                'driver'   => 'mysql',
                'host'     => '127.0.0.1',
                'database' => $this->config->db,
                'username' => $this->config->username,
                'password' => $this->config->password,
                'port'     => 3306,
                'collation' => 'utf8_unicode_ci',
                'charset'  => $this->config->charset,
            ]);
        }catch (Exception $e){
            exit('データベース接続失敗。' . $e->getMessage());
        }
    }
}
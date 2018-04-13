<?php

namespace App\Config;

use Illuminate\Database\Capsule\Manager as Capsule;
use Exception;

/**
 * Database Connection Config
 */
final class DBManager extends SingletonCore {
    // xml ファイル
    private $xml = __DIR__ . '/../../database.xml';
    // 実行環境
    private $env = 'development'; // production, development, test

    // Database Config Object
    private $config;

    private $capsule;


    protected function __construct(){
        // XMLから読み込む
        $xml = simplexml_load_file($this->xml);
        // オブジェクトへ変換
        $xmlObj = get_object_vars($xml);
        // 環境毎の設定を取り出す
        $this->config = $xmlObj[$this->env];

        $this->capsule = new Capsule;
    }

    public function init(){
        // 接続処理
        try {
            $this->capsule->addConnection([
                'driver'   => 'mysql',
                'host'     => '127.0.0.1',
                'database' => $this->config->db,
                'username' => $this->config->username,
                'password' => $this->config->password,
                'port'     => $this->config->port,
                'collation' => 'utf8_unicode_ci',
                'charset'  => $this->config->charset,
            ]);
            $this->capsule->setAsGlobal();
            $this->capsule->bootEloquent();
        }catch (Exception $e){
            exit('データベース接続失敗。' . $e->getMessage());
        }
    }
}
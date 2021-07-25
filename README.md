# FUEL TRIAL

## 環境
- 基本的に馴染みのあるバージョンを選定

| OS/ミドルウェア | バージョン |
----|---- 
| OS | Amazon Linux2 EC2|
| Web | Apache/2.4.48 |
| MySQL | 5.7.35 |
| PHP | PHP Version 7.4.21 |
| Fuel | 1.8.2 |

## DB設定
```
mysql> show databases;
+--------------------+
| Database           |
+--------------------+
| test_db            |
+--------------------+

mysql> SELECT Host, User FROM mysql.user;
+-----------+---------------+
| Host      | User          |
+-----------+---------------+
| localhost | user01        |
+-----------+---------------+

mysql> show tables;
+-------------------+
| Tables_in_test_db |
+-------------------+
| ai_analysis_log   |
+-------------------+
1 row in set (0.00 sec)

mysql> 
mysql> desc ai_analysis_log;
+--------------------+------------------+------+-----+---------+----------------+
| Field              | Type             | Null | Key | Default | Extra          |
+--------------------+------------------+------+-----+---------+----------------+
| id                 | int(11)          | NO   | PRI | NULL    | auto_increment |
| image_path         | varchar(255)     | YES  |     | NULL    |                |
| success            | varchar(255)     | YES  |     | NULL    |                |
| message            | varchar(255)     | YES  |     | NULL    |                |
| class              | int(11)          | YES  |     | NULL    |                |
| confidence         | decimal(5,4)     | YES  |     | NULL    |                |
| request_timestamp  | int(10) unsigned | YES  |     | NULL    |                |
| response_timestamp | int(10) unsigned | YES  |     | NULL    |                |
+--------------------+------------------+------+-----+---------+----------------+
8 rows in set (0.02 sec)

```
- DB接続メモ
```
mysql -h localhost -u user01 -pPassword-123 test_db;
```

## Webアプリケーション
### phpinfo 
  - http://ec2-54-250-192-112.ap-northeast-1.compute.amazonaws.com/phpinfo.php

### メイン処理
- 処理概要
  - 分析API(スタブ)をcallする
  - レスポンスをDBに登録するAPIをcallする
  - DB登録内容を画面に表示する
- URL
  - http://ec2-54-250-192-112.ap-northeast-1.compute.amazonaws.com/index.php/welcome/index/foo_param
- ソースコード
  - https://github.com/nsoutome/fuel/blob/master/fuel/app/classes/controller/welcome.php

### 分析API(スタブ)
- 処理概要
  - ランダムで分析結果を返却する。
- URL  
  - http://ec2-54-250-192-112.ap-northeast-1.compute.amazonaws.com/index.php/api/analysis.json
- 呼び出し結果
```
curl -d image_path=test.png http://ec2-54-250-192-112.ap-northeast-1.compute.amazonaws.com/index.php/api/analysis.json
{"success":"true","message":"success","estimated_data":{"class":1,"confidence":0.111}}
```
- ソースコード
  - https://github.com/nsoutome/fuel/blob/master/fuel/app/classes/controller/api.php

### 結果登録API
- 処理概要
  - 分析APIレスポンスをDBに登録する。
- URL  
  - http://ec2-54-250-192-112.ap-northeast-1.compute.amazonaws.com/index.php/api/regist.json
- 呼び出し結果
```
curl -d "image_path=test.png&success=true" http://ec2-54-250-192-112.ap-northeast-1.compute.amazonaws.com/index.php/api/regist.json
[137,1]
```
- ソースコード
  - https://github.com/nsoutome/fuel/blob/master/fuel/app/classes/controller/api.php



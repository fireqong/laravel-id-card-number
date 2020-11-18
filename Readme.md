## 介绍

此库是用于扩展验证规则,`idNumber`。

### 环境需求

1. php >= 7.3
2. Composer

### 安装

```shell script
composer require church/laravel-id-card-number
```

### 使用

```php
<?php

public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id_number' => 'required|idNumber'
    ]);
   
    if ($validator->fails()) {
        return new JsonResponse([
            'state' => 'error',
            'message' => $validator->errors()->first(),
        ]);
    }   

}
```

更多方法:

```php
$IDCard = new \Church\IDCard\IDCard('身份证号');
$IDCard->getAddress();
$IDCard->getSex();
$IDCard->getBirthday();
```

### 单元测试

```shell script
./vendor/bin/phpunit
```

更多示例可以查看 `IDCardTest.php`, 该单元测试的测试用例来源于互联网，如果侵犯了您的隐私，请联系 `church_qi@aliyun.com`，我会在第一时间删除。
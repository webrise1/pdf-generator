Расширение для yii2 pdf-generator
==========================
Расширение для yii2 pdf-generator

1.Установка
------------

Устанавливаем через [composer](http://getcomposer.org/download/).


```
composer require webrise1/pdf-generator
```
 

2.Выполняем миграции
-----
```
yii migrate --migrationPath=@webrise1/pdf-generator/migrations --interactive=0
```
3.Настраиваем конфигурацию
-----

В файле `config/web.php` (yii2 Basic) подключаем расширение
```php
     'modules' => [
                'pdfgenerator' => [
                    'class' => 'webrise1\pdfgenerator\Module',
                    'layout'=>'@app/modules/admin/views/layouts/main',
                    'haveAdminAccessFunction'=>function(){
                        return (!Yii::$app->user->isGuest && Yii::$app->user->identity->backend_status==\app\models\User::BACKEND_STATUS_SUPER_ADMINISTRATOR);
                    }
                    ,
                    'includeModels'=>[
                        'user'=>[
                            'user_id'=>'id',
                            'model'=>'app\models\User'
                        ],
                        ...
                    ]
                ],
      ]  
```

#### Параметры
>**userTable** - имя таблицы с пользователями, должна содержать столбцы "id","email" `(Обязательный параметр)`

>**uploads** - путь к директории для сохранения файлов `(Обязательный параметр)`

>**haveAdminAccessFunction** - Передаем функцию проверки доступа к админ панели, если вернет `true` пользователя пустит в админку `(Обязательный параметр)`

>**layout** - путь к шаблону админки

>**includeModels** - подключаем модели для использования сниппетов в шаблонах 

`Запись` 'user'=>['user_id'=>'id', 'model'=>'app\models\User'] дает возможность использовать сниппет [[user.attribute]]. Например:
`[[user.name]] аналогичен <?=$user->name?>`

`[[user.profile.address]] аналогичен <?=$user->profile->address?>`(если в моделе User есть связь с моделью Profile)

 
# Yii RESTful URL Manager

## Requirement

* PHP >= 5.3.0

## Installation

Add depend to your project composer.json file

```
{
    "require": {
        "yii/yiisoft": "dev-master",
        "likai/yii-restful": "dev-master"
    }
}
```

After, run `composer update` update composer packages

## Usage

### 1. Add `topics` resource

```
return array(
    'urlManager'=>array(
        'class' => 'Likai\\YiiRestful\\UrlManager',
        'urlFormat' => 'path',
        'showScriptName' => false,
        'resources' => array(
            'topics',
        ),
    ),
);
```

UrlManager will generate 5 url rules and bind to the controller, like the following
```
`GET` http://yourdomain/topics          => TopicsController::actionIndex
`GET` http://yourdomain/topics/{id}     => TopicsController::actionShow
`POST` http://yourdomain/topics         => TopicsController::actionCreate
`PUT` http://yourdomain/topics/{id}     => TopicsController::actionUpdate
`DELETE` http://yourdomain/topics/{id}  => TopicsController::actionDelete
```

### 2. Specified parameters
```
'resources' => array(
    'topics',
    array('posts', 'only' => array('index', 'create')), // just bind PostsController::actionIndex, PostsController::actionCreate action
    array('users', 'except' => array('delete', 'update')), // except UsersController::actionDelete, UsersController::actionUpdate action
),

```

## ChangeLog 

**Version v1.0.1 and v1.0.2**

- Added composer supported
- Added namespace supported

**Version v1.0.0**

- First release

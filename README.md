# Yii RESTful URL Manager

## Requirement

* PHP >= 5.3.0

## Installation

* Download [yii-restful.zip](https://github.com/tlikai/yii-restful/archive/master.zip)
* Unzip this file
* Move directory `src/*` to `your-project/protected/extensions/yii-restful`

## Usage

### 1. Add `topics` resource

```
return array(
    'urlManager'=>array(
        'class' => 'ext.yii-restful.Likai.YiiRestful.RestfulManager',
        'urlFormat' => 'path',
        'resources' => arary(
            'topics',
        ),
    ),
);
```

RestfulManager will generate 5 url rules and bind to the controller, like the following
```
`GET` http://yourdomain/topics          => TopicsController::actionIndex
`GET` http://yourdomain/topics/{id}     => TopicsController::actionShow
`POST` http://yourdomain/topics         => TopicsController::actionCreate
`PUT` http://yourdomain/topics/{id}     => TopicsController::actionUpdate
`DELETE` http://yourdomain/topics/{id}  => TopicsController::actionDelete
```

### 2. Specified parameters
```
'resources' => arary(
    'topics',
    array('posts', 'only' => array('index', 'create')), // just bind Posts::index, Posts::create action
    array('users', 'except' => array('delete', 'update'), // except Posts::delete, Posts::update action
),

```

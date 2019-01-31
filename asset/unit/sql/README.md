onepiece-frameworks SQL unit
===

This is just SQL generate. Not throw query.

## How to use

### Instantiate

```
$sql = Unit::Instance('SQL');
```

### Select

```
//  Select configuration.
$config = [];
$config['table'] = 'table_name';
$config['limit'] =  1;
$config['offset']=  0;
$config['order'] = 'year desc, month asc, day desc';
$config['where'][] = 'deleted is  null';
$config['where'][] = 'updated not null';
$config['where'][] = 'score >= 1';
$config['where'][] = 'score < 10';
$config['where'][] = 'updated between 2010-01-01, 2020-12-31 24:00:00';
$config['where'][] = 'fruit in apple, banana, mango';
$config['where'][] = 'color notin green, red';
$config['where'][] = 'comment like This%';
$config['where'][] = 'comment notlike This is%';

//  Generate SQL query.
$query = $sql->Select($config, $db);
```

### Insert

```
//  Insert configuration.
$config = [
  'table' = 'table_name',
  'set'[
    'nickname = The World',
    'comment  = Hello, world!',
  ],
  //	ON DUPLICATE KEY UPDATE
  'update' = 'nickname, comment',
];

//  Generate SQL query.
$query = $sql->Insert($config, $db);
```

#### Notice

 "ON DUPLICATE KEY UPDATE" is consume autoincrement id number.

### Update

```
//  Update
$config = [
  'table' = 'table_name',
  'limit' = 1,
  'where' = [
    'id' = 1,
  ],
  'set'  = [
    'nickname' = 'Who?',
    'comment'  = 'xxxx',
  ],
];

//  Generate SQL query.
$query = $sql->Update($config, $db);
```

### Delete

```
//  Delete
$config = [
  'table' = 'table_name',
  'limit' = 1,
  'where' = [
    'id' = 1,
  ],
];

//  Generate SQL query.
$query = $sql->Delete($config, $db);
```

### Table Join

 Use QQL.

```
<?php
$config = [
  'table' => 't_user.name_id <= t_name.id, t_user.group_id <= t_group.id',
  'limit' => 1,
  'where' => [
    'id = 1',
  ],
];

//  Generate SQL query.
$query = $sql->Select($config, $db);
```

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
$config = [
  'table' = 'table_name',
  'limit' = 1,
  'where' = [
    'id' = 1,
  ],
];

//  Generate SQL query.
$query = $sql->Select($config, $db);
```

### Insert

```
//  Insert configuration.
$config = [
  'table' = 'table_name',
  'set'  = [
    'nickname' = 'Hoge',
    'comment'  = 'Hello',
  ],
];

//  Generate SQL query.
$query = $sql->Insert($config, $db);
```

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

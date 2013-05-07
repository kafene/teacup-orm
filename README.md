# Teacup Orm Component

This component is only recommended if you want to use it over a small business logic domain
as for example 3 or 4 tables, but not more.

## Usage

### Create a model

Any model extends the class `\Teacup\Orm\ActiveRecord`.

```php
class User extends \Teacup\Orm\ActiveRecord {

	static public $database = 'example';
	static public $table = 'users';

}
```

### Using the model

```php
$user = new User();
$user->setName('Bob');
$user->save();
```

You don't need to define getters/setters and access the properties directly:

```php
$user = new User();
$user->name = 'Bob';
$user->save();
```

> Instead of calling the `save()` method, you can explicitly call `insert()` or `update()`.

## Defining connections

`\Teacup\Orm\Storage` provides a PDO storage. To define a storage engine you can directly define it's configuration:

```php
\Teacup\Orm\Storage::$instances['default'] = array(
    	'dsn' => 'mysql:host=localhost',
    	'user' => 'root',
    	'password' => '',
    	'option' => array(/*any PDO options can be defined here*/)
);
```

A model could use another storage provider if you configure it:

```php
use \Teacup\Orm\Storage as Storage;
use \Teacup\Orm\ActiveRecord as ActiveRecord;


Storage::$instances['myOtherConnection'] = array(
    	'dsn' => 'mysql:host=127.0.0.1',
    	'user' => 'root',
    	'password' => ''
);

class Acme extends ActiveRecord {

    static public $storage = 'myOtherConnection';
    static public $table = 'acme_table';

}
```

You can also freely use the PDO connector like this :

```php
use \Teacup\Orm\Storage as Storage;
use \Teacup\Orm\ActiveRecord as ActiveRecord;


Storage::$instances['myOtherConnection'] = array(
    	'dsn' => 'mysql:host=127.0.0.1',
    	'user' => 'root',
    	'password' => ''
);

Storage::get('myOtherConnection')->exec('SELECT * FROM example.users');
```

## Errors

`Storage::get()` throws an `OutOfBoundsException` if you try to get an instance that wasn't configured before.
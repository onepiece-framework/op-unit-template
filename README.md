Unit of Template for onepiece-framework
===

# File location

 The template files is placed in the following directory.
 And also supports sub directories.

```
asset:/template/
```

## File reading priority

 If there is a file with the same name in the current directory and the template directory.
 The file in the current directory will be read.

 priority:

 1. Current directory location.
 2. "asset:/template/" location.

## If in UNIT

 priority when called within a unit:

 1. Current directory location.
 2. "asset:/unit/{UNIT_NAME}/template/" location.
 3. "asset:/template/" location. -- In this case, Class use OP_UNIT.

# Usage

```php
OP()->Template('file_name.phtml');
```

 Pass the argument.

```php
$args = [];
$args['foo'] = 'bar';
OP()->Template('file_name.phtml', $args);
```

```php:file_name.phtml
<?php
//  Automatically setted $args variable.
D($args);
```

 Use OP_UNIT to refer to the template directory within the unit.

```php
class Example implements IF_UNIT
{
    //  ...
    use OP_CORE, OP_CI, OP_UNIT;

    //  ...
    function Display()
    {
        //  Refer current unit template directory.
        echo $this->Template('example.phtml');
    }
}
```

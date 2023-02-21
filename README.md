Unit of Template for onepiece-framework
===

# File location

 The template files is placed in the following directory.
 And also supports sub directories.

```
asset:/template/
```

## File reading priority

 If there is a file with the same name in the current directory, the file in the current directory will be read first.

 priority:

 1. ./index.phtml
 2. asset:/template/index.phtml

## If in UNIT

 priority when called within a unit:

 1. ./index.phtml
 2. asset:/unit/UNIT_NAME/template/index.phtml
 3. asset:/template/index.phtml

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
//  Already setted $args variable.
D($args);
```

Pass the arguments
===

```php
$args = [];
$args['foo']  = 'bar';
$args['hoge'] = 'fuga';
OP()->Template('file_name.phtml', $args);
```

```php:file_name.phtml
<?php
//  Already setted $args variable.
D($args);
```

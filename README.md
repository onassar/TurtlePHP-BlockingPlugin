TurtlePHP-BlockingPlugin
======================

### Sample plugin loading:
``` php
require_once APP . '/plugins/TurtlePHP-BasePlugin/Base.class.php';
require_once APP . '/plugins/TurtlePHP-BlockingPlugin/Blocking.class.php';
$path = APP . '/config/plugins/blocking.inc.php';
TurtlePHP\Plugin\Blocking::setConfigPath($path);
TurtlePHP\Plugin\Blocking::init();
```

JTL/GoPrometrics Client
=======================

# Usage
This library use [semantic visioning](http://semver.org/). You can use composer to install `jtl/go-prometrics-client` in your project.

```php
//simlpe counter
$counter = new Counter(new Client(), "http://127.0.0.1:9111");
$counter->counter('BEER', 'BITBURGER');

//counter with labels
$labelList = new LabelList();
$labelList->add(new Label('type', 'Pils');
$labelList->add(new Label('alc', '4.8');
$counter = new Counter(new Client(), "http://127.0.0.1:9111");
$counter->counter('BEER', 'BITBURGER', labelList);
```
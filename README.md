JTL/GoPrometrics Client
=======================

# Usage
This library use [semantic visioning](http://semver.org/). You can use composer to install `jtl/go-prometrics-client` in your project.

## Counter

```php
//simple counter
$counter = new Counter(new Client(), "http://127.0.0.1:9111");
$counter->counter('BEER', 'BITBURGER');

//counter with labels
$labelList = new LabelList();
$labelList->add(new Label('type', 'Pils');
$labelList->add(new Label('alc', '4.8');
$counter = new Counter(new Client(), "http://127.0.0.1:9111");
$counter->counter('BEER', 'BITBURGER', $labelList);

//counter with labels and help text
$counter->counter('BEER', 'BITBURGER', $labelList, 'It could help');
```

## Histogram

```php
//simple histogramm
$bucketList = [0.1, 0.5, 1.0, 5.0];
$histogram = new Histogram(new Client(), "http://127.0.0.1:9111");
$histogram->observe('BEER', 'BITBURGER', 0.33, $bucketList);

//histogramm with labels
$labelList = new LabelList();
$labelList->add(new Label('type', 'Pils');
$labelList->add(new Label('alc', '4.8');
$histogram = new Histogram(new Client(), "http://127.0.0.1:9111");
$histogram->observe('BEER', 'BITBURGER', 0.33, $bucketList , $labelList);

//histogramm with labels and help text
$histogram->observe('BEER', 'BITBURGER', 0.33, $bucketList, $labelList, 'It could help');
```

## Gauge

```php
//simple gauge
$gauge = new Gauge(new Client(), "http://127.0.0.1:9111");
$gauge->inc('BEER', 'BITBURGER'); // Increase by one
$gauge->dec('BEER', 'BITBURGER'); // Decrease by one

$gauge->set('BEER', 'BITBURGER', 3); // Set value to three
$gauge->incBy('BEER', 'BITBURGER', 3); // Increase by three
$gauge->decBy('BEER', 'BITBURGER', 3); // Decrease by three

//gauge with labels
$labelList = new LabelList();
$labelList->add(new Label('type', 'Pils');
$labelList->add(new Label('alc', '4.8');
$gauge = new Gauge(new Client(), "http://127.0.0.1:9111");
$gauge->inc('BEER', 'BITBURGER', $labelList);
$gauge->dec('BEER', 'BITBURGER', $labelList);

$gauge->set('BEER', 'BITBURGER', 3, $labelList);
$gauge->incBy('BEER', 'BITBURGER', 2, $labelList);
$gauge->decBy('BEER', 'BITBURGER', 2, $labelList);

//gauge with labels and help text
$gauge->inc('BEER', 'BITBURGER', $labelList, 'It could help');
$gauge->dec('BEER', 'BITBURGER', $labelList, 'It could help');

$gauge->set('BEER', 'BITBURGER', 3, $labelList, 'It could help');
$gauge->incBy('BEER', 'BITBURGER', 3, $labelList, 'It could help');
$gauge->decBy('BEER', 'BITBURGER', 3, $labelList, 'It could help');

```

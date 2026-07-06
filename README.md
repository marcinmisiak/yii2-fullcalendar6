# yii2-fullcalendar6

Yii2 widget & asset bundle for [FullCalendar](https://fullcalendar.io) v6, vendored locally as
static files (no `npm-asset/fullcalendar` composer dependency), so it can be installed alongside
older FullCalendar-based packages (e.g. `edofre/yii2-fullcalendar`, `philippfrenzel/yii2fullcalendar`)
without any version conflict.

## Installation

Via a VCS repository (until/unless this package is published on Packagist):

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/marcinmisiak/yii2-fullcalendar6"
    }
],
"require": {
    "marcinmisiak/yii2-fullcalendar6": "dev-master"
}
```

## Usage

```php
<div id="grafik"></div>

<?php
echo \marcinmisiak\yii2fullcalendar6\Fullcalendar::widget([
    'options'  => ['id' => 'grafik'],
    'jsVar'    => 'grafikCalendar', // window.grafikCalendar
    'events'   => $urlEvents,       // JSON feed URL or array of events
    'clientOptions' => [
        'allDaySlot'  => false,
        'selectable'  => true,
        'editable'    => true,
    ],
    'select'      => "function(info) { /* ... */ }",
    'eventClick'  => "function(info) { /* ... */ }",
    'eventDrop'   => "function(info) { /* ... */ }",
    'eventResize' => "function(info) { /* ... */ }",
]);
?>
```

The widget renders the `<div>` container itself — remove the standalone one above if you pass
`'options' => ['id' => '...']`.

Afterwards, from any other script on the page, call instance methods via the configured `jsVar`:

```js
window.grafikCalendar.refetchEvents();
window.grafikCalendar.unselect();
```

## Callbacks

`select`, `eventClick`, `eventDrop`, `eventResize`, `eventDidMount` accept a raw JS function body
string (`function(info) { ... }`), following FullCalendar v6's single-`info`-object callback API
— see https://fullcalendar.io/docs/v6 for the shape of `info` per callback.

## License

MIT. Bundles FullCalendar's own MIT-licensed Standard distribution unmodified — see [LICENSE](LICENSE).

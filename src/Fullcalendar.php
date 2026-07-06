<?php

namespace marcinmisiak\yii2fullcalendar6;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;

class Fullcalendar extends Widget
{
    /** @var array atrybuty HTML kontenera div */
    public $options = [];

    /** @var array surowe opcje scalane do `new FullCalendar.Calendar(el, {...})` */
    public $clientOptions = [];

    /** @var array układ toolbaru, trafia do clientOptions['headerToolbar'], chyba że już tam ustawiony */
    public $header = [
        'left'   => 'prev,next today',
        'center' => 'title',
        'right'  => 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
    ];

    public $initialView = 'dayGridMonth';
    public $locale = 'pl';

    /** @var string|array URL feedu JSON lub tablica eventów */
    public $events;

    /** @var string surowy kod JS: function(info) { ... } */
    public $select = '';
    public $eventClick = '';
    public $eventDrop = '';
    public $eventResize = '';
    public $eventDidMount = '';
    public $eventContent = '';

    /**
     * @var string|null nazwa globalnej zmiennej JS, do której trafi instancja
     * Calendar (np. 'grafikCalendar' -> window.grafikCalendar), żeby kod w widoku
     * mógł wołać refetchEvents()/unselect() itd. Domyślnie = id kontenera.
     */
    public $jsVar;

    public function init()
    {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        if ($this->jsVar === null) {
            $this->jsVar = $this->options['id'];
        }
    }

    public function run()
    {
        echo Html::tag('div', '', $this->options);
        $this->registerPlugin();
    }

    protected function registerPlugin()
    {
        $view = $this->getView();
        CoreAsset::register($view);

        $options = $this->clientOptions;
        $options['initialView'] = $options['initialView'] ?? $this->initialView;
        $options['locale'] = $options['locale'] ?? $this->locale;

        if (!isset($options['headerToolbar'])) {
            $options['headerToolbar'] = $this->header;
        }
        if ($this->events !== null && !isset($options['events'])) {
            $options['events'] = $this->events;
        }
        foreach (['select', 'eventClick', 'eventDrop', 'eventResize', 'eventDidMount', 'eventContent'] as $cb) {
            if ($this->$cb !== '' && !isset($options[$cb])) {
                $options[$cb] = new JsExpression($this->$cb);
            }
        }

        $id = $this->options['id'];
        $jsVar = $this->jsVar;
        $json = Json::encode($options);

        $js = <<<JS
window.{$jsVar} = new FullCalendar.Calendar(document.getElementById('{$id}'), {$json});
window.{$jsVar}.render();
JS;

        $view->registerJs($js, View::POS_READY);
    }
}

<?php
$this->pagetitle = 'Контакты';
?>
<!-- Map -->	
<section id="map">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div id="mapCanvas"  class="map-canvas"></div>		  
            </div>
            <div class="call-placebo">
                <p class="uk-text-right">Записаться на прием можно по телефону:</p>
                <h2 style="float:right; margin-top: -15px;"><?= app()->settings->contactPhone; ?></h2><br>
                <p>или при личном визите в клинику в регистратуре по адресу:</p>
                <h4 style="float: right; margin-top: -5px; font-weight: 300"><?= app()->settings->address; ?></h4>
            </div>		  
        </div>
    </div>
</section>	  
<!-- /Map -->	  

<!-- Main Body -->
<section id="main-body" class="main-body contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?= PageAccess::page(21)->text; ?>
            </div>
        </div>
    </div>
</section>
<!-- /Main Body -->	  
<script type="text/javascript" src="//api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
<script type="text/javascript">
    ymaps.ready(function () {
        var geocoder = ymaps.geocode("<?= app()->settings->address; ?>");
        geocoder.then(function (res) {
            var places = new ymaps.Map('mapCanvas',
                    {
                        center: res.geoObjects.get(0).geometry.getCoordinates(),
                        zoom: 14,
                        controls: ['zoomControl', 'fullscreenControl', 'typeSelector'],
                    });
            places.geoObjects.add(new ymaps.Placemark(res.geoObjects.get(0).geometry.getCoordinates(),
                    {
                        balloonContent: '<h3>Клиника "Первый Шаг"</h3><p><?= app()->settings->address; ?></p>'
                    },
                    {
                        iconLayout: 'default#image',
                    }));
        });
    });
</script>
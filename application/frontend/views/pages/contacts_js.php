<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<script>
     ymaps.ready(function() {
        var maps = document.querySelectorAll('.map');

        maps.forEach(function(mapElement) {
          let lat = mapElement.getAttribute('data-lat');
          let lon = mapElement.getAttribute('data-lon');
          let hintContent = mapElement.getAttribute('data-hint');
          let myMap = new ymaps.Map(mapElement, {
            center: [lat, lon],
            zoom: 17
          }, {
            searchControlProvider: 'yandex#search'
          });
          let myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
            hintContent: hintContent
          }, {
            iconLayout: 'default#image',
            iconImageHref: '/imgs/metka.svg',
            iconImageSize: [48, 60],
            iconImageOffset: [-24, -30]
          });

          myMap.geoObjects.add(myPlacemark);
        });
      });
  </script>
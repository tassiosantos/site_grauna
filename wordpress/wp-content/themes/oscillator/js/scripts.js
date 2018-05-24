jQuery(function( $ ) {
	'use strict';

	/* -----------------------------------------
	Responsive Menus Init with mmenu
	----------------------------------------- */
	var $mainNav   = $( '.navigation' );
	var $mobileNav = $( '#mobilemenu' );

	$mainNav.clone().removeAttr( 'id' ).removeClass().appendTo( $mobileNav );
	$mobileNav.find( 'li' ).removeAttr( 'id' );

	$mobileNav.mmenu({
		offCanvas: {
			position: 'top',
			zposition: 'front'
		},
		"autoHeight": true,
		"navbars": [
			{
				"position": "top",
				"content": [
					"prev",
					"title",
					"close"
				]
			}
		]
	});

	/* -----------------------------------------
	Main Navigation Init
	----------------------------------------- */
	$mainNav.superfish({
		delay: 300,
		animation: { opacity: 'show', height: 'show' },
		speed: 'fast',
		dropShadows: false
	});

	/* -----------------------------------------
	Responsive Videos with fitVids
	----------------------------------------- */
	$( 'body' ).fitVids();

	/* -----------------------------------------
	Image Lightbox
	----------------------------------------- */
	$( '.ci-lightbox' ).magnificPopup({
		type: 'image',
		mainClass: 'mfp-with-zoom',
		gallery: {
			enabled: true
		},
		zoom: {
			enabled: true
		}
	} );

	/* -----------------------------------------
	Lurics Popup
	----------------------------------------- */
	$( '.btn-lyrics' ).magnificPopup({
		type: 'inline',
		mainClass: 'mfp-with-zoom',
		midClick: true
	} );


	function map_init( lat, lng, zoom, tipText, titleText ) {
		var myLatlng = new google.maps.LatLng(lat, lng);
		var mapOptions = {
			zoom: zoom,
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			styles: [{"stylers":[{"saturation":-100},{"gamma":1}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"water","stylers":[{"visibility":"on"},{"saturation":50},{"gamma":0},{"hue":"#50a5d1"}]},{"featureType":"administrative.neighborhood","elementType":"labels.text.fill","stylers":[{"color":"#333333"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"weight":0.5},{"color":"#333333"}]},{"featureType":"transit.station","elementType":"labels.icon","stylers":[{"gamma":1},{"saturation":50}]}]
		};

		var map = new google.maps.Map(document.getElementById('event_map'), mapOptions);

		var contentString = '<div class="tip-content">' + tipText + '</div>';

		var infowindow = new google.maps.InfoWindow({
			content: contentString
		});

		var marker = new google.maps.Marker({
			position: myLatlng,
			map: map,
			title: titleText
		});

		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map,marker);
		});
	}

		/* -----------------------------------------
	 Event Map Init
	 ----------------------------------------- */
	var event_map = $(".ci-map");
	if ( event_map.length ) {
		var lat = event_map.data('lat'),
			lng = event_map.data('lng'),
			zoom = event_map.data('zoom'),
			tipText = event_map.data('tooltip-txt'),
			titleText = event_map.attr('title');

		map_init(lat, lng, zoom, tipText, titleText);
	}

	/* -----------------------------------------
	Instagram Widget
	----------------------------------------- */
	var $instagramWidget = $('section').find('.instagram-pics');
	var $instagramWrap = $instagramWidget.parent('div');

	if ( $instagramWidget.length ) {
		var auto  = $instagramWrap.data('auto'),
			speed = $instagramWrap.data('speed');

		$instagramWidget.slick({
			slidesToShow: 8,
			slidesToScroll: 3,
			arrows: false,
			autoplay: auto == 1,
			speed: speed,
			responsive: [
				{
					breakpoint: 767,
					settings: {
						slidesToShow: 4
					}
				}
			]
		});
	}

	/* -----------------------------------------
	SoundManager2 Init
	----------------------------------------- */
	soundManager.setup({
		url: ThemeOption.swfPath
	});

	/* -----------------------------------------
	SoundManager2 Init
	----------------------------------------- */
	$('.sc-play').on('click', function(e) {
		e.preventDefault();

		var $parent = $(this).parents( '.list-item' );

		if ( $parent.hasClass( 'expanded' ) ) {
			$parent.find( '.soundcloud-wrap' ).fadeOut( 'fast', function() {
				$parent.removeClass( 'expanded sm2_container_playing' );
			});
		} else {
			$parent.addClass( 'expanded sm2_container_playing' );
			$parent.find( '.soundcloud-wrap' ).fadeIn(350);
		}
	});
	
	$( window ).on( 'load', function() {

		/* -----------------------------------------
		FlexSlider Init
		----------------------------------------- */
		var homeSlider = $( '.home-slider' );

		if ( homeSlider.length ) {
			var animation    = homeSlider.data( 'animation' ),
				direction      = homeSlider.data( 'direction' ),
				slideshow      = homeSlider.data( 'slideshow' ),
				slideshowSpeed = homeSlider.data( 'slideshowspeed' ),
				animationSpeed = homeSlider.data( 'animationspeed' );

			homeSlider.flexslider({
				animation     : animation,
				direction     : direction,
				slideshow     : slideshow,
				slideshowSpeed: slideshowSpeed,
				animationSpeed: animationSpeed,
				namespace: 'ci-',
				prevText: '',
				nextText: '',
				directionNav: false,
				start: function( slider ) {
					slider.removeClass( 'loading' );
				}
			});
		}

		/* -----------------------------------------
		Homepage audio player autoplay
		----------------------------------------- */
		$(".autoplay").find('.ci-soundplayer-play').trigger('click');


		/* -----------------------------------------
		Isotope / Masonry
		----------------------------------------- */
		var $container = $('.list-masonry'),
			$filters = $(".filters-nav");

		$container.isotope();

		if ( $filters.length ) {
			$('.filters-nav li a').click(function(){
				var selector = $(this).attr('data-filter');
				var filterLinks = $(this).parent().siblings().find('a');
				filterLinks.addClass('btn-transparent');
				filterLinks.removeClass('selected');
				$(this).removeClass("btn-transparent");
				$(this).addClass("selected");

				$container.isotope({
					filter: selector,
					animationOptions: {
						duration: 750,
						easing: 'linear',
						queue: false
					}
				});

				return false;
			});
		}
	});

});

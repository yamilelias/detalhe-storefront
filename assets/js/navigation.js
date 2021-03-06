/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 * Also adds a focus class to parent li's for accessibility.
 * Finally adds a class required to reveal the search in the handheld footer bar.
 */
( function() {
	// Add class to footer search when clicked
	jQuery( window ).on('load', function() {
		jQuery( '.storefront-handheld-footer-bar .search > a' ).click( function(e) {
			jQuery( this ).parent().toggleClass( 'active' );
			e.preventDefault();
		});
	});

	var container, button, menu;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );

	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// Sub-menu access from touchscreens
		var masthead       = jQuery( '#masthead' );
		var siteNavigation = masthead.find( '.main-navigation > div > ul' );

		function toggleFocusClassTouchScreen() {

			// Ensure the dropdowns close when user taps outside the site header
			jQuery( document.body ).on( 'touchstart.storefront', function( e ) {
				if ( ! jQuery( e.target ).closest( '.main-navigation li' ).length ) {
					jQuery( '.main-navigation li' ).removeClass( 'focus' );
				}
			});

			// Disables the link from working on the first touch of a menu with children
			siteNavigation.find( '.menu-item-has-children > a, .page_item_has_children > a' )
				.on( 'touchstart.storefront', function( e ) {
					var el = jQuery( this ).parent( 'li' );

					if ( ! el.hasClass( 'focus' ) ) {
						e.preventDefault();
						el.toggleClass( 'focus' );
						el.siblings( '.focus' ).removeClass( 'focus' );
					}
				});
		}
		// Add Focus Class for parents of sub-menus
		siteNavigation.find( 'a' ).on( 'focus.storefront blur.storefront', function() {
			jQuery( this ).parents( '.menu-item, .page_item' ).toggleClass( 'focus' );
		});

		// Triggers toggleFocusClassTouchScreen on touchscreen devices
		if ( 'ontouchstart' in window ) {
			jQuery( window ).on( 'resize.storefront', toggleFocusClassTouchScreen );
			toggleFocusClassTouchScreen();
		}

	// Add focus to cart dropdown
	jQuery( window ).on('load', function() {
		jQuery( '.site-header-cart' ).find( 'a' ).on( 'focus.storefront blur.storefront', function() {
			jQuery( this ).parents().toggleClass( 'focus' );
		});
	});

	if ( is_touch_device() && jQuery( window ).width() > 767 ) {
		// Add an identifying class to dropdowns when on a touch device
		// This is required to switch the dropdown hiding method from a negative `left` value to `display: none`.
		jQuery( '.main-navigation ul ul, .secondary-navigation ul ul, .site-header-cart .widget_shopping_cart' ).addClass( 'sub-menu--is-touch-device' );

	}

	/**
	 * Check if the device is touch enabled
	 * @return Boolean
	 */
	function is_touch_device() {
		return 'ontouchstart' in window || navigator.maxTouchPoints;
	}
} )();

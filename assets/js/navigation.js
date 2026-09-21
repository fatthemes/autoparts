/**
 * Autoparts — Header & Navigation Interactions
 *
 * Handles the mobile hamburger menu, mobile search toggle,
 * header scroll shadow, WooCommerce cart count updates,
 * keyboard focus trapping, and viewport resize cleanup.
 *
 * @package autoparts
 */

document.addEventListener( 'DOMContentLoaded', function () {

	'use strict';

	/* =====================================================
	 * SHARED ELEMENT REFERENCES
	 * Queried once up front so event handlers below don't
	 * repeatedly re-query the DOM on every interaction.
	 * ===================================================== */
	var navToggle    = document.querySelector( 'button.nav-toggle' );
	var primaryNav   = document.querySelector( 'nav.primary-navigation' );
	var searchToggle = document.querySelector( 'button.search-toggle' );
	var searchBar    = document.querySelector( 'div.header-search-bar' );
	var siteHeader   = document.querySelector( 'header.wp-block-template-part' );

	/* =====================================================
	 * FEATURE 1 — MOBILE HAMBURGER MENU
	 * Controls the primary navigation on mobile.
	 * The nav-toggle button shows/hides the menu.
	 * ===================================================== */

	/**
	 * Opens the mobile primary navigation.
	 */
	function openMenu() {
		if ( ! navToggle || ! primaryNav ) {
			return;
		}

		document.body.classList.add( 'is-menu-open' );
		navToggle.setAttribute( 'aria-expanded', 'true' );
		primaryNav.setAttribute( 'aria-hidden', 'false' );

		/*
		 * Move focus into the menu so keyboard and screen
		 * reader users land on the first link instead of
		 * staying on a now-hidden-in-place toggle button.
		 */
		var firstLink = primaryNav.querySelector( 'a' );
		if ( firstLink ) {
			firstLink.focus();
		}
	}

	/**
	 * Closes the mobile primary navigation.
	 */
	function closeMenu() {
		if ( ! navToggle || ! primaryNav ) {
			return;
		}

		document.body.classList.remove( 'is-menu-open' );
		navToggle.setAttribute( 'aria-expanded', 'false' );
		primaryNav.setAttribute( 'aria-hidden', 'true' );
		navToggle.focus();
	}

	/*
	 * Toggle the menu open/closed on click. Reading the
	 * current state off the body class 
	 */
	if ( navToggle && primaryNav ) {
		navToggle.addEventListener( 'click', function () {
			var isOpen = document.body.classList.contains( 'is-menu-open' );

			if ( isOpen ) {
				closeMenu();
			} else {
				openMenu();
			}
		} );
	}

	/* =====================================================
	 * FEATURE 2 — MOBILE SEARCH TOGGLE
	 * Shows/hides a search bar on mobile when the search
	 * icon button is tapped. The mobile bar (parts/header.html)
	 * starts empty; a small search form is built below and
	 * inserted into it once. 
	 * ===================================================== */

	if ( searchToggle && searchBar ) {

		/* Build a simple search form for mobile
		   that submits to WooCommerce product search */
		var mobileSearchForm = document.createElement( 'form' );
		mobileSearchForm.setAttribute( 'role', 'search' );
		mobileSearchForm.setAttribute( 'method', 'get' );
		mobileSearchForm.setAttribute( 'action', autopartsData.homeUrl );
		mobileSearchForm.className = 'mobile-search-form';

		var mobileSearchInput = document.createElement( 'input' );
		mobileSearchInput.setAttribute( 'type', 'search' );
		mobileSearchInput.setAttribute( 'name', 's' );
		mobileSearchInput.setAttribute( 'placeholder', autopartsData.searchPlaceholder );
		mobileSearchInput.setAttribute( 'aria-label', autopartsData.searchPlaceholder );
		mobileSearchInput.className = 'mobile-search-input';

		/* Hidden input to filter WooCommerce products */
		var postTypeInput = document.createElement( 'input' );
		postTypeInput.setAttribute( 'type', 'hidden' );
		postTypeInput.setAttribute( 'name', 'post_type' );
		postTypeInput.setAttribute( 'value', 'product' );

		var mobileSearchBtn = document.createElement( 'button' );
		mobileSearchBtn.setAttribute( 'type', 'submit' );
		mobileSearchBtn.setAttribute( 'aria-label', autopartsData.searchAriaLabel );
		mobileSearchBtn.className = 'mobile-search-btn';
		mobileSearchBtn.textContent = autopartsData.searchButtonText;

		mobileSearchForm.appendChild( mobileSearchInput );
		mobileSearchForm.appendChild( postTypeInput );
		mobileSearchForm.appendChild( mobileSearchBtn );
		searchBar.appendChild( mobileSearchForm );
	}

	/**
	 * Opens the mobile search bar and focuses its input.
	 * Why focus immediately (unlike the menu, which focuses
	 * the first link): a search bar's only purpose is typing,
	 * so the input should be ready for input the instant it
	 * becomes visible. The input is queried fresh here rather
	 * than cached up front, since it doesn't exist in the DOM
	 * until the clone above runs.
	 */
	function openSearch() {
		if ( ! searchToggle || ! searchBar ) {
			return;
		}

		document.body.classList.add( 'is-search-open' );
		searchToggle.setAttribute( 'aria-expanded', 'true' );
		searchBar.hidden = false;

		var input = searchBar.querySelector( 'input' );
		if ( input ) {
			input.focus();
		}
	}

	/**
	 * Closes the mobile search bar and restores focus to
	 * the toggle button that opened it.
	 */
	function closeSearch() {
		if ( ! searchToggle || ! searchBar ) {
			return;
		}

		document.body.classList.remove( 'is-search-open' );
		searchToggle.setAttribute( 'aria-expanded', 'false' );
		searchBar.hidden = true;
		searchToggle.focus();
	}

	if ( searchToggle && searchBar ) {
		searchToggle.addEventListener( 'click', function () {
			var isOpen = document.body.classList.contains( 'is-search-open' );

			if ( isOpen ) {
				closeSearch();
			} else {
				openSearch();
			}
		} );
	}

	/*
	 * Outside-click handling for both the menu and the search
	 * bar lives in one delegated document listener rather than
	 * two separate ones — a single click can only ever need to
	 * be checked against whichever overlay is currently open.
	 */
	document.addEventListener( 'click', function ( event ) {
		var isMenuOpen   = document.body.classList.contains( 'is-menu-open' );
		var isSearchOpen = document.body.classList.contains( 'is-search-open' );

		if ( isMenuOpen ) {
			var clickedInsideNav = primaryNav && primaryNav.contains( event.target );
			var clickedNavToggle = navToggle && navToggle.contains( event.target );

			if ( ! clickedInsideNav && ! clickedNavToggle ) {
				closeMenu();
			}
		}

		if ( isSearchOpen ) {
			var clickedInsideSearch = searchBar && searchBar.contains( event.target );
			var clickedSearchToggle = searchToggle && searchToggle.contains( event.target );

			if ( ! clickedInsideSearch && ! clickedSearchToggle ) {
				closeSearch();
			}
		}
	} );

	/* =====================================================
	 * FEATURE 3 — SCROLL SHADOW
	 * Adds a shadow to the header once the user scrolls
	 * past 50px, so the header visually separates from
	 * page content once it's no longer at the very top.
	 * ===================================================== */

	var SCROLL_SHADOW_THRESHOLD = 50;
	var scrollTicking = false;

	/**
	 * Applies or removes the 'is-scrolled' class based on
	 * the current scroll position. 
	 */
	function updateHeaderScrollState() {
		if ( ! siteHeader ) {
			scrollTicking = false;
			return;
		}

		if ( window.scrollY > SCROLL_SHADOW_THRESHOLD ) {
			siteHeader.classList.add( 'is-scrolled' );
		} else {
			siteHeader.classList.remove( 'is-scrolled' );
		}

		scrollTicking = false;
	}

	/*
	 * Without this
	 * guard, a fast scroll fires far more events than the
	 * screen can repaint, wasting work on frames the user
	 * never sees. 
	 */
	window.addEventListener( 'scroll', function () {
		if ( ! scrollTicking ) {
			window.requestAnimationFrame( updateHeaderScrollState );
			scrollTicking = true;
		}
	}, { passive: true } );

	/* =====================================================
	 * FEATURE 4 — WOOCOMMERCE CART COUNT UPDATE
	 * Keeps the cart count badge in the header in sync
	 * after AJAX add-to-cart actions, without a full
	 * page reload.
	 * ===================================================== */

	/**
	 * Refreshes the visible cart count and its accessible
	 * label. WooCommerce's own fragment refresh already
	 * replaces span.cart-count's markup after
	 * 'wc_fragments_refreshed'; the localized cartCount value
	 * is used as an immediate fallback for 'added_to_cart',
	 * which can fire slightly before the fragment response
	 * returns. The aria-label on the parent link is outside
	 * the fragment's scope, so it always needs updating here.
	 */
	function updateCartCount() {
		var cartCountEl = document.querySelector( 'span.cart-count' );

		if ( ! cartCountEl ) {
			return;
		}

		if ( typeof autopartsData !== 'undefined' && typeof autopartsData.cartCount !== 'undefined' ) {
			cartCountEl.textContent = autopartsData.cartCount;
		}

		var cartLink = cartCountEl.closest( '.cart-link' );

		if ( cartLink ) {
			var count = cartCountEl.textContent.trim();
			cartLink.setAttribute( 'aria-label', 'Shopping cart, ' + count + ' items' );
		}
	}

	/*
	 * WooCommerce triggers these as events on document.body.
	 * Listening here (rather than only on page load) is what
	 * keeps the badge accurate across the whole session.
	 */
	document.body.addEventListener( 'wc_fragments_refreshed', updateCartCount );
	document.body.addEventListener( 'added_to_cart', updateCartCount );

	/* =====================================================
	 * FEATURE 5 — KEYBOARD NAVIGATION
	 * Ensures the mobile menu and search bar are fully
	 * keyboard accessible per WCAG 2.1 AA. Escape closes
	 * whichever overlay is open; Tab is trapped inside the
	 * open mobile menu so focus can't silently escape to
	 * content hidden behind it.
	 * ===================================================== */

	document.addEventListener( 'keydown', function ( event ) {
		var isMenuOpen   = document.body.classList.contains( 'is-menu-open' );
		var isSearchOpen = document.body.classList.contains( 'is-search-open' );

		/* Escape closes whichever overlay is currently open. */
		if ( 'Escape' === event.key ) {
			if ( isMenuOpen ) {
				closeMenu();
			}

			if ( isSearchOpen ) {
				closeSearch();
			}

			return;
		}

		/* Everything below this point only applies to the
		 * focus trap, which is only relevant while the menu
		 * is open and the key pressed is Tab. */
		if ( ! isMenuOpen || 'Tab' !== event.key ) {
			return;
		}

		var focusableItems = primaryNav ? primaryNav.querySelectorAll( 'a' ) : [];

		if ( ! focusableItems.length ) {
			return;
		}

		var firstItem = focusableItems[ 0 ];
		var lastItem  = focusableItems[ focusableItems.length - 1 ];

		/*
		 * Wrap focus around the ends of the menu instead of
		 * letting it move to whatever comes next/previous in
		 * the underlying page, which would visually "escape"
		 * an overlay that's supposed to be modal on mobile.
		 */
		if ( event.shiftKey && document.activeElement === firstItem ) {
			event.preventDefault();
			lastItem.focus();
		} else if ( ! event.shiftKey && document.activeElement === lastItem ) {
			event.preventDefault();
			firstItem.focus();
		}
	} );

	/* =====================================================
	 * FEATURE 6 — RESIZE HANDLER
	 * Cleans up mobile-only open states when the viewport
	 * is resized to desktop width, so rotating a device or
	 * resizing a browser window can't leave the menu or
	 * search bar stuck open behind desktop styles.
	 * ===================================================== */

	var DESKTOP_BREAKPOINT = 1024;
	var resizeTimeout;

	/**
	 * Resets mobile overlay state for desktop widths. Runs
	 * debounced (see listener below) rather than on every
	 * resize tick, since resizing fires far more events than
	 * this cleanup needs to run.
	 */
	function handleResize() {
		if ( window.innerWidth <= DESKTOP_BREAKPOINT ) {
			return;
		}

		document.body.classList.remove( 'is-menu-open' );
		document.body.classList.remove( 'is-search-open' );

		if ( navToggle ) {
			navToggle.setAttribute( 'aria-expanded', 'false' );
		}

		if ( searchToggle ) {
			searchToggle.setAttribute( 'aria-expanded', 'false' );
		}

		if ( searchBar ) {
			searchBar.hidden = true;
		}

		if ( primaryNav ) {
			primaryNav.removeAttribute( 'aria-hidden' );
		}
	}

	/*
	 * Debounce: clear any pending timeout and start a new one
	 * on every resize event, so handleResize() only actually
	 * runs once the user has stopped resizing for 250ms.
	 */
	window.addEventListener( 'resize', function () {
		window.clearTimeout( resizeTimeout );
		resizeTimeout = window.setTimeout( handleResize, 250 );
	} );

	/* =====================================================
	 * FEATURE 7 — MY ACCOUNT LOGIN / REGISTER TOGGLE
	 * On the logged-out My Account page, WooCommerce renders
	 * the login and register forms together in one shortcode
	 * (.u-column1 / .u-column2). Only login should show on
	 * load; the two links added via functions.php
	 * (data-account-toggle="register" / "login") switch which
	 * one is visible. Neither form is ever removed from the
	 * DOM - WooCommerce needs both present to process
	 * submission - only their wrapping column is hidden.
	 * ===================================================== */

	var loginColumn    = document.querySelector( '.u-column1' );
	var registerColumn = document.querySelector( '.u-column2' );

	if ( loginColumn && registerColumn ) {

		/* Default to login on page load. */
		registerColumn.classList.add( 'is-hidden' );

		/**
		 * Shows one column and hides the other, then moves
		 * focus into the newly visible form - same reasoning
		 * as openMenu()/openSearch() above.
		 *
		 * @param {Element} showColumn The column to reveal.
		 * @param {Element} hideColumn The column to hide.
		 */
		function switchAccountForm( showColumn, hideColumn ) {
			hideColumn.classList.add( 'is-hidden' );
			showColumn.classList.remove( 'is-hidden' );

			var firstField = showColumn.querySelector( 'input' );
			if ( firstField ) {
				firstField.focus();
			}
		}

		/*
		 * Delegated so it keeps working regardless of where
		 * inside the login/register markup the links end up -
		 * matches the outside-click listener's approach above.
		 */
		document.addEventListener( 'click', function ( event ) {
			var toggleLink = event.target.closest( '[data-account-toggle]' );

			if ( ! toggleLink ) {
				return;
			}

			event.preventDefault();

			if ( 'register' === toggleLink.dataset.accountToggle ) {
				switchAccountForm( registerColumn, loginColumn );
			} else if ( 'login' === toggleLink.dataset.accountToggle ) {
				switchAccountForm( loginColumn, registerColumn );
			}
		} );
	}

	/* =====================================================
	 * FEATURE 8 — WOOCOMMERCE GALLERY KEYBOARD-TRAP FIX
	 * Works around a bug in WooCommerce core's Product Gallery
	 * block (single-product.html's woocommerce/product-gallery
	 * block, on any product with more than one image).
	 *
	 * Do not remove this thinking it's dead code - without it,
	 * keyboard and screen reader users cannot get past the product
	 * gallery on any multi-image product page.
	 * ===================================================== */

	document.addEventListener( 'keydown', function ( event ) {
		if ( 'Tab' !== event.key ) {
			return;
		}

		if ( ! event.target.closest( '.wc-block-product-gallery-thumbnails__thumbnail__image' ) ) {
			return;
		}

		event.stopImmediatePropagation();
	}, true );

} );

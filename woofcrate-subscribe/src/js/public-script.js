/* eslint no-unused-vars: ["error", { "args": "none" }] */
/* global wc_add_to_cart_params, woSu */

'use strict';

( function ( $, root ) {
	let order = {},
		selectedPlan = {},
		dogInfo = {},
		giftInfo = {
			rcpeName: '',
			yourName: '',
			message: '',
		},
		lastIndex = 0,
		extraToy = 'No',
		douTro = 'No';

	const $woSu = $( '#woSu' ),
		$woSuStep = $( '#woSuStep' ),
		$sections = $woSu.find( '> section' ),
		setOrder = jObj => {
			for ( let value of jObj.data( 'variations' ) ) {
				if ( value.attributes.attribute_pa_plans === selectedPlan.slug ) {
					order = {
						pName: jObj.find( 'h4' ).text(),
						pID: parseInt( jObj.data( 'id' ) ),
						vName: selectedPlan.name,
						vID: parseInt( value.variation_id ),
						regularPrice: parseFloat( value.display_regular_price ),
						price: parseFloat( value.display_price ),
						dogName: dogInfo.name,
						dogGender: dogInfo.gender,
						dogMOB: dogInfo.mob,
						dogSize: dogInfo.size.name,
						dogAllergy: dogInfo.allergy,
						extraToy: extraToy,
						douTro: douTro,
					};

					$( '#pName' ).text( order.pName );
					$( '#vName' ).text( order.vName );
					$( '#price' ).text( woSu.currency + order.price );
					$( '#dogNameF' ).text( order.dogName );
					$( '#dogGenderF' ).text( order.dogGender );
					$( '#dogMOBF' ).text( order.dogMOB );
					$( '#dogSizeF' ).text( order.dogSize );
					$( '#xToy' ).text( order.extraToy );
					$( '#douTro' ).text( order.douTro );

					if ( order.dogAllergy.toString().length > 20 ) {
						$( '#dogAllergy' ).addClass( 'long-text' ).text( order.dogAllergy );
					} else {
						$( '#dogAllergy' ).removeClass( 'long-text' ).text( order.dogAllergy );
					}

					if ( woSu.mode === 'gift' ) {
						$( '#giftReceive' ).text( giftInfo.rcpeName );
						$( '#giftSend' ).text( giftInfo.yourName );
						$( '#giftMessage' ).text( giftInfo.message );

						if ( giftInfo.message.toString().length > 20 ) {
							$( '#giftMessage' ).addClass( 'long-text' ).text( giftInfo.message );
						} else {
							$( '#giftMessage' ).removeClass( 'long-text' ).text( giftInfo.message );
						}
					}

					break;
				}
			}
		},
		showError = ( i, m ) => {
			$( `#woSu-p-${i} .section-err` ).text( '' ).text( m );
		};

	$woSu.steps({
		headerTag: 'h3',
		bodyTag: 'section',
		enablePagination: false,
		transitionEffect: 'fade',
		startIndex: woSu.mode === 'subscribe' ? 1 : 0,
		onInit: ( e, ci ) => {
			$woSuStep.animate({
				width: ( ( ci / $sections.length ) * 100 ).toString() + '%',
			}, 400, 'linear' );
		},
		onStepChanging: ( e, ci, ni ) => {
			const $crate = $( '#crates .selected' );

			switch ( ci ) {
				case 1: {
					dogInfo.name = $( '#dogName' ).val();
					dogInfo.gender = $( 'input[name="dog_gender"]:checked' ).val() || '';
					dogInfo.mob = $( '#dogMOB' ).val();

					if ( ( dogInfo.name === '' || dogInfo.gender === '' || dogInfo.mob === '' ) && ni > ci ) {
						showError( ci, woSu.message.m1 );
						return false;
					}

					$woSu.find( '.dog-name' ).text( dogInfo.name );

					if ( ! $.isEmptyObject( selectedPlan ) && ! $.isEmptyObject( order ) ) {
						setOrder( $crate );
					}

					break;
				}

				case 2:
					if ( $( '#size .selected' ).length === 0 && ni > ci ) {
						showError( ci, woSu.message.m2 );
						return false;
					}

					if ( ! $.isEmptyObject( selectedPlan ) && ! $.isEmptyObject( order ) ) {
						setOrder( $crate );
					}

					break;

				case 3: {
					const $allergy = $( '#allergy .selected' ),
						$descAllergy = $( '#descAllergy' ).val(),
						id = $allergy.attr( 'id' );

					if ( $allergy.length === 0 && ni > ci ) {
						showError( ci, woSu.message.m3 );
						return false;
					}

					if ( id === 'haveAllergy' && $descAllergy === '' && ni > ci ) {
						showError( ci, woSu.message.m4 );
						return false;
					}

					if ( id === 'haveAllergy' ) {
						dogInfo.allergy = $descAllergy;
					} else if ( id === 'noAllergy' ) {
						dogInfo.allergy = 'No';
					}

					if ( ! $.isEmptyObject( selectedPlan ) && ! $.isEmptyObject( order ) ) {
						setOrder( $crate );
					}

					break;
				}

				case 4: {
					if ( $crate.length === 0 && ni > ci ) {
						showError( ci, woSu.message.m5 );
						return false;
					}

					if ( ! $.isEmptyObject( selectedPlan ) ) {
						setOrder( $crate );
					}

					break;
				}

				case 5:
					if ( $( '#plans .selected' ).length === 0 && ni > ci ) {
						showError( ci, woSu.message.m6 );
						return false;
					}

					setOrder( $crate );

					break;

				case 6:
				case 7:
					setOrder( $crate );

					break;

				case 8: {
					if ( woSu.mode === 'gift' ) {
						giftInfo = {
							rcpeName: $( '#rcpeName' ).val(),
							yourName: $( '#yourName' ).val(),
							message: $( '#message' ).val(),
						};

						setOrder( $crate );
					}

					break;
				}
			}

			showError( ci, '' );

			return true;
		},
		onStepChanged: ( e, ci, pi ) => {
			lastIndex = pi;

			$woSuStep.animate({
				width: ( ( ci / $sections.length ) * 100 ).toString() + '%',
			}, 400, 'linear' );

			if ( woSu.mode === 'gift' && pi === 8 ) {
				$( '#giftTo' ).text( giftInfo.rcpeName );
				$( '#giftFrom' ).text( giftInfo.yourName );
				$( '#giftMessage' ).text( giftInfo.message );
			}

			$( 'html, body' ).animate({
				scrollTop: 0,
			});
		},
		onFinished: ( e, ci ) => {
			order.dt = $( '#dt' ).val();
			order.action = 'woofsubsAddToCart';

			if ( woSu.mode === 'gift' ) {
				order.gift = 1;
				order.giftToName = giftInfo.rcpeName;
				order.giftFromName = giftInfo.yourName;
				order.giftMessage = giftInfo.message;
			}

			$.post( wc_add_to_cart_params.ajax_url, order, data => {
				if ( data.status === 'ok' ) {
					root.location = woSu.checkoutURL;
				} else {
					$( 'button[data-href="#f"]' ).prop( 'disabled', 'false' );
					$woSu.unblock();
					alert( data.message );
				}
			}, 'json' );
		},
	});

	$( '.series' ).on( 'click', '.boxes > div', function () {
		const $this = $( this ),
			$parent = $this.parent(),
			$series = $this.parents( '.series' );

		switch ( $series.attr( 'id' ) ) {
			case 'size':
				dogInfo.size = {
					name: $this.find( 'h4' ).text(),
					slug: $parent.data( 'slug' ),
				};

				break;

			case 'plans':
				selectedPlan = {
					name: $this.find( 'h4' ).text(),
					slug: $parent.data( 'slug' ),
				};

				break;

			case 'doubleTrouble':
			case 'extraToy':
				$series.next().find( '.far' ).trigger( 'click' );

				return false;
		}

		$parent.addClass( 'selected' ).siblings().removeClass( 'selected' );

		if ( lastIndex === $sections.length - 1 ) {
			$( '.steps .last > a' ).trigger( 'click' );
		} else {
			$woSu.steps( 'next' );
		}
	});

	$( '.checkbox .far' ).on( 'click', function () {
		const $this = $( this );

		switch ( $this.parent().attr( 'id' ) ) {
			case 'isAddToy':
				if ( $this.hasClass( 'fa-circle' ) ) {
					extraToy = 'Yes';
				} else {
					extraToy = 'No';
				}

				break;

			case 'isDouble':
				if ( $this.hasClass( 'fa-circle' ) ) {
					douTro = 'Yes';
				} else {
					douTro = 'No';
				}

				break;
		}

		$this.toggleClass( 'fa-circle fa-check-circle' );
	});

	$( '.yesno' ).on( 'click', function ( e ) {
		const $this = $( this ),
			$parent = $this.parent();

		$this.addClass( 'selected' ).siblings().removeClass( 'selected' );

		switch ( $parent.attr( 'id' ) ) {
			case 'allergy': {
				e.preventDefault();

				const $descAllergyWrap = $parent.next();

				if ( $this.attr( 'id' ) === 'haveAllergy' ) {
					$descAllergyWrap.removeClass( 'hide' );
				} else if ( $this.attr( 'id' ) === 'noAllergy' ) {
					$descAllergyWrap.addClass( 'hide' );

					if ( lastIndex === $sections.length - 1 ) {
						$( '.steps .last > a' ).trigger( 'click' );
					} else {
						$woSu.steps( 'next' );
					}
				}

				break;
			}

			case 'subsGift':
				if ( $this.attr( 'id' ) === 'gotoGif' ) {
					e.preventDefault();

					if ( lastIndex === $sections.length - 1 ) {
						$( '.steps .last > a' ).trigger( 'click' );
					} else {
						$woSu.steps( 'next' );
					}
				}

				break;
		}
	});

	$( '.sections > nav > button' ).on( 'click', function ( e ) {
		e.preventDefault();

		const $this = $( this ),
			href = $this.data( 'href' );

		if ( href === '#n' ) {
			if ( lastIndex === $sections.length - 1 ) {
				$( '.steps .last > a' ).trigger( 'click' );
			} else {
				$woSu.steps( 'next' );
			}
		} else if ( href === '#p' ) {
			$woSu.steps( 'previous' );
		} else if ( href === '#f' ) {
			$this.prop( 'disabled', 'true' );
			$woSu.block();
			$woSu.steps( 'finish' );
		}
	});

	$( '.summary .fa-edit' ).on( 'click', function ( e ) {
		e.preventDefault();

		$( `.steps #woSu-t-${$( this ).data( 'step' )}` ).trigger( 'click' );
	});
})( jQuery, window );

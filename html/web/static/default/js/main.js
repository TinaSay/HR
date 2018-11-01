// Modal
var ModalEffects = (function() {

	function init() {
	  var overlay = document.querySelector( '.md-overlay' );
	  [].slice.call( document.querySelectorAll( '.md-trigger' ) ).forEach( function( el, i ) {
	    var modal = document.querySelector( '#' + el.getAttribute( 'data-modal' ) ),
	        close = modal.querySelector( '.md-close' );

	    function removeModal( hasPerspective ) {
	      classie.remove( modal, 'md-show' );

	      if( hasPerspective ) {
	        classie.remove( document.documentElement, 'md-perspective' );
	      }
	    }

	    function removeModalHandler() {
	      removeModal( classie.has( el, 'md-setperspective' ) ); 
	    }

	    el.addEventListener( 'click', function( ev ) {
	      classie.add( modal, 'md-show' );
	      $('html').addClass('md-shown');
          $('.tabs_nav.' + $(this).data('tab')).trigger('click', [$(this).data('goal')]);
	      overlay.removeEventListener( 'click', removeModalHandler );
	      overlay.addEventListener( 'click', removeModalHandler );

	      if( classie.has( el, 'md-setperspective' ) ) {
	        setTimeout( function() {
	          classie.add( document.documentElement, 'md-perspective' );
	        }, 25 );
	      }
	    });

	    close.addEventListener( 'click', function( ev ) {
	      ev.stopPropagation();
	      removeModalHandler();
	      $('html').removeClass('md-shown');
	    });
    
	  });
	}

	if($('.md-trigger[data-modal]').length > 0) {
		init();
	}

	

})();

// checkbox
initChecbox();

// autoresize area
$('textarea').autoResize();


// link scroll

$('a.link-scroll').on('click',function (e) {
  e.preventDefault();
	var target = this.hash,
	$target = $(target);
  $('html, body').stop().animate({
		'scrollTop': $target.offset().top - 100
	}, 500, 'swing');
});

if (window.location.hash == '#section-about') {
	var target = window.location.hash,
			$target = $(target);
	$('html, body').stop().animate({
		'scrollTop': $target.offset().top - 100
	}, 500, 'swing');
}

//more-block
function MoreBlock(ell) {
	var key = true,
			stVal = $(ell).text(),
			acVal = $(ell).attr('data-active'),
			sectionScr = $(ell).attr('data-section');

	$(ell).on('click', function(){
		if (key) {
			key = false;
			$(this).parent().find('.content-more').fadeIn(200);
			$(this).text(acVal);
		} else {
			key = true;
			$(this).parent().find('.content-more').fadeOut(200);
			$(this).text(stVal);
			$('html, body').stop().animate({
				'scrollTop': $(sectionScr).offset().top - 100
			}, 200, 'swing');
		}	
	});
}

var morelList = $('.control-more');
for (var i = 0; i < morelList.length; i++) {	
	new MoreBlock(morelList[i]);
}


// autorization
(function() {
  var regDiv = $('#modalLogIn #registration');
  $('.reg-step-wrap .reg-step-card:not(.active)').fadeOut(0);

  $('.reg-step-open').on('click', function(e){
  	e.preventDefault();
  	var ell = $(this).attr('href'),
  		height = $(ell).outerHeight();

  	regDiv.css('height', height + 46 +'px');	  

  	$('.reg-step-wrap .reg-step-card').removeClass('active');
  	$(ell).addClass('active');

  	$('.reg-step-wrap .reg-step-card:not(.active)').fadeOut(200, function(){
  		setTimeout(function() { 			
  			$(ell).fadeIn(200);
  		},200);
  	});
  });

  $(window).on('resize', function(){
  	var height = $('.reg-step-wrap .reg-step-card.active').outerHeight();
  	regDiv.css('height', height + 46 +'px');	
  });

})();



// user information
(function() {


  $('.collapsable-accordion').collapsable({
	  accordion: true,
	  fx: 'slide',
	  fxDuration: 300
	});

	$('.collapsable-slide').collapsable({
	  fx: 'slide',
	  fxDuration: 300
	});


  $('.user-tabs').easytabs();

})();




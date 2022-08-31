/* eslint-disable */
import {init as faqInit} from "../components/faq";
import {init as contentBlock} from "../components/block-content";
import {init as testimonialsSlider} from "../components/testimonials-slider";
import {init as tweetsSlider} from "../components/tweets-slider";
import {init as paragraphLineAnimation} from "../components/paragraph-line-animation";
import {init as strokeLinesAnimation} from "../components/stroke-lines-animation";
import {init as animationStart} from "../components/animate-by-viewport";
import {init as tabs} from "../components/tabs";
// import {ScrollSpy, Collapse} from "bootstrap";

export default {
  init() {
    // JavaScript to be fired on all pages
    /**
     * Modernizr custom tests
     */
    Modernizr.addTest('IE', function() {
      return window.navigator.userAgent.indexOf('MSIE ') > -1 || window.navigator.userAgent.indexOf('Trident/') > -1;
    });
    Modernizr.addTest('has-scroll', function() {
      return window.innerHeight < document.body.scrollHeight;
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
    faqInit();
    contentBlock();
    testimonialsSlider();
    tweetsSlider();
    tabs();
  
    const mobileMenu = document.getElementById( 'navPrimaryMenu' );
    const eyebrow = document.querySelector( '.eyebrow-section' );
    const header = document.getElementById( 'site-navbar' );
    
    // window.addEventListener( 'shown.bs.collapse', function() {
    //   if ( window.innerWidth < 1200 ) {
    //     let topHeight = eyebrow.offsetHeight + header.offsetHeight;
    //     mobileMenu.style.height = ( window.innerHeight - topHeight ) + 'px';
    //     document.querySelector( 'body' ).classList.add( 'menu-show' );
    //   }
    // } );
    //
    // window.addEventListener( 'hidden.bs.collapse', function() {
    //   document.querySelector( 'body' ).classList.remove( 'menu-show' );
    // } );
    
    const readmore = document.querySelectorAll( '.readmore-hidden' );
    if ( readmore.length ) {
      readmore.forEach( ( item ) => {
        let readMoreBut = document.createElement( 'span' );
        readMoreBut.innerHTML = "Read more";
        readMoreBut.classList.add( 'readmore-but' );
        item.appendChild( readMoreBut );
        item.querySelector( '.readmore-but' ).addEventListener( 'click', function ( but ) {
          if ( item.classList.contains( 'opened' ) ) {
            item.classList.remove( 'opened' );
            but.target.innerHTML = "Read more";
          } else {
            item.classList.add( 'opened' );
            but.target.innerHTML = "Read less";
          }
        } )
      } )
    }
  
    window.addEventListener( 'scroll', function( e ) {
      let goToTop = document.getElementById( 'back-to-top' );
      let navBar = document.querySelector( 'header.banner' );
      if ( window.scrollY > ( window.innerHeight - window.innerHeight / 2 ) ) {
        if ( ! goToTop.classList.contains( 'show' ) ) {
          goToTop.classList.add( 'show' );
        }
      } else {
        if ( goToTop.classList.contains( 'show' ) ) {
          goToTop.classList.remove( 'show' );
        }
      }
  
      if ( window.scrollY > 53 ) {
        if ( ! navBar.classList.contains( 'sticky-header' ) ) {
          navBar.classList.add( 'sticky-header' );
        }
      } else {
        if ( navBar.classList.contains( 'sticky-header' ) ) {
          navBar.classList.remove( 'sticky-header' );
        }
      }
    } );
    
    document.getElementById( 'back-to-top' ).addEventListener( 'click', function() {
      window.scrollTo({top: 0, behavior: 'smooth'});
    } );
    
    const subscribeForm = document.querySelector( '.wpcf7' );
    if ( subscribeForm ) {
      subscribeForm.addEventListener( 'wpcf7mailsent', function() {
        let container = subscribeForm.closest( '.wp-block-cover__inner-container' );
        if ( container ) {
          container.innerHTML = "<h3 class='has-white-color text-center'>WELCOME TO THE REVOLUTION</h3><p class='has-white-color text-center'>Your registration is complete. Look for Regulora<sup>®</sup> news and updates soon.</p>"
        }
      } )
    }
    
    const prof = document.getElementById( 'prof' );
    if ( prof ) {
      prof.addEventListener( 'click', function( e ) {
        e.preventDefault();
        let popupBlock = document.getElementById( 'choice-popup' );
        popupBlock.classList.add( 'hide' );
        document.body.classList.remove( 'popup-show' );
        
        setTimeout( function() {
          popupBlock.remove();
        }, 550 );
        
        let date = new Date();
        date.setMonth(date.getMonth() + 6);
        date = date.toUTCString();
        document.cookie = "usertype=professional; expires=" + date;
      } )
    }
  
    paragraphLineAnimation();
    strokeLinesAnimation();
    animationStart();
  },
};

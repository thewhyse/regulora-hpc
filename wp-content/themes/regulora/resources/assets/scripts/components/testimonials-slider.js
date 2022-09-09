import { tns } from 'tiny-slider/src/tiny-slider';

const sliders = [];
const blocks = document.querySelectorAll( '.wp-block-testimonials-slider' );

const sliderInit = ( block ) => {
    let prevBut = document.body.offsetWidth >= 992 ? '.prev-but-place.desktop' : '.prev-but-place.mobile';
    let nextBut = document.body.offsetWidth >= 992 ? '.next-but-place.desktop' : '.next-but-place.mobile';
    let options = {
        container: block.querySelector( '.testimonials-slider' ),
        items: 1,
        controls: true,
        prevButton: block.querySelector( prevBut ),
        nextButton: block.querySelector( nextBut ),
        // controlsContainer         : containerId + ' ' + sliderArrowsContainer,
        controlsPosition: 'bottom',
        nav: true,
        navPosition: 'bottom',
        autoplay: false,
        autoplayButton: false,
        autoplayButtonOutput: false,
        loop: true,
        lazyload: true,
        autoplayTimeout: 6000,
        mouseDrag: true,
        edgePadding: 0,
        gutter: 0,
        autoHeight: true,
    };
    
    let slider = tns( options );
    
    sliders.push( slider );
}

const addSliders = () => {
    blocks.forEach( block => {
        setTimeout( function() {
            sliderInit( block );
        }, 100 );
    } )
}

const init = () => {
    if ( blocks )
        addSliders();
}

export { init };
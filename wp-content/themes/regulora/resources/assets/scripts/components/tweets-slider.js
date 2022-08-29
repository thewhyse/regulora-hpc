import { tns } from 'tiny-slider/src/tiny-slider';

const sliders = [];
const blocks = document.querySelectorAll( '.wp-block-tweets-slider' );

const sliderInit = ( block ) => {
    let options = {
        container: '.tweets-slider',
        items: 1,
        controls: true,
        prevButton: block.querySelector( '.prev-but-place' ),
        nextButton: block.querySelector( '.next-but-place' ),
        // controlsContainer         : containerId + ' ' + sliderArrowsContainer,
        controlsPosition: 'bottom',
        nav: false,
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
        autoHeight: false,
    };
    
    let slider = tns( options );
    
    sliders.push( slider );
}

const addSliders = () => {
    blocks.forEach( block => {
        sliderInit( block );
    } )
}

const init = () => {
    if ( blocks )
        addSliders();
}

export { init };
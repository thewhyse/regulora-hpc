import { tns } from 'tiny-slider/src/tiny-slider';

const sliders = [];
const blocks = document.querySelectorAll( '.wp-block-tweets-slider' );

const sliderInit = ( block ) => {
    let prevBut = window.innerWidth >= 992 ? '.prev-but-place.desktop' : '.prev-but-place.mobile';
    let nextBut = window.innerWidth >= 992 ? '.next-but-place.desktop' : '.next-but-place.mobile';
    console.log(prevBut);
    let options = {
        container: block.querySelector( '.tweets-slider' ),
        items: 1,
        controls: true,
        prevButton: block.querySelector( prevBut ),
        nextButton: block.querySelector( nextBut ),
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
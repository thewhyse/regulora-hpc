import { tns } from 'tiny-slider/src/tiny-slider';

const sliders = [];
const blocks = document.querySelectorAll( '.wp-block-step-slider' );

const sliderInit = ( block ) => {
    let useSteps = block.querySelector( '.steps' );
    let options = {
        container: '.step-slider',
        items: 1,
        controls: true,
        prevButton: block.querySelector( '.prev-but-place' ),
        nextButton: block.querySelector( '.next-but-place' ),
        // controlsContainer         : containerId + ' ' + sliderArrowsContainer,
        controlsPosition: 'bottom',
        nav: true,
        navPosition: 'bottom',
        autoplay: false,
        autoplayButton: false,
        autoplayButtonOutput: false,
        loop: false,
        lazyload: true,
        autoplayTimeout: 6000,
        mouseDrag: true,
        edgePadding: 0,
        gutter: 0,
    };
    
    let slider = tns( options );
    
    if ( useSteps ) {
        let stepItems = useSteps.querySelectorAll( '.stepItem' );
        stepItems.forEach( ( item, index ) => {
            item.addEventListener( 'click', function() {
                slider.goTo( index );
            } );
        } );
        
        slider.events.on( 'indexChanged', function( info ) {
            useSteps.querySelector( '.active' ).classList.remove( 'active' );
            stepItems.forEach( ( item, index ) => {
                if ( index === info.index )
                    item.classList.add( 'active' );
            } );
        } )
    }
    
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
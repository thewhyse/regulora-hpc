const elements = [];
const offset = 250;
const timeout = 600;
const initDelay = 800;

const elementInViewport = (el, initial = false) => {
    let top = el.offsetTop;
    let height = el.offsetHeight;
    let offsetTop = ( initial ) ? 0 : offset;
    
    while(el.offsetParent) {
        el = el.offsetParent;
        top += el.offsetTop;
    }
    
    return (
        top < (window.pageYOffset + window.innerHeight - offsetTop) &&
        (top + height + offsetTop) > window.pageYOffset
    );
}

const action = () => {
    let findElements = document.querySelectorAll( '' +
        '.animate, ' +
        '.active-line, ' +
        '.is-style-stroke-style .line-left, ' +
        '.is-style-stroke-style .line-right, ' +
        '.like-stroke .line-left, ' +
        '.like-stroke .line-right, ' +
        '.fadeIn:not(.line-animation),' +
        '.anchor-target'
    );
    
    if ( findElements ) {
        findElements.forEach( element => {
            elements.push( element );
        } );
        observeElements( true );
        addListener();
    }
};

const addListener = () => {
    window.addEventListener( 'scroll', function() {
        observeElements( false );
    } );
};

const observeElements = ( initial = false ) => {
    elements.forEach( element => {
        if ( elementInViewport( element, initial ) ) {
            if ( 'animateNext' in element.dataset ) {
                let nextEl = document.getElementById( element.dataset.animateNext );
        
                if ( nextEl ) {
                    nextEl.classList.add( 'action' );
                    setTimeout( function() { element.classList.add( 'action' ); }, timeout );
                }
            } else {
                element.classList.add( 'action' );
            }
        }
    } );
    
};

const init = () => {
    setTimeout( action, initDelay );
};

export { init };
const lines = document.querySelectorAll( '.line-animation' );

const cumulativeOffset = (element) => {
    var top = 0, left = 0;
    do {
        top += element.offsetTop  || 0;
        left += element.offsetLeft || 0;
        element = element.offsetParent;
    } while(element);
    
    return {
        top: top,
        left: left,
    };
};

const processElements = () => {
    lines.forEach( element => {
        addLine( element );
    } );
};

const addLine = ( element ) => {
    let onTheLeft = element.classList.contains( 'left' );
    let spanLine = document.createElement( 'span' );
    let elId = Date.now() + Math.floor(Math.random() * 1000);
    
    element.id = elId;
    spanLine.dataset.animateNext = elId;
    
    // Add line element
    spanLine.classList.add( 'active-line' );
    if ( onTheLeft )
        spanLine.classList.add( 'on-the-left' );
    else
        spanLine.classList.add( 'on-the-right' );
    
    if ( element.classList.contains( 'blue-light' ) )
        spanLine.classList.add( 'blue-light' );
    if ( element.classList.contains( 'primary' ) )
        spanLine.classList.add( 'primary' );
    if ( element.classList.contains( 'secondary' ) )
        spanLine.classList.add( 'secondary' );
    
    // Get paragraph coords
    let coords = element.getBoundingClientRect();
    let offsets = cumulativeOffset( element );
    if ( onTheLeft ) {
        spanLine.style.left = 0;
        spanLine.style.right = ( offsets.left - 10 ) + 'px';
        spanLine.style.top = ( offsets.top + 20 ) + 'px';
    } else {
        spanLine.style.right = 0;
        spanLine.style.left = ( offsets.left + coords.width + 10 ) + 'px';
        spanLine.style.top = ( offsets.top + 20 ) + 'px';
    }
    document.body.appendChild( spanLine );
    
    // On window resize
    window.addEventListener( 'resize', function() {
        coords = element.getBoundingClientRect();
        offsets = cumulativeOffset( element );
        if ( onTheLeft ) {
            spanLine.style.left = 0;
            spanLine.style.right = ( offsets.left - 15 ) + 'px';
            spanLine.style.top = ( offsets.top + 20 ) + 'px';
        } else {
            spanLine.style.right = 0;
            spanLine.style.left = ( offsets.left + coords.width + 15 ) + 'px';
            spanLine.style.top = ( offsets.top + 20 ) + 'px';
        }
    } )
};

const init = () => {
    if ( lines )
        setTimeout( processElements, 500 );
};

export { init };
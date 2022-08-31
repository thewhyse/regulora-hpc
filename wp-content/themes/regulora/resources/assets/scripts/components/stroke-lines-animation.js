const lines = document.querySelectorAll( '.is-style-stroke-style, .like-stroke' );

const processElements = () => {
    lines.forEach( element => {
        addLines( element );
    } );
};

const addLines = ( element ) => {
    let coords = element.getBoundingClientRect();
    let targetLeft, targetRight;
    element.classList.forEach( className => {
       if ( className.indexOf( 'target-' ) > -1 ) {
           className = className.split( '-' );
           if ( className[ 1 ] === 'left' ) {
               className.splice( 0, 2 );
               let targetLeftId = className.join( '-' );
               targetLeft = document.getElementById( targetLeftId ).getBoundingClientRect();
           } else if ( className[ 1 ] === 'right' ) {
               className.splice( 0, 2 );
               let targetRightId = className.join( '-' );
               targetRight = document.getElementById( targetRightId ).getBoundingClientRect();
           }
       }
    } );
    
    let spanLineLeft = document.createElement( 'span' );
    spanLineLeft.classList.add( 'line-left' );
    let spanLineRight = document.createElement( 'span' );
    spanLineRight.classList.add( 'line-right' );
    
    if ( targetLeft && window.innerWidth > 781 ) {
        spanLineLeft.style.left = ( targetLeft.left * -1 + 32 ) + 'px';
        spanLineLeft.style.right = ( targetLeft.left + coords.width + 32 ) + 'px';
        spanLineLeft.dataset.right = ( coords.width - 10 );
    } else {
        spanLineLeft.style.left = ( coords.left * -1) + 'px';
        spanLineLeft.style.right = ( coords.left + coords.width ) + 'px';
        spanLineLeft.dataset.right = ( coords.width - 10 );
    }
    
    if ( targetRight && window.innerWidth > 781 ) {
        spanLineRight.style.left = ( coords.width - 10 ) + 'px';
        spanLineRight.style.right = '10px';
        spanLineRight.dataset.right = ( targetRight.left - coords.width - coords.left ) * -1 - 40;
    } else {
        spanLineRight.style.left = ( coords.width - 10 ) + 'px';
        spanLineRight.style.right = '10px';
        spanLineRight.dataset.right = ( window.innerWidth - coords.width - coords.left ) * -1 - 40;
    }
    
    element.appendChild( spanLineLeft );
    element.appendChild( spanLineRight );
    
    mutationObserver.observe(spanLineLeft, { attributes: true })
    mutationObserver.observe(spanLineRight, { attributes: true })
    
    // On window resize
    // window.addEventListener( 'resize', function() {
    //     coords = element.getBoundingClientRect();
    //     offsets = cumulativeOffset( element );
    //     if ( onTheLeft ) {
    //         spanLine.style.left = 0;
    //         spanLine.style.right = ( offsets.left - 15 ) + 'px';
    //         spanLine.style.top = ( offsets.top + 20 ) + 'px';
    //     } else {
    //         spanLine.style.right = 0;
    //         spanLine.style.left = ( offsets.left + coords.width + 15 ) + 'px';
    //         spanLine.style.top = ( offsets.top + 20 ) + 'px';
    //     }
    // } )
};

const mutationObserver = new MutationObserver( ( mutationsList ) => {
    mutationsList.forEach( mutation => {
        const { target } = mutation;
        if (mutation.attributeName === 'class' && target.classList.contains( 'action' )) {
            if ( target.classList.contains( 'line-left' ) ) {
                if ( typeof target.dataset.right !== undefined )
                    target.style.right = target.dataset.right + 'px';
            }
    
            if ( target.classList.contains( 'line-right' ) ) {
                setTimeout( function() {
                    if ( typeof target.dataset.right !== undefined )
                        target.style.right = target.dataset.right + 'px';
                }, 1000 );
            }
        }
    })
} )

const init = () => {
    if ( lines )
        setTimeout( processElements, 500 );
};

export { init };
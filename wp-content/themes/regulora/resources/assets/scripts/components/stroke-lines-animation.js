const lines = document.querySelectorAll( '.is-style-stroke-style, .like-stroke' );

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
        if ( ! element.closest( '.infographic' ) ) {
            addLines( element );
        }
    } );
    
    createInfographic();
};

// line-top
const createInfographic = () => {
    const infographics = document.querySelectorAll( '.infographic' );
    const lineHeight = 97;
    
    if ( infographics ) {
        infographics.forEach( infographic => {
            let vw = document.body.offsetWidth;
            let vh = document.body.offsetHeight;
            let bcc = cumulativeOffset( infographic );
            let bcr = infographic.getBoundingClientRect();
            let blockCoords = {
                top: bcc.top,
                left: bcc.left,
                right: bcc.left + bcr.width,
                bottom: bcc.top + bcr.height,
            };
            let infoItems = infographic.querySelectorAll( '.anchor-target' );
            
            if ( infoItems ) {
                let tempCoords = {
                    top: 0,
                    left: 0,
                    right: 0,
                };
                infoItems.forEach( ( infoItem, index ) => {
                    let coords = infoItem.getBoundingClientRect();
                    let coordsCum = cumulativeOffset( infoItem );
                    let topDiff = tempCoords.top - coordsCum.top;
                    let lineDirection;
    
                    infoItem.dataset.step = index;
                    
                    if ( index === 0 ) {
                        tempCoords.top = coordsCum.top;
                        tempCoords.left = coords.x;
                        tempCoords.right = coords.x + coords.width;
                        tempCoords.lineDirection = '';
                        return;
                    }
    
                    console.log(tempCoords.right + ' = ' + coords.x);
                    console.log('topDiff = ' + topDiff);
                    if ( tempCoords.right < coords.x ) {
                        if ( topDiff < 100 && topDiff > -100 ) {
                            lineDirection = 'right-left';
                        } else {
                            if ( tempCoords.lineDirection === 'right-right-v' )
                                lineDirection = 'left-left-v';
                            else
                                lineDirection = 'right-right-v';
                        }
                    } else {
                        if ( topDiff < 100 && topDiff > -100 ) {
                            lineDirection = 'left-right';
                        } else {
                            if ( tempCoords.lineDirection === 'right-right-v' )
                                lineDirection = 'left-left-v';
                            else
                                lineDirection = 'right-right-v';
                        }
                    }
                    tempCoords.lineDirection = lineDirection;
                        console.log(lineDirection);
                    let line, lineV, lineEnd;
                    
                    switch ( lineDirection ) {
                        case 'right-left' :
                            line = document.createElement( 'div' );
                            line.classList.add( 'connection-line' );
                            
                            line.classList.add( 'horizontal' );
                            line.classList.add( 'right-left' );
                            line.style.left = tempCoords.right + 'px';
                            line.style.right = ( vw - coords.x ) + 'px'; // -> tempCoords.left + 'px';
                            line.style.top = ( tempCoords.top + lineHeight - 40 ) + 'px';
                            
                            line.dataset.right = ( vw - coords.x ) + 'px';
                            infographic.appendChild( line );
                            break;
                        case 'right-right-v' :
                            line = document.createElement( 'div' );
                            lineV = document.createElement( 'div' );
                            lineEnd = document.createElement( 'div' );
                            line.classList.add( 'connection-line' );
                            lineV.classList.add( 'connection-line' );
                            lineEnd.classList.add( 'connection-line' );
    
                            line.classList.add( 'horizontal' );
                            line.classList.add( 'right-left' );
                            lineV.classList.add( 'vertical' );
                            lineV.classList.add( 'top-bottom' );
                            lineEnd.classList.add( 'horizontal' );
                            lineEnd.classList.add( 'left-right' );
                            
                            line.style.left = tempCoords.right + 'px';
                            line.style.right = ( vw - blockCoords.right ) + 'px';// -> tempCoords.left + 'px';
                            line.style.top = ( tempCoords.top + lineHeight - 40 ) + 'px';
    
                            // lineV.style.left = ( blockCoords.right - 3 ) + 'px';
                            lineV.style.right = ( vw - blockCoords.right ) + 'px';
                            lineV.style.top = ( tempCoords.top + lineHeight - 40 ) + 'px';
                            lineV.style.bottom = ( vh - coordsCum.top - lineHeight + 40 ) + 'px';
    
                            lineEnd.style.right = ( vw - blockCoords.right ) + 'px';
                            lineEnd.style.top = ( coordsCum.top + lineHeight - 40 ) + 'px';
                            lineEnd.style.left = ( coords.x + coords.width ) + 'px';// -> blockCoords.right + 'px';
    
                            line.dataset.right = ( vw - blockCoords.right ) + 'px';
                            lineV.dataset.bottom = ( vh - coordsCum.top - lineHeight + 40 ) + 'px';
                            lineEnd.dataset.left = ( coords.x + coords.width ) + 'px';
                            infographic.appendChild( line );
                            infographic.appendChild( lineV );
                            infographic.appendChild( lineEnd );
                            break;
                        case 'left-right' :
        
                            break;
                        case 'left-left-v' :
        
                            break;
                    }
    
                    tempCoords.top = coordsCum.top;
                    tempCoords.left = coords.x;
                    tempCoords.right = coords.x + coords.width;
                } )
            }
        } )
    }
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
const lines = document.querySelectorAll( '.is-style-stroke-style, .like-stroke' );
const lineHeight = 83;
const infographicsStore = [];

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
    
    setTimeout( function() {
        createInfographic();
    }, 500 );
};

// line-top
const createInfographic = () => {
    const infographics = document.querySelectorAll( '.infographic' );
    
    if ( infographics ) {
        infographics.forEach( ( infographic, index ) => {
            infographicsStore[ index ] = processInfographic( infographic );
            
            window.addEventListener( 'scroll', function() {
                infographicLinesRedraw( infographicsStore[ index ].blockCoords, infographicsStore[ index ].objects );
            } );
        } )
    }
};

const processInfographic = ( infographic ) => {
    const objects = [];
    // let vw = document.body.offsetWidth;
    // let vh = document.body.offsetHeight;
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
            mutationObserver.observe( infoItem, { attributes: true } )
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
                objects.push( {
                    infoItem : infoItem,
                    coords : coords,
                    coordsCum : coordsCum,
                    topDiff : topDiff,
                    lineDirection : null,
                    line : null,
                    lineV : null,
                    lineEnd : null,
                } );
                return;
            }
            
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
            
            let line, lineV, lineEnd;
    
            let object = {
                infoItem : infoItem,
                coords : coords,
                coordsCum : coordsCum,
                topDiff : topDiff,
                lineDirection : lineDirection,
                line : null,
                lineV : null,
                lineEnd : null,
            };
            
            switch ( lineDirection ) {
                case 'right-left' :
                    line = document.createElement( 'div' );
                    line.classList.add( 'connection-line' );
                    
                    line.classList.add( 'horizontal' );
                    line.classList.add( 'right-left' );
                    line.classList.add( 'before-step-' + index );
                    // line.style.left = tempCoords.right + 'px';
                    // line.style.right = ( vw - coords.x ) + 'px'; // -> tempCoords.left + 'px';
                    // line.style.top = ( tempCoords.top + lineHeight - 40 ) + 'px';
                    //
                    // line.dataset.right = ( vw - coords.x ) + 'px';
                    infographic.appendChild( line );
                    object.line = line;
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
    
                    line.classList.add( 'before-step-' + index );
                    lineV.classList.add( 'before-step-' + index );
                    lineEnd.classList.add( 'before-step-' + index );
                    
                    // line.style.left = tempCoords.right + 'px';
                    // line.style.right = ( vw - blockCoords.right ) + 'px';// -> tempCoords.left + 'px';
                    // line.style.top = ( tempCoords.top + lineHeight - 40 ) + 'px';
                    //
                    // // lineV.style.left = ( blockCoords.right - 3 ) + 'px';
                    // lineV.style.right = ( vw - blockCoords.right ) + 'px';
                    // lineV.style.top = ( tempCoords.top + lineHeight - 40 ) + 'px';
                    // lineV.style.bottom = ( vh - coordsCum.top - lineHeight + 40 ) + 'px';
                    //
                    // lineEnd.style.right = ( vw - blockCoords.right ) + 'px';
                    // lineEnd.style.top = ( coordsCum.top + lineHeight - 40 ) + 'px';
                    // lineEnd.style.left = ( coords.x + coords.width ) + 'px';// -> blockCoords.right + 'px';
                    //
                    // line.dataset.right = ( vw - blockCoords.right ) + 'px';
                    // lineV.dataset.bottom = ( vh - coordsCum.top - lineHeight + 40 ) + 'px';
                    // lineEnd.dataset.left = ( coords.x + coords.width ) + 'px';
                    infographic.appendChild( line );
                    infographic.appendChild( lineV );
                    infographic.appendChild( lineEnd );
                    object.line = line;
                    object.lineV = lineV;
                    object.lineEnd = lineEnd;
                    break;
                case 'left-right' :
                    
                    break;
                case 'left-left-v' :
                    if ( infoItem.classList.contains( 'line-top' ) ) {
                        line = document.createElement( 'div' );
                        lineV = document.createElement( 'div' );
    
                        line.classList.add( 'connection-line' );
                        lineV.classList.add( 'connection-line' );
    
                        line.classList.add( 'horizontal' );
                        line.classList.add( 'left-right' );
                        lineV.classList.add( 'vertical' );
                        lineV.classList.add( 'top-bottom' );
    
                        line.classList.add( 'before-step-' + index );
                        lineV.classList.add( 'before-step-' + index );
    
                        infographic.appendChild( line );
                        infographic.appendChild( lineV );
                        object.line = line;
                        object.lineV = lineV;
                    }
                    break;
            }
    
            objects.push( object );
            
            tempCoords.top = coordsCum.top;
            tempCoords.left = coords.x;
            tempCoords.right = coords.x + coords.width;
        } )
    
        infographicLinesRedraw( blockCoords, objects );
    }
    
    return { blockCoords : blockCoords, objects : objects };
};

const infographicLinesRedraw = ( blockCoords, objects ) => {
    const timing = 300; // px per second
    let vw = document.body.offsetWidth;
    let vh = document.body.offsetHeight;
    let tempCoords = {
        top: 0,
        left: 0,
        right: 0,
    };
    
    objects.forEach( ( object, index ) => {
        object.coords = object.infoItem.getBoundingClientRect();
        object.coordsCum = cumulativeOffset( object.infoItem );
        if ( index === 0 ) {
            tempCoords.top = object.coordsCum.top;
            tempCoords.left = object.coords.x;
            tempCoords.right = object.coords.x + object.coords.width;
            tempCoords.lineDirection = '';
            return;
        }
        
        let lineLength, lineVLength, lineEndLength;
    
        
        switch ( object.lineDirection ) {
            case 'right-left' :
                object.line.style.left = tempCoords.right + 'px';
                object.line.style.right = ( object.line.classList.contains( 'do-magic' ) ? ( vw - object.coords.x ) : ( vw - tempCoords.right ) ) + 'px'; // -> tempCoords.left + 'px';
                object.line.style.top = ( tempCoords.top + lineHeight - 40 ) + 'px';
        
                object.line.dataset.right = ( vw - object.coords.x ) + 'px';
        
                lineLength = Math.abs( vw - tempCoords.right - ( vw - object.coords.x ) );
                object.line.style.transitionDuration = ( lineLength / timing ) + 's';
                object.line.style.transitionDelay = '.5s';
                break;
            case 'right-right-v' :
                object.line.style.left = tempCoords.right + 'px';
                object.line.style.right = ( object.line.classList.contains( 'do-magic' ) ? ( vw - blockCoords.right ) : ( vw - tempCoords.right ) ) + 'px';// -> tempCoords.left + 'px';
                object.line.style.top = ( tempCoords.top + lineHeight - 40 ) + 'px';
        
                // lineV.style.left = ( blockCoords.right - 3 ) + 'px';
                object.lineV.style.right = ( vw - blockCoords.right ) + 'px';
                object.lineV.style.top = ( tempCoords.top + lineHeight - 40 ) + 'px';
                object.lineV.style.bottom = ( object.line.classList.contains( 'do-magic' ) ? ( vh - object.coordsCum.top - lineHeight + 40 ) : ( vh - tempCoords.top + lineHeight - 40 ) ) + 'px';
        
                object.lineEnd.style.right = ( vw - blockCoords.right ) + 'px';
                object.lineEnd.style.top = ( object.coordsCum.top + lineHeight - 40 ) + 'px';
                object.lineEnd.style.left = ( object.line.classList.contains( 'do-magic' ) ? ( object.coords.x + object.coords.width ) : blockCoords.right ) + 'px';// -> blockCoords.right + 'px';
        
                object.line.dataset.right = ( vw - blockCoords.right ) + 'px';
                object.lineV.dataset.bottom = ( vh - object.coordsCum.top - lineHeight + 40 ) + 'px';
                object.lineEnd.dataset.left = ( object.coords.x + object.coords.width ) + 'px';
        
                lineLength = Math.abs( vw - tempCoords.right - ( vw - blockCoords.right ) );
                object.line.style.transitionDuration = ( lineLength / timing ) + 's';
                // object.line.style.transitionDelay = '.5s';
                lineVLength = Math.abs( vh - ( tempCoords.top + lineHeight - 40 ) - ( vh - object.coordsCum.top - lineHeight + 40 ) );
                object.lineV.style.transitionDuration = ( lineVLength / timing ) + 's';
                object.lineV.style.transitionDelay = ( lineLength / timing ) + 's';
                lineEndLength = Math.abs( vw - ( object.coords.x + object.coords.width ) - ( vw - blockCoords.right ) );
                object.lineEnd.style.transitionDuration = ( lineEndLength / timing ) + 's';
                object.lineEnd.style.transitionDelay = ( lineLength / timing ) + ( lineVLength / timing ) + 's';
                break;
            case 'left-right' :
        
                break;
            case 'left-left-v' :
                if ( object.infoItem.classList.contains( 'line-top' ) ) {
                    object.line.style.left = ( object.line.classList.contains( 'do-magic' ) ? ( object.coords.x + object.coords.width * 0.30 ) : ( tempCoords.left ) ) + 'px';
                    object.line.style.right = ( vw - tempCoords.left ) + 'px';// -> tempCoords.left + 'px';
                    object.line.style.top = ( tempCoords.top + lineHeight - 40 ) + 'px';
            
                    // lineV.style.left = ( blockCoords.right - 3 ) + 'px';
                    object.lineV.style.right = ( vw - object.coords.x - ( object.coords.width * 0.30 ) ) + 'px';
                    object.lineV.style.top = ( tempCoords.top + lineHeight - 40 ) + 'px';
                    object.lineV.style.bottom = ( object.line.classList.contains( 'do-magic' ) ? ( vh - object.coordsCum.top - 16 ) : ( vh - tempCoords.top + lineHeight - 40 ) ) + 'px';
            
                    object.line.dataset.left = ( object.coords.x + object.coords.width * 0.30 ) + 'px';
                    object.lineV.dataset.bottom = ( vh - object.coordsCum.top - 19 ) + 'px';
            
                    lineLength = Math.abs(   vw - ( object.coords.x + object.coords.width * 0.30 ) - ( vw - tempCoords.left ) );
                    object.line.style.transitionDuration = ( lineLength / timing ) + 's';
                    lineVLength = Math.abs( vh - ( tempCoords.top + lineHeight - 40 ) - ( vh - object.coordsCum.top - 19 ) );
                    object.lineV.style.transitionDuration = ( lineVLength / timing ) + 's';
                    object.lineV.style.transitionDelay = ( lineLength / timing ) + 's';
                }
                break;
        }
    
        tempCoords.top = object.coordsCum.top;
        tempCoords.left = object.coords.x;
        tempCoords.right = object.coords.x + object.coords.width;
    } );
};

// const showObserver = new MutationObserver( ( mutationsList ) => {
//     mutationsList.forEach( mutation => {
//         const { target } = mutation;
//         if (mutation.attributeName === 'class' && target.classList.contains( 'action' )) {
//             // let stepNumber = target.dataset.step;
//             // let infographic = target.closest( '.infographic' );
//             // if ( stepNumber === '0' ) {
//             //     target.classList.add( 'do-magic' );
//             //     let lines = infographic.querySelectorAll( '.after-step-' + stepNumber );
//             //     if ( lines ) {
//             //         lines.forEach( line => {
//             //             if ( 'left' in line.dataset )
//             //                 line.style.left = line.dataset.left + 'px';
//             //             if ( 'right' in line.dataset )
//             //                 line.style.right = line.dataset.right + 'px';
//             //             if ( 'bottom' in line.dataset )
//             //                 line.style.bottom = line.dataset.bottom + 'px';
//             //             line.classList.add( 'do-magic' );
//             //         } );
//             //     }
//             // }
//
//             target.classList.add( 'do-magic' );
//         }
//     })
// } )

const addLines = ( element ) => {
    let coords = element.getBoundingClientRect();
    let coordsCum = cumulativeOffset( element );
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
    
    if ( document.body.offsetWidth <= 781 && element.classList.contains( 'like-stroke' ) ) {
        element.style.display = 'inline-block';
        
        let plus = ( element.classList.contains( 'plus' ) ) ? 100 : 10;
    
        spanLineLeft.style.left = ( coordsCum.left * -1 ) + 'px';
        spanLineLeft.style.right = ( coordsCum.left + coords.width ) + 'px';
        spanLineLeft.dataset.right = ( coords.width - plus );
    
        spanLineRight.style.left = coords.width + 'px';
        spanLineRight.style.right = '0px';
        spanLineRight.dataset.right = ( document.body.offsetWidth - coords.width - coords.left + 10 ) * -1;
    } else {
        if ( targetLeft && window.innerWidth > 781 ) {
            spanLineLeft.style.left = ( targetLeft.left * -1 + 32 ) + 'px';
            spanLineLeft.style.right = ( targetLeft.left + coords.width + 32 ) + 'px';
            spanLineLeft.dataset.right = ( coords.width - 10 );
        } else {
            spanLineLeft.style.left = ( coordsCum.left * -1 ) + 'px';
            spanLineLeft.style.right = ( coordsCum.left + coords.width ) + 'px';
            spanLineLeft.dataset.right = ( coords.width - 10 );
        }
    
        if ( targetRight && window.innerWidth > 781 ) {
            spanLineRight.style.left = ( coords.width - 10 ) + 'px';
            spanLineRight.style.right = '10px';
            spanLineRight.dataset.right = ( targetRight.left - coords.width - coords.left ) * -1 - 40;
        } else {
            spanLineRight.style.left = ( coords.width - 10 ) + 'px';
            spanLineRight.style.right = '10px';
            spanLineRight.dataset.right = ( window.innerWidth - coords.width - coordsCum.left + 10 ) * -1;
        }
    }
    
    element.appendChild( spanLineLeft );
    element.appendChild( spanLineRight );
    
    mutationObserver.observe(spanLineLeft, { attributes: true });
    mutationObserver.observe(spanLineRight, { attributes: true });
    
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
            if ( target.classList.contains( 'line-left' ) && ! target.classList.contains( 'animation-finished' ) ) {
                if ( typeof target.dataset.right !== undefined )
                    target.style.right = target.dataset.right + 'px';
                target.classList.add( 'animation-finished' );
            }
    
            if ( target.classList.contains( 'line-right' ) && ! target.classList.contains( 'animation-finished' ) ) {
                setTimeout( function() {
                    if ( typeof target.dataset.right !== undefined )
                        target.style.right = target.dataset.right + 'px';
                    target.classList.add( 'animation-finished' );
                }, 1000 );
            }
    
            if ( target.classList.contains( 'anchor-target' ) && ! target.classList.contains( 'do-magic' ) ) {
                setTimeout( function() {
                    // target.classList.add( 'do-magic' );
                    let stepNumber = target.dataset.step;
                    let infographic = target.closest( '.infographic' );
                    // if ( stepNumber === '0' ) {
                    let lines = infographic.querySelectorAll( '.before-step-' + stepNumber );
                    let timer = 0;
                    if ( lines ) {
                        lines.forEach( line => {
                            timer += parseFloat( line.style.transitionDuration );
                            if ( ! line.classList.contains( 'do-magic' ) ) {
                                line.classList.add( 'do-magic' );
                                setTimeout( function() {
                                    if ( 'left' in line.dataset ) {
                                        line.style.left = line.dataset.left;
                                    }
                                    if ( 'right' in line.dataset ) {
                                        line.style.right = line.dataset.right;
                                    }
                                    if ( 'bottom' in line.dataset ) {
                                        line.style.bottom = line.dataset.bottom;
                                    }
                                }, 400 );
                            }
                        } );
                    }
                    if ( stepNumber === '1' ) {
                        timer += 0.5;
                    }
                    target.style.transitionDelay = timer + 's';
                    target.nextElementSibling.style.transitionDelay = timer + 's';
                    target.classList.add( 'do-magic' );
                    // }
                }, 10 );
            }
        }
    })
} )

const init = () => {
    if ( lines )
        setTimeout( processElements, 700 );
};

export { init };
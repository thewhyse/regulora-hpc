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
        if ( element.offsetWidth )
            addLine( element );
    } );
};

const getElementWidth = ( element ) => {
    if ([
            'iPad Simulator',
            'iPhone Simulator',
            'iPod Simulator',
            'iPad',
            'iPhone',
            'iPod',
        ].includes(navigator.platform)
        // iPad on iOS 13 detection
        || (navigator.userAgent.includes('Mac') && 'ontouchend' in document)) {
        return element.offsetWidth;
    } else {
        return element.getBoundingClientRect().width;
    }
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
    if ( element.classList.contains( 'primary-light' ) )
        spanLine.classList.add( 'primary-light' );
    if ( element.classList.contains( 'secondary' ) )
        spanLine.classList.add( 'secondary' );
    if ( element.classList.contains( 'transparent' ) )
        spanLine.classList.add( 'transparent' );
    
    // Get paragraph coords
    let coords = element.getBoundingClientRect();
    let offsets = cumulativeOffset( element );
    let lineHeight = parseInt( window.getComputedStyle( element,null ).getPropertyValue('line-height') );
    
    if ( isNaN( lineHeight ) ) {
        lineHeight = 20;
        if ( window.innerWidth < 992 ) {
            lineHeight = 35;
        }
    } else {
        lineHeight = lineHeight / 2;
    }
    if ( onTheLeft ) {
        let spaceMob = ( document.body.offsetWidth < 992 ) ? 7 : 7;
        spanLine.style.left = 0;
        spanLine.style.right = ( window.innerWidth - coords.left + spaceMob ) + 'px';
        spanLine.style.top = ( offsets.top + lineHeight - 7 ) + 'px';
    } else {
        spanLine.style.right = 0;
        spanLine.style.left = ( coords.left + getElementWidth( element ) + 15 ) + 'px';
        spanLine.style.top = ( offsets.top + lineHeight - 7 ) + 'px';
    }
    document.body.appendChild( spanLine );
    
    // On window resize
    window.addEventListener( 'resize', function() {
        lineHeight = parseInt( window.getComputedStyle( element,null ).getPropertyValue('line-height') );
    
        if ( isNaN( lineHeight ) ) {
            lineHeight = 20;
            if ( window.innerWidth < 992 ) {
                lineHeight = 35;
            }
        } else {
            lineHeight = lineHeight / 2;
        }
        
        
        
        coords = element.getBoundingClientRect();
        offsets = cumulativeOffset( element );
        if ( onTheLeft ) {
            spanLine.style.left = 0;
            spanLine.style.right = ( window.innerWidth - coords.left ) + 'px';
            spanLine.style.top = ( offsets.top + lineHeight - 7 ) + 'px';
        } else {
            spanLine.style.right = 0;
            spanLine.style.left = ( coords.left + getElementWidth( element ) + 15 ) + 'px';
            spanLine.style.top = ( offsets.top + lineHeight - 7 ) + 'px';
        }
    } )
    
    window.addEventListener( 'scroll', function() {
        lineHeight = parseInt( window.getComputedStyle( element,null ).getPropertyValue('line-height') );
        
        if ( isNaN( lineHeight ) ) {
            lineHeight = 20;
            if ( window.innerWidth < 992 ) {
                lineHeight = 35;
            }
        } else {
            lineHeight = lineHeight / 2;
        }
        
        
        
        coords = element.getBoundingClientRect();
        offsets = cumulativeOffset( element );
        if ( onTheLeft ) {
            spanLine.style.left = 0;
            spanLine.style.right = ( window.innerWidth - coords.left ) + 'px';
            spanLine.style.top = ( offsets.top + lineHeight - 7 ) + 'px';
        } else {
            spanLine.style.right = 0;
            spanLine.style.left = ( coords.left + getElementWidth( element ) + 15 ) + 'px';
            spanLine.style.top = ( offsets.top + lineHeight - 7 ) + 'px';
        }
    } )
};

const init = () => {
    if ( lines )
        setTimeout( processElements, 700 );
};

export { init };
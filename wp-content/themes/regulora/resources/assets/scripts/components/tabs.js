const tabs = document.querySelectorAll( '.wp-block-buttons.is-style-tabs' );

const activateTabs = () => {
    tabs.forEach( instance => {
        let instanceTabs = instance.querySelectorAll( '.wp-block-button__link' );
        if ( instanceTabs ) {
            instanceTabs.forEach( ( tab, index ) => {
                let targetTabId = new URL( tab.href ).hash;
                let targetTab = document.querySelector( targetTabId );
                
                if ( index === 0 ) {
                    tab.classList.add( 'active' );
                    targetTab.classList.add( 'active' );
                }
                
                tab.addEventListener( 'click', function( e ) {
                    e.preventDefault();
                    let currentActive = instance.querySelector( '.wp-block-button__link.active' );
                    if (currentActive) {
                        currentActive.classList.remove( 'active' );
                        document.querySelector( new URL( currentActive.href ).hash ).classList.remove( 'active' );
                    }
                    tab.classList.add( 'active' );
                    targetTab.classList.add( 'active' );
                } )
                
            } )
        }
    } )
};

const init = () => {
    if ( tabs )
        activateTabs();
};

export { init }
const queryBlocks = document.querySelectorAll( '.query-content' );
const ajaxUrl = '/wp-admin/admin-ajax.php';

const makeRequest = ( blockID, page, currentPageID ) => {
    let targetBlock = document.getElementById( 'query-content-' + blockID );
    let request = new XMLHttpRequest();
    targetBlock.classList.toggle( 'loading' );
    request.onload = () => {
        if (request.readyState == XMLHttpRequest.DONE) {   // XMLHttpRequest.DONE == 4
            if ( request.status == 200 ) {
                if ( targetBlock ) {
                    targetBlock.querySelector( '.block-inner' ).innerHTML = request.responseText;
                    targetBlock.classList.toggle( 'loading' );
                    targetBlock.scrollIntoView({ block: 'center', behavior: 'smooth' } );
                    setListeners( targetBlock, blockID );
                }
            }
        }
    };
    request.open('POST', ajaxUrl, true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
    request.send( 'action=ajaxGetContentBlock&currentPageID=' + currentPageID + '&block_id=' + blockID + '&page=' + page );
}

// const renderResult = ( blockID, request ) => {
//     console.log(request.readyState);
//     console.log(request.status);
//     if (request.readyState == XMLHttpRequest.DONE) {   // XMLHttpRequest.DONE == 4
//         if ( request.status == 200 ) {
//             let targetBlock = document.getElementById( 'query-content-' + blockID );
//             console.log(targetBlock);
//             if ( targetBlock ) {
//                 targetBlock.querySelector( '.block-inner' ).innerHTML = request.responseText;
//             }
//         }
//     }
// }

const setListeners = ( element, blockID ) => {
    let pagination = element.querySelector( '.pagination' );
    let currentPageID = element.dataset.cp;
    if ( pagination ) {
        pagination.addEventListener( 'click', function ( e ) {
            e.preventDefault();
            let target = e.target;
            if ( target.tagName == 'svg' || target.tagName == 'path' ) {
                target = target.closest( 'a' );
            }
            if ( target.tagName == 'A' && target.classList.contains( 'page-numbers' ) ) {
                let link = target.href;
                let pageNum = 1;
                link = link.match( /(page\/(\d+)*)/i );
                if ( link && typeof link[ 2 ] !== undefined ) {
                    pageNum = link[ 2 ];
                }
            
                makeRequest( blockID, pageNum, currentPageID );
            }
        } )
    }
}

const init = () => {
    if ( queryBlocks.length > 0 ) {
        queryBlocks.forEach( (block) => {
            let block_id = block.id;
            block_id = block_id.replace( 'query-content-', '' );
            setListeners( block, block_id );
        } )
    }
}

export {init};
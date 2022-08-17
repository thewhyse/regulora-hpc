const faqItems = document.querySelectorAll( '.is-style-faq-item' );

const toggle = ( $item ) => {
  $item.classList.toggle( 'active' );
};

const actionListener = () => {
  faqItems.forEach( ( item ) => {
    item.querySelector( 'h5' ).addEventListener( 'click', function() {
      toggle( item );
    } )
  } )
};

const init = () => {
  actionListener();
};

export { init };

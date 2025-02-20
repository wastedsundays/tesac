document.addEventListener( 'DOMContentLoaded', function() {
    const cards = document.querySelectorAll( '.schedule-post' );
    
    cards.forEach( card => {
      card.addEventListener( 'click', function() {
        const matchups = card.querySelector( '.draw-matchups' );
        const isExpanded = card.getAttribute( 'aria-expanded' ) === 'true';
        
        // Toggle the open class for sliding animation
        card.classList.toggle( 'open' );
        card.setAttribute( 'aria-expanded', !isExpanded );
      } );
    } );
  } );

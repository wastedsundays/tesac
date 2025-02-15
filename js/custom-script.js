document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.schedule-post');
    
    cards.forEach(card => {
      card.addEventListener('click', function () {
        const matchups = card.querySelector('.draw-matchups');
        
        // Toggle the open class for sliding animation
        card.classList.toggle('open');
        
        // // Alternatively, you could animate the height with JavaScript:
        // if (card.classList.contains('open')) {
        //   matchups.style.height = matchups.scrollHeight + 'px';  // Expand the matchups
        // } else {
        //   matchups.style.height = '0'; // Collapse the matchups
        // }
      });
    });
  });
  
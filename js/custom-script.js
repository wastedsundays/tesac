document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.schedule-post');
    
    cards.forEach(card => {
      card.addEventListener('click', function () {
        const matchups = card.querySelector('.draw-matchups');
        
        // Toggle the open class for sliding animation
        card.classList.toggle('open');
        

      });
    });
  });




  
document.addEventListener("DOMContentLoaded", () => {

    //handle the click event on the heart icon
    let stared = false;
    
    function toggleRate() {
      stared = !stared;
      const heartIcon = document.getElementById('heart-icon');
      const heartIconTop = document.getElementById('heart-icon-top');
      
      if (stared) {
        heartIcon.classList.remove('far');
        heartIcon.classList.add('fas', 'text-red-500');
        
        heartIconTop.classList.remove('far');
        heartIconTop.classList.add('fas', 'text-red-500');
      } else {
        heartIcon.classList.remove('fas', 'text-red-500');
        heartIcon.classList.add('far');
        
        heartIconTop.classList.remove('fas', 'text-red-500');
        heartIconTop.classList.add('far');
      }
    }
    
    function goToItem() {
      // Implement the logic to navigate to the item detail page
      alert('Navigating to item detail page...');
    }
});
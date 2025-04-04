document.addEventListener("DOMContentLoaded", function() {
    const addButtons = document.querySelectorAll('.add-btn');
    const viewButtons = document.querySelectorAll('.view-btn');
  
    addButtons.forEach((button, index) => {
      button.addEventListener('click', () => {
        const contentDiv = button.parentElement.querySelector('.content');
        contentDiv.textContent = `Content added to Box ${index + 1}`;
        contentDiv.style.display = 'block';
      });
    });
  
    viewButtons.forEach(button => {
      button.addEventListener('click', () => {
        const contentDiv = button.parentElement.querySelector('.content');
        alert(contentDiv.textContent);
      });
    });
  });
  
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
  function updateCalendar() {
    const date = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const formattedDate = date.toLocaleDateString('en-US', options);

    document.getElementById('current-date').textContent = formattedDate.split(', ').slice(1).join(', ');
    document.getElementById('current-day').textContent = formattedDate.split(', ')[0];
}

async function updateCounts() {
try {
const response = await fetch('get_data.php');
const data = await response.json();
document.getElementById('collectors-count').textContent = data.collector_count;
document.getElementById('zones-count').textContent = data.zone_count;
document.getElementById('admins-count').textContent = data.admin_count;
document.getElementById('monthly-income').textContent = data.monthly_income + ' EGP'; // تحديث الإيرادات الشهرية
document.getElementById('uncollected-bins-count').textContent = data.uncollected_bins_count;
document.getElementById('collected-bins-count').textContent = data.collected_bins_count;

} catch (error) {
document.getElementById('collectors-count').textContent = 'Error';
document.getElementById('zones-count').textContent = 'Error';
document.getElementById('admins-count').textContent = 'Error';
document.getElementById('monthly-income').textContent = 'Error';
document.getElementById('uncollected-bins-count').textContent = 'Error';
document.getElementById('collected-bins-count').textContent = 'Error';

console.error('Error fetching counts:', error);
}
}





  
  

 
  
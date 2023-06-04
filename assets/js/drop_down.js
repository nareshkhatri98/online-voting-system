// Add event listener to parent element
const sidebarItem = document.querySelector('.sidebar-list-item');
sidebarItem.addEventListener('mouseenter', () => {
  const submenu = document.querySelector('.submenu');
  submenu.style.display = 'block';
});

// Add event listener to child elements to hide submenu
const submenuLinks = document.querySelectorAll('.submenu li a');
submenuLinks.forEach(link => {
  link.addEventListener('click', () => {
    const submenu = document.querySelector('.submenu');
    submenu.style.display = 'none';
  });
});


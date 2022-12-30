let isHamMenuOpen = false;
const hamMenu = document.querySelector('.hamburger-menu');

hamMenu.addEventListener('mouseover', (e) => {
  if (!isHamMenuOpen) {
    isHamMenuOpen = true;
    e.target.children[1].style.display = 'block';
  }
});

hamMenu.addEventListener('mouseleave', (e) => {
  if (isHamMenuOpen) {
    isHamMenuOpen = false;
    e.target.children[1].style.display = 'none';
  }
});

const alert = (msg) => {
  console.log(msg);
  
}

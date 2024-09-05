/*----------------------------------
#Menu
----------------------------------*/
document.addEventListener('DOMContentLoaded', () => {
    const list = document.querySelector('.first-bloc nav');
    const exit = document.querySelector('.exit-dash');
    const menuIcon = document.querySelector('.hamburger');
    const overlay = document.querySelector('.overlay-dash');

    if (menuIcon) {
        menuIcon.addEventListener('click', () => {
            list.classList.add('active');
            overlay.classList.add('active');
            menuIcon.style.display = 'none';
            exit.style.display = 'flex';
        });
    }

    if (exit) {
        exit.addEventListener('click', () => {
            list.classList.remove('active');
            overlay.classList.remove('active');
            exit.style.display = 'none';
            menuIcon.style.display = 'flex';
        });
    }
});
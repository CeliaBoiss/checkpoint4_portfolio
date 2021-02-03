//BURGER MENU
function openNav() {
    if (window.matchMedia("(max-width: 813px)").matches) {
        document.querySelector('.sideNav').style.width = "40%";
        document.querySelector('.nav').style.display = "flex";
    }
}

function closeNav() {
    document.querySelector('.sideNav').style.width = "0";
    document.querySelector('.nav').style.display = "none";
}

const burgerButton = document.querySelector('.openButton');
const closeButton = document.querySelector('.closeButton');

burgerButton.addEventListener('click',openNav);
closeButton.addEventListener('click',closeNav);

//RETURN TO TOP BUTTON
const mybutton = document.getElementById('returnTop');

function scrollFunction() {
    if (document.documentElement.scrollTop > 30) {
      mybutton.style.display = "block";
    } else {
      mybutton.style.display = "none";
    }
  }
  
  //when click on "go top" button, return to the top of the page
  function topFunction() {
      window.scrollTo({top: 0, behavior: 'smooth'});
  } 
  
  window.addEventListener('scroll', scrollFunction);
  mybutton.addEventListener('click', topFunction);
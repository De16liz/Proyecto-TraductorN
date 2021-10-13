var btn1= document.querySelector('.btn-menu');
var menu = document.querySelector('.menu-principal');

var btn2 = document.querySelector('.item-cerrar');
btn2.addEventListener('click', function(){
    menu.classList.remove('menu-show');
})
btn1.addEventListener('click', function(){
    menu.classList.add('menu-show');
});

document.querySelector('.log').addEventListener('click', function(){
    menu.classList.remove('menu-show');
});


var btn_menu = document.querySelector('.user-logo-img');
var menu = document.querySelector('.user-menu');

btn_menu.addEventListener('click', show_menu);
document.querySelector('body').addEventListener('click', global_click_close_menu);

function show_menu(){

    if(!menu.classList.contains('d-none')){
        hide_menu_items();
        setTimeout(function(){
            menu.classList.add('d-none');
        } , 0);
        //
    }else{
        menu.classList.remove('d-none');
        setTimeout(show_menu_item , 0);
    }
}

function show_menu_item(){
    if(!menu.classList.contains('d-none')){
        document.querySelectorAll('.menu-item').forEach(function(item, index){
            item.classList.add('menu-item-show-' + (index + 1));
            item.classList.remove('menu-item-hide-' + (index + 1));
        });
    }
}

function hide_menu_items(){
    document.querySelectorAll('.menu-item').forEach(function(item, index){
        item.classList.add('menu-item-hide-' + (index + 1));
        item.classList.remove('menu-item-show-' + (index + 1));
    });
}

function global_click_close_menu(event){
    if(!menu.classList.contains('d-none') && !(!!event.target.classList.contains('user-logo-img'))){
        hide_menu_items();
        setTimeout(function(){
            menu.classList.add('d-none');
        } , 500);
    }
}
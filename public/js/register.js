$('#men').click(function(){
    change_image("men");
});
$('#girl').click(function(){
    change_image("girl");
});

function change_image(text){
    document.querySelector('#default_image').setAttribute('value', text);
    set_line(text);

}

function set_line(type){
    if(type === "men"){
        document.querySelector('.register__avatar-image-item--men').classList.add('register__avatar-image-item--line');
        document.querySelector('.register__avatar-image-item--girl').classList.remove('register__avatar-image-item--line');
    }else if(type === "girl"){
        document.querySelector('.register__avatar-image-item--men').classList.remove('register__avatar-image-item--line');
        document.querySelector('.register__avatar-image-item--girl').classList.add('register__avatar-image-item--line');
    }
}

$('#other').click(function(){
    document.querySelector('.register__avatar-image-item--girl').classList.remove('register__avatar-image-item--line');
    document.querySelector('.register__avatar-image-item--men').classList.remove('register__avatar-image-item--line');
    document.querySelector('#default_image').setAttribute('value', "");
    $("#img_file").trigger('click');
})

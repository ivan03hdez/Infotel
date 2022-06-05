document.querySelectorAll('.mainMenuList > div').forEach(
    elem => elem.addEventListener('click', 
        (ev) => {
            if(ev.target.outerText === 'Administrador') {
                window.location.href = "http://localhost/infotel/mvc/" + "AdminTablas";
                return;
            }

            if(ev.target.outerText === 'Mantenimiento') {
                window.location.href = "http://localhost/infotel/mvc/" + "AdminEstadisticas";
                return;
            }
            
            window.location.href = "http://localhost/infotel/mvc/" + ev.target.outerText.toLowerCase().replace(/\s/g, '')
        }
    )
);

function showUnderlined() { 
    const URLSplitted = window.location.href.split('/');
    document.querySelectorAll('.underlined').forEach( elem => {
        const lastUrlWord =  URLSplitted[URLSplitted.length-1].toLowerCase();
        const elementUnderlined = elem.parentElement.textContent.replace(/\s/g, '').toLowerCase();
        if(
            lastUrlWord === elementUnderlined
            || (elementUnderlined == 'administrador' && lastUrlWord == 'admintablas')
            || (elementUnderlined == 'mantenimiento' && lastUrlWord == 'adminestadisticas')
        ) {
            elem.style.display = "block";
        }}
    );
}

function postLoginForm() {
    const aTag = document.querySelector('a#iniciarSesion');
    if (!aTag) return;
    aTag.addEventListener(
        'click',
        () => document.querySelector('#loginForm').submit()
    )
};

function postRegisterForm() {
    const aTag = document.querySelector('a#crearCuenta')
    if (!aTag) return;
    aTag.addEventListener(
        'click',
        () => document.querySelector('#registerForm').submit()
    )
};

/*function createDeletePopUp() {
    document.querySelectorAll('#BotonBorrar').forEach( elem => {
        elem.addEventListener(
            'click',
            () => {
                var input=$(this).parents('input').firstElementChild;
                var data=input.value;
                var urlSplitted = window.location.pathname.split('/');
                if(confirm("¿Are you sure you want to delete this object?")) {
                    // create a post request to the same url and send the dat
                    const http = new XMLHttpRequest();
                    http.open();
                    http.setRequestHeader();
                    http.send(data);
                    window.location.replace("http://localhost/Infotel/mvc/admin" + urlSplitted[urlSplitted.length - 1].replace('modelo',''));
                }
            }
        )
    });
}*/

window.onload = () => {
    showUnderlined();
    postLoginForm();
    postRegisterForm();
}

/*$(document).ready(function () {
    $('div #trash').click(function() {
      var row=$(this).parents('tr');
      var id=row.data('id');
      var urlClass = window.location.pathname.split('/')[1];/////funciona en admin porque cojo la clase dinamicamente
      if(confirm("¿Are you sure you want to delete this object?"))
        window.location.replace("http://localhost/infotel/mvc/admin/" + urlClass +"/delete/"+id);
    })
  });*/

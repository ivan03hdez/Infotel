document.querySelectorAll('.mainMenuList > div').forEach(
    elem => elem.addEventListener('click', 
        (ev) => {
            if(ev.target.outerText === 'Administrador') {
                window.location.href = "http://localhost/infotel/mvc/" + "AdminTablas";
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
            || [lastUrlWord, elementUnderlined].every(elem => elem.startsWith('admin'))
        ) {
            elem.style.display = "block";
        }}
    );
}

function postLoginForm() {
    const aTag = document.querySelector('a#iniciarSesion')
    aTag.addEventListener(
        'click',
        () => {
            const usuario =  document.querySelector('#usuario').value;
            const contrasena =  document.querySelector('#contraseña').value;
            const Http = new XMLHttpRequest();
            const url=this.href;
            Http.open("POST", url);
            Http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            Http.send(`usuario=${usuario}&contrasena=${contrasena}`);
            Http.onreadystatechange = (e) => {
                //if (this.readyState == 4 && this.status == 200)
                    document.querySelector('body').append('status: ' + status + ', data: ' + data);
                /*else
                    document.querySelector('body').append('status: ' + status + ', data: ' + data);*/
            }
        }
    )
};

window.onload = () => {
    showUnderlined();
    postLoginForm()
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

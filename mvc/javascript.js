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

window.onload = () => {
    const URLSplitted = window.location.href.split('/');
    document.querySelectorAll('.underlined').forEach( elem => {
        const lastUrlWord =  URLSplitted[URLSplitted.length-1].toLowerCase();
        const elementUnderlined = elem.parentElement.textContent.replace(/\s/g, '').toLowerCase();
        if(
            lastUrlWord === elementUnderlined
            || [lastUrlWord, elementUnderlined].every(elem => elem.startsWith('admin'))
        ) {
            elem.style.display = "block";
        }
    });
}

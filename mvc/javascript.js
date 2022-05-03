document.querySelectorAll('.mainMenuList > div').forEach(
    elem => elem.addEventListener('click', 
        ev =>window.location.href = "http://localhost/infotel/mvc/" + ev.target.outerText.toLowerCase().replace(/%20/g, '')
    )
);

window.onload = () => {
    const URLSplitted = window.location.href.split('/');
    document.querySelectorAll('.underlined').forEach( elem => {
        if(URLSplitted[URLSplitted.length-1].toLowerCase() === elem.parentElement.textContent.toLowerCase())
            elem.style.display = "block";
        }
    );
}

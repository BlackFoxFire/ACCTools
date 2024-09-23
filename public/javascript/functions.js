/**
 * Permet de rajouter un zéro devant un chiffre
 * 
 * @param {*} val 
 * @returns 
 */
function zero(val)
{
    val = val.toString()

    if(val.length == 1) {
        return "0" + val;
    }

    return val;
}

/**
 * Affiche une balise html
 * 
 * @param {*} field 
 */
function display(field)
{
    document.getElementById(field).style.display = "block";
}

/**
 * Cache une balise html
 * 
 * @param {*} field 
 */
function hide(field)
{
    document.getElementById(field).style.display = "none";
}

/**
 * Mofidie la valeur d'une balise html
 * 
 * @param {*} id 
 * @param {*} text 
 */
function innerHTML(id, text)
{
    document.getElementById(id).innerHTML = text;
}

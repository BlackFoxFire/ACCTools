/**
 * Modifie la valeur de la balise avec l'id lapTimeValue
 * 
 */
function updateLapTime()
{
    innerHTML("lapTimeValue", zero(Math.floor(lapTime.value / 60)) + ":" + zero(lapTime.value % 60));
}

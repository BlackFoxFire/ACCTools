/**
 * Modifie la valeur de la balise avec l'id raceTimeValue
 * 
 */
function updateRaceTime()
{
    if((raceTimeArray[raceTime.value] - 1) < 90 ) {
        innerHTML("raceTimeValue", raceTimeArray[raceTime.value] + " Minutes");
    } else {
        innerHTML("raceTimeValue", (raceTimeArray[raceTime.value] / 60) + " Heures");
    }

    updateRelay();
}

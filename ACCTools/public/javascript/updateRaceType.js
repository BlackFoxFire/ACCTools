/**
 * Modifie la valeur de la balise avec l'id raceTypeValue
 * 
 */
function updateRaceType()
{
    hide("typePitStopDiv");
    display("relayDiv");
    hide("pilotRelayTime");

    if(raceType.value == 1) {
        innerHTML("raceTypeValue", "Sprint Race");
        raceTime.max = 7;
        raceTime.value = 5;
        raceTimeArray = raceTimeArray1;
        hide("relayDiv");
    }

    if(raceType.value == 2) {
        innerHTML("raceTypeValue", "Endurance 3H");
        raceTime.max = 4;
        raceTime.value = 1;
        raceTimeArray = raceTimeArray2;
    }

    if(raceType.value == 3) {
        innerHTML("raceTypeValue", "Endurance 6H");
        raceTime.max = 4;
        raceTime.value = 1;
        raceTimeArray = raceTimeArray3;
    }

    if(raceType.value == 4) {
        innerHTML("raceTypeValue", "Endurance 24H");
        raceTime.max = 7;
        raceTime.value = 0;
        raceTimeArray = raceTimeArray4;
    }

    if(raceType.value == 5) {
        innerHTML("raceTypeValue", "Personnalisée");
        raceTime.max = 20;
        raceTime.value = 0;
        raceTimeArray = raceTimeArray5;
        display("typePitStopDiv");
        hide("relayDiv");
        typePitStop.max = 3;
        typePitStop.value = 1;
    }

    updateRaceTime();
}

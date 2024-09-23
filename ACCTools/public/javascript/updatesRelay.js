/**
 * Calcule les temps de pilotage
 * 
 */
function updateRelay()
{
    let pilotTime = 0;
    let flag = false;

    if(raceType.value == 1) {
        pitStop = 0;
        innerHTML("pitStopValue", 1);
    }
    else if(raceType.value == 2) {
        flag = true;
        pilotTime = (3600 / (10800 / (raceTimeArray[raceTime.value] * 60))) + 300;
        pitStop = 3;
    }
    else if(raceType.value == 3 || raceType.value == 4) {
        flag = true;

        if(raceType.value == 3 ) {
            pilotTime = (3600 / (21600 / (raceTimeArray[raceTime.value] * 60))) + 300;
        }
        else {
            pilotTime = (3600 / (86400 / (raceTimeArray[raceTime.value] * 60))) + 300;
        }

        pitStop = Math.ceil((raceTimeArray[raceTime.value] * 60) / pilotTime);
    }
    else {
        hide("relayDiv");
        hide("pilotRelayTime");
        
        if(raceTimeArray[raceTime.value] < 120) {
            display("typePitStopDiv");
            if(raceTimeArray[raceTime.value] < 30) {
                typePitStop.max = 2;
            }
            else {
                typePitStop.max = 3;
            }

            if(typePitStop.value == 1) {
                innerHTML("typePitStopValue", "Aucun arrêt aux stands");
                pitStop = 0;
                innerHTML("pitStopValue", 0);
            }
            else if(typePitStop.value == 2) {
                innerHTML("typePitStopValue", "Fenêtre d'arrêt aux stands");
                pitStop = 2;
                innerHTML("pitStopValue", 1);
            }
            else {
                innerHTML("typePitStopValue", "Limite de relais du pilote: ");
                display("relayDiv");
                flag = true;

                if(raceTimeArray[raceTime.value] == 30) {
                    pilotRelayTime.max = 0;
                }
                else if(raceTimeArray[raceTime.value] == 60) {
                    display("pilotRelayTime");
                    pilotRelayTime.max = 1;
                }
                else if(raceTimeArray[raceTime.value] == 90) {
                    display("pilotRelayTime");
                    pilotRelayTime.max = 2;
                }

                pilotTime = relayArray[pilotRelayTime.value] * 60;
                pitStop = Math.ceil((raceTimeArray[raceTime.value] * 60) / pilotTime);
            }
        }
        else {
            flag = true;
            hide("typePitStopDiv");
            display("relayDiv");
            display("pilotRelayTime");

            if(raceTimeArray[raceTime.value] < 180) {
                pilotRelayTime.max = 2;
            }
            else {
                pilotRelayTime.max = 3;
            }

            pilotTime = relayArray[pilotRelayTime.value] * 60;
            pitStop = Math.ceil((raceTimeArray[raceTime.value] * 60) / pilotTime);
        }
    }

    if(flag) {
        let reste = pilotTime % 60;

        if(reste != 0) {
            innerHTML("relayValue", Math.floor(pilotTime / 60) + " Min " + reste + "s");
        }
        else {
            innerHTML("relayValue", Math.floor(pilotTime / 60) + " Minutes");
        }

        innerHTML("pitStopValue", pitStop - 1);
    }
}


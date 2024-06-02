/**
 * Constantes
 */
const raceType = document.getElementById('raceType');
const raceTime = document.getElementById('raceTime');
const lapTime = document.getElementById('lapTime');
const consumption = document.getElementById('consumption');
const typePitStop = document.getElementById('typePitStop');
const stand = document.getElementById('stand');
const pilotRelayTime = document.getElementById('pilotRelayTime');

/**
 * Déclaration des évenements
 */

raceType.addEventListener("input", function() {
    updateRaceType();
});

raceTime.addEventListener("input", function() {
    updateRaceTime();
});

lapTime.addEventListener("input", function() {
    updateLapTime();
});

consumption.addEventListener("input", function() {
    updateConsumption();
});

typePitStop.addEventListener("input", function() {
    updateRelay();
});

stand.addEventListener("input", function() {
    updateStand();
});

pilotRelayTime.addEventListener("input", function() {
    updateRelay();
});

document.getElementById('myForm').addEventListener("input", function() {
    update();
});

/**
 * Tableau des temps de course en minutes
 */
const raceTimeArray1 = [5, 10, 15, 20, 25, 30, 45, 60];
const raceTimeArray2 = [30, 60 ,90, 120, 180];
const raceTimeArray3 = [60, 120, 180, 240, 360];
const raceTimeArray4 = [180, 360, 480, 540, 600, 720, 1080, 1440];
const raceTimeArray5 = [10, 20, 30, 60 ,90, 120, 180, 240, 300, 360, 420, 480, 540, 600, 720, 840, 960, 1080, 1200, 1320, 1440];

/**
 * Tableau des temps de pilotage en minutes
 */
const relayArray = [10, 20, 30, 60];

/**
 * Initialisation des variables
 */
let raceTimeArray = raceTimeArray1;
let pitStop = 0;

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

/**
 * Modifie la valeur de la balise avec l'id raceTypeValue
 * 
 */
function updateRaceType()
{
    hide("typePitStopDiv");
    display("relayDiv");
    hide("standDiv");
    hide("pilotRelayTimeDiv");

    if(raceType.value == 1) {
        innerHTML("raceTypeValue", "Sprint Race");
        raceTime.max = 7;
        raceTime.value = 5;
        raceTimeArray = raceTimeArray1;
        display("standDiv");
        stand.max = 5;
        updateStand();
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

/**
 * Modifie la valeur de la balise avec l'id lapTimeValue
 * 
 */
function updateLapTime()
{
    innerHTML("lapTimeValue", zero(Math.floor(lapTime.value / 60)) + ":" + zero(lapTime.value % 60));
}

/**
 * Modifie la valeur de la balise avec l'id consumptionValue
 * 
 */
function updateConsumption()
{
    innerHTML("consumptionValue", Number(consumption.value).toFixed('1') + ' L');
}

/**
 * Modifie la valeur de la balise avec l'id standValue
 * 
 */
function updateStand()
{
    innerHTML("relayValue", stand.value);
    
   updateRelay();
}

/**
 * Calcule les temps de pilotage
 * 
 */
function updateRelay()
{
    let pilotTime = 0;
    let flag = false;

    if(raceType.value == 1) {
        innerHTML("relayLabel", "Arrêt au stand: ");

        if(Number(stand.value) > 0) {
            pitStop = Number(stand.value) + 1;
            innerHTML("pitStopValue", stand.value);
        }
        else {
            pitStop = 0;
            innerHTML("pitStopValue", 0);
        }
    }
    else if(raceType.value == 2) {
        flag = true;
        innerHTML("relayLabel", "Limite de relais du pilote: ");
        pilotTime = (3600 / (10800 / (raceTimeArray[raceTime.value] * 60))) + 300;
        pitStop = 3;
    }
    else if(raceType.value == 3 || raceType.value == 4) {
        flag = true;
        innerHTML("relayLabel", "Limite de relais du pilote: ");

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
        hide("pilotRelayTimeDiv");
        
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
                innerHTML("relayLabel", "Limite de relais du pilote: ");
                flag = true;

                if(raceTimeArray[raceTime.value] == 30) {
                    pilotRelayTime.max = 0;
                }
                else if(raceTimeArray[raceTime.value] == 60) {
                    display("pilotRelayTimeDiv");
                    pilotRelayTime.max = 1;
                }
                else if(raceTimeArray[raceTime.value] == 90) {
                    display("pilotRelayTimeDiv");
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
            innerHTML("relayLabel", "Limite de relais du pilote: ");
            display("pilotRelayTimeDiv");

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

/**
 * Calcule la consommation total pour une course
 * 
 */
function update()
{
    let conso = Math.ceil((raceTimeArray[raceTime.value] / (lapTime.value / 60)) * consumption.value);

    if(formationLap.checked) {
        conso = Math.ceil(conso + Number(consumption.value));
    }

    innerHTML("fuel", conso + " Litres");

    if (pitStop == 0) {
        hide("relayFuelDiv")
    }
    else {
        document.getElementById('relayFuelDiv').style.display = "";
        innerHTML("relayFuel", Math.ceil(conso / pitStop) + " Litres");
    }

    innerHTML("totalLaps", Math.floor(conso / consumption.value));
    innerHTML("fuelPerMinutes", ((consumption.value / lapTime.value) * 60).toFixed('2') + 'L');
}

updateRaceType();
updateRaceTime();
updateLapTime();
updateConsumption();
updateStand();
update();

/**
 * Calcule la consommation total pour une course
 * 
 */
function updateConsumption()
{
    let totalLaps = Math.ceil(raceTimeArray[raceTime.value] / (Number(lapTime.value) / 60));
    let fuelPerMinutes = ((Number(consumption.value) / Number(lapTime.value)) * 60).toFixed('2');
    let conso = totalLaps * Number(consumption.value);

    if(formationLap.checked) {
        conso = conso + Number(consumption.value);
    }

    conso = Math.ceil(conso);

    innerHTML("fuel", conso + " Litres");

    if (pitStop == 0) {
        hide("relayFuelDiv");
    }
    else {
        let relayFuel = Math.ceil(conso / pitStop);
        
        document.getElementById('relayFuelDiv').style.display = "";
        innerHTML("relayFuel", relayFuel + " Litres");
    }

    innerHTML("totalLaps", totalLaps);
    innerHTML("fuelPerMinutes", fuelPerMinutes + 'L');
}

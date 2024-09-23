/**
 * Modifie la valeur de la balise avec l'id consumptionValue
 * 
 */
function updateConsumptionValue()
{
    innerHTML("consumptionValue", Number(consumption.value).toFixed('1') + ' L');
}

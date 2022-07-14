
if (!jQuery) {
	alert('JQuery is either not loaded or unavailable.');
}
var fruits = {"Apple" : "Red", "Orange" : "Orange", "Pear" : "Green"};

function getFruitColor() {
	var fruitSelected = $("input[name='fruitRadio']:checked").val();
    alert('For fruit key : ' + fruitSelected + ' array value found is = ' + fruits[fruitSelected]);
}

function getFruitColorByInput() {
	var fruitInputValue = $("#fruittext").val();
	if(typeof fruits[fruitInputValue] !== "undefined") {
		alert('For fruit key : ' + fruitInputValue + ' array value found is = ' + fruits[fruitInputValue]);
	}
	else {
		alert("Fruit Key : " +  fruitInputValue + " color is not set in Fruit array")
	}

}
function setFruitColor()
{
	var fruitSelected = $("input[name='fruitsetRadio']:checked").val();
	var fruitInputValue = $("#setFruittext").val();
	if(fruitInputValue && fruitSelected) {
		fruits[fruitSelected] = fruitInputValue;
		alert(fruitSelected + " color has been set to [" + fruitInputValue + "]. Please Test it.");

	}
	else {
		alert("missing one of the parameter.");
	}

}

function toggleCart(radio) {
    var cartBuy = document.getElementById('cartBuy');
    if (radio.value === 'Картой') {
        cartBuy.style.display = 'flex';
    } else if (radio.value === 'Наличными') {
        cartBuy.style.display = 'none';
    }
}

function checkLength(input, maxLength) {
    if (input.value.length > maxLength) {
        input.value = input.value.slice(0, maxLength);
    }
    if (input.value.includes("/") & input.value.length == 4){
        input.value = input.value.replace("/", "");
    }
    if (input.value.length == 4) {
        input.value = input.value.slice(0, 2) + "/" + input.value.slice(2, 4);
    }
}

function checkLength2(input) {
    if ((input.value.length === 4 || input.value.length === 9 || input.value.length === 14) && input.value.length < 20) {
        input.value = input.value + " ";
    }
}
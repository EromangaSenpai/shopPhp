function buy() {
    alert('You buy all this shit');
    document.location = "MainPage.php";
}

function clear() {
    document.getElementById('cartCount').innerHTML = 0;
    alert('You clear your cart');
    document.location = "MainPage.php";
}

function funcBefore() {
    console.log('Wait pls');
}

function funcSuccess(data) {
    alert('eee boy' + data);
}

function AddToCart(elem, productId, prodCount) {
    var counter = 0;
    var textHtml = document.getElementById('cartCount').innerHTML;
    if(textHtml == "")
    {
        counter += parseInt(prodCount);
    }
    else
    {
        var counter = parseInt(document.getElementById('cartCount').innerText);
        counter += parseInt(prodCount);
    }
    document.getElementById('cartCount').innerHTML = counter;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("myCartTable").innerHTML += this.responseText;
            alert('Product was add to cart');
        }
    };
    xmlhttp.open("GET", "phpScripts/addToCart.php?id=" + productId + "&count=" + prodCount, true);
    xmlhttp.send();


}
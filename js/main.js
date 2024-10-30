function showReceipt(receipt) {
    let content = '';

    for (let i = 0; i < receipt.products.length; i++) {
        let product = receipt.products[i];
        let productLine = product.type + ' ' + product.name;
        if (product.size) {
            productLine += ' (' + product.size + ' см' + ')';
        }
        productLine += ' - ' + product.price + ' BYN ';

        content += productLine + '<br>';
    }

    $('#receipt').html('<p><h3>Вaш заказ</h3></p>' + content + '<p>Итого: ' + receipt.total + '  BYN </p>');
}


$(document).ready(function() {
    $('#order').on('click', function(e) {
        e.preventDefault();
        const pizzaId = $('#pizzaId').val();
        const sizeId = $('#sizeId').val();
        const sauceId = $('#sauceId').val();

        $.ajax({
            type: 'POST',
            url: 'src/api/Order.php',
            contentType: 'application/json',
            data: JSON.stringify({
                pizzaId: pizzaId, sizeId: sizeId, sauceId: sauceId
            }),
            success: function(response) {
                const data = JSON.parse(response);
                showReceipt(data);
            }
        });
    });
})

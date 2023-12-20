function GoToOrderDetail() {
    window.location.href = './order-detail.php'
}

$(document).ready(function(){
    $(".delBtn").click(function(){
        var id = $(this).attr("id");
        var orderID = $(this).attr("value");
        $.ajax({
            type: "POST",
            url: "delOrder.php",
            data: {orderID: orderID},
            success: function(data){
                if (data == 1 && id == "isprocessed"){
                    window.location.href = "processed.php";
                }else if (data == 1 && id == "unprocessed"){
                    window.location.href = "unprocess.php";
                }
            }
        })
    })
})
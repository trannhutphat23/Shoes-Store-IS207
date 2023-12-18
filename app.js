Home();
var navScreen = window.matchMedia("(max-width: 1000px)")

navScreen.addEventListener("change", function () {
    if (navScreen.matches) { // If media query matches
        console.log(1)
    } else {
        var navslide = document.querySelector(".nav-slide")
        navslide.classList.add("hidden")

    }
});

function OpenNavSlide() {
    var navslide = document.querySelector(".nav-slide")
    navslide.classList.toggle("hidden")
}

function routerPage(url) {
    document.getElementById('frame').src = url;
    document.addEventListener("DOMContentLoaded", function () {
        var iframe = document.getElementById("frame");
        iframe.addEventListener("load", function () {
            var iframeDocument = iframe.contentDocument;
            if (iframeDocument) {
                var contentHeight = iframeDocument.body.scrollHeight;
                document.getElementById('display').style.height = contentHeight + 'px';
            }
        });
    });
}

function shoppingCart() {
    const cookieName = 'checkSignin';
    const cookies = document.cookie.split(';');
    let cookieValue = null;
    
    for (let i = 0; i < cookies.length; i++) {
      const cookie = cookies[i].trim();
      if (cookie.startsWith(cookieName + '=')) {
        cookieValue = cookie.substring(cookieName.length + 1);
        break;
      }
    }
    if (cookieValue == 0){
        swal("Failure!", "Bạn chưa đăng nhập", "warning");
    }else{
        routerPage('./shopping-cart/cart.php');
    }
}

function BrandItem(brandName) {
    routerPage('./home-page/brandItem.php?brandName=' + brandName)
}

function BrandItemIframe(brandName) {
    location.href = '../home-page/brandItem.php?brandName=' + brandName;
    window.parent.document.getElementById('header').scrollIntoView(true);
}

function CheckOut(username, size, quantity, checkBuy) {
    const cookieName = 'checkSignin';
    const cookies = document.cookie.split(';');
    let cookieValue = null;
    
    for (let i = 0; i < cookies.length; i++) {
      const cookie = cookies[i].trim();
      if (cookie.startsWith(cookieName + '=')) {
        cookieValue = cookie.substring(cookieName.length + 1);
        break;
      }
    }
    if (cookieValue == 0){
        swal("Failure!", "Bạn chưa đăng nhập", "warning");
    }else{
        location.href = '../shopping-cart/checkout.php?username=' + username + "&size=" + size + "&quantity=" + quantity + "&checkBuy=" + 1;
        window.parent.document.getElementById('header').scrollIntoView(true);
    }
}

function Shipping() {
    routerPage("./shopping-cart/shipping.php")
}

function Shoe(shoe) {
    location.href = '../shoe/shoe.php?ShoeName='+shoe;
    window.parent.document.getElementById('header').scrollIntoView(true);
}

function orderDetail(id) {
    location.href = '../shopping-cart/orderDetail.php?orderID=' + id;
    window.parent.document.getElementById('header').scrollIntoView(true);
}

function Home() {
    routerPage('./home-page/home.php')
}

function signIn() {
    document.cookie = "checkSignin=0";
    routerPage('./login-register/signIn.php')
}

function signUp() {
    routerPage('./login-register/signUp.php')
}

function Account() {
    routerPage('./account/account.php');
}

function Fav() {
    const cookieName = 'checkSignin';
    const cookies = document.cookie.split(';');
    let cookieValue = null;
    
    for (let i = 0; i < cookies.length; i++) {
      const cookie = cookies[i].trim();
      if (cookie.startsWith(cookieName + '=')) {
        cookieValue = cookie.substring(cookieName.length + 1);
        break;
      }
    }
    if (cookieValue == 0){
        swal("Failure!", "Bạn chưa đăng nhập", "warning");
    }else{
        routerPage('./home-page/fav.php')
    }
}
//----------------------------------------

function SignUp() {
    $(function () {
        $(".noti").removeClass("hidden");
        window.parent.document.getElementById('header').scrollIntoView(true);
    });
}

function userMenu() {
    $(function () {
        $(".userMenu").toggleClass("hidden");
    });
}

function SignIn() {
    window.location.href = "../home-page/home.php";
    window.parent.document.getElementById('header').scrollIntoView(true);
}

function LogOut() {
    var checkLogout = confirm("Are you sure you want to log out?");
    if (checkLogout){
        document.cookie = "checkSignin=0";
        $(function () {
            $(".signed").addClass("hidden");
        });
        $(function () {
            $(".unsigned").removeClass("hidden");
        });
        routerPage('./home-page/home.php');
    }
}

function cancelNoti() {
    location.href = '../login-register/signIn.php';
    window.parent.document.getElementById('header').scrollIntoView(true);
}

function check() {
    $(function () {
        $(".checked").toggleClass("hidden");
    });
    $(function () {
        $(".uncheck").toggleClass("hidden");
    });
}

//-----------------------
function favouriteShoe() {
    $(function () {
        $(".favouriteShoe").toggleClass("fa-solid");
        $(".favouriteShoe").toggleClass("fa-regular");
    });
}

function inc() {
    var quantity = document.getElementById("quantity");
    ++quantity.value
}

function dec() {
    var quantity = document.getElementById("quantity");
    if (quantity.value > 1) --quantity.value
}

function choseImg(clickedImg) {
    const images = document.querySelectorAll('.asideImg');
    images.forEach(img => img.classList.remove('chose'));

    clickedImg.classList.add('chose');

    const imgDisplay = document.getElementById('imgDisplay');

    if (clickedImg.classList.contains('chose'))
        imgDisplay.src = clickedImg.getAttribute('src');
}

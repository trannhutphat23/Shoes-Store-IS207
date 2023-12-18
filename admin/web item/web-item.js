function GoToItemDetail() {
    window.location.href = './item-view.php'
}

function handleBrand(element) {
    $(element).toggleClass("clicked-border")
}

function showSortOption() {
    $(".sort-option").toggle()
}

function getOption(element) {
    var optionText = $(element).find('p').text();
    console.log(optionText);
    $('.button-text').text(optionText);
    $(".sort-option").hide();
}

function Edit(element) {
    // Toggle the red color of the clicked strong element
    element.style.color = (element.style.color === 'red') ? '' : 'red';

    // Find the nearest input, select, or textarea within the parent div
    var inputElement = element.closest('.input-box').querySelector('input, select, textarea');

    // Toggle the disabled attribute
    if (inputElement.disabled)
        inputElement.disabled = !inputElement.disabled;
}

function Save() {
    // Disable all input fields, select boxes, and textareas
    var inputElements = document.querySelectorAll('.input-box input, .input-box select, .input-box textarea');
    inputElements.forEach(function (element) {
        element.disabled = true;

        // Reset the color of all strong elements
        var strongElements = document.querySelectorAll('.input-box strong');
        strongElements.forEach(function (strongElement) {
            strongElement.style.color = '';
        });
    });
}

function choseImg(clickedImg) {
    const images = document.querySelectorAll('.asideImg');
    images.forEach(img => img.classList.remove('chose'));

    clickedImg.classList.add('chose');

    const imgDisplay = document.getElementById('imgDisplay');

    if (clickedImg.classList.contains('chose'))
        imgDisplay.src = clickedImg.getAttribute('src');
    // alert(clickedImg.getAttribute('src'));
}

function uploadImage() {
    var input = document.getElementById('imageInputMain');
    var preview = document.getElementById('preview');
    var aside = document.getElementById('aside');

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            preview.innerHTML = '<img src="' + e.target.result + '" alt="mainImg" class="main-img" id="imgDisplay">';
            var img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'asideImg';
            img.class = "asideImg";
            img.onclick = function () {
                choseImg(img);
            };
            aside.appendChild(img);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function uploadImages() {
    var input = document.getElementById('imageInputAside');
    var preview = document.getElementById('preview');
    var aside = document.getElementById('aside');

    if (!preview.hasChildNodes()) {
        alert('Vui lòng tải ảnh chính lên trước');
        return;
    }

    if (input.files && input.files.length == 4) {
        for (var i = 0; i < input.files.length; i++) {
            var reader = new FileReader();
            var file = input.files[i];

            reader.onload = (function (file) {
                return function (e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'asideImg';
                    img.className = "asideImg";
                    img.onclick = function () {
                        choseImg(img);
                    };
                    aside.appendChild(img);
                };
            })(file);

            reader.readAsDataURL(file);
        }
    } else {
        alert('Hãy chọn 4 ảnh');
    }
}
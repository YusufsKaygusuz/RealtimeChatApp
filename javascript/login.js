const form = document.querySelector(".login form"),
    continueBtn = form.querySelector(".button input"),
    errorText = form.querySelector(".error-txt");

form.onsubmit = (e) => {
    e.preventDefault(); // formun gönderilmesinden önceki hali
}

continueBtn.onclick = () => {
    // Ajax'a başlıyoruz
    let xhr = new XMLHttpRequest(); // XML nesnesi oluşturma
    xhr.open("POST", "php/login.php", true);

    // CSRF koruması
    let csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        xhr.setRequestHeader("X-CSRF-Token", csrfToken.getAttribute('content'));
    }

    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                console.log(data);
                if (data == "success") {
                    location.href = "users.php";
                }
                else {
                    errorText.textContent = data;
                    errorText.style.display = "block";
                }
            }
        }
    }
    // form verilerini ajax aracılığıyla php'ye göndermeliyiz
    let formData = new FormData(form); //yeni formData nesnesi oluşturma
    
    // Parola alanının güvenliği
    let password = formData.get('password');
    password = password.replace(/</g, "&lt;").replace(/>/g, "&gt;"); // Karakter özelliklerini kodlayın.
    formData.set('password', password);

    xhr.send(formData); // form verilerini php'ye gönderme
}

const form = document.querySelector(".signup form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-txt");

form.onsubmit = (e)=>{
    e.preventDefault(); // form göndermeyi engelleme
}

// Kayıt ol butonuna tıklandığında AJAX kullanarak form verilerini PHP'ye gönderiyoruz.
// XMLHTTP nesnesi oluşturuyoruz ve 'php/signup.php' adresine POST isteği gönderiyoruz.
// Sunucudan cevap gelinceye kadar sayfa yenilenmeden işlem devam eder.
// Gelen cevap 200 ise, cevap metni 'data' değişkeninde tutulur ve 'success' ise kullanıcı sayfasına yönlendirilir.
// Aksi takdirde, hata mesajı görüntülenir.
// Son olarak, form verileri, FormData nesnesi kullanılarak alınır ve XMLHTTP nesnesi ile PHP'ye gönderilir.

continueBtn.onclick = ()=>{
    // Ajax'a başlıyoruz
    let xhr = new XMLHttpRequest(); // XML nesnesi oluşturma
    xhr.open("POST", "php/signup.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if(data == "success")
                {
                    location.href="users.php";

                }
                else{
                    errorText.textContent= data;
                    errorText.style.display = "block";
                }
            }
        }
    }
    // form verilerini ajax aracılığıyla php'ye göndermeliyiz
    let formData = new FormData(form); //yeni formData nesnesi oluşturma
    xhr.send(formData); //form verilerini php'ye gönderme
}

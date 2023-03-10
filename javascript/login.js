const form = document.querySelector(".login form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-txt");

// Submit olayını engellemek için kullanılan kod bloğu
form.onsubmit = (e)=>{
    e.preventDefault();
}
// Devam et butonuna tıklanıldığında çalışan kod bloğu
continueBtn.onclick = ()=>{
    // Ajax'a başlıyoruz
    let xhr = new XMLHttpRequest(); // XML nesnesi oluşturma
    xhr.open("POST", "php/login.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                console.log(data);
                if(data == "success")
                {
                    // Başarılı giriş durumunda kullanıcının yönlendirileceği sayfa
                    location.href="users.php";
                }
                else{
                    // Hatalı giriş durumunda ekrana gösterilecek hata mesajı
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

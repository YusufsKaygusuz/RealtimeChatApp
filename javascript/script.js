// "password" tipindeki input alanını seç
const pswrdField = document.querySelector(".form input[type='password']"),
// toggle butonunu seç
toggleBtn = document.querySelector(".form .field i");

// Bu kod, kullanıcının şifre alanındaki metni gizlemek veya göstermek için bir toggle düğmesi oluşturur.
// Kullanıcı düğmeye tıkladığında, şifre alanındaki metin ya gizlenir ya da gösterilir.
// Bu, kullanıcıların şifrelerini gizleyerek girdikleri bir giriş formu için kullanılabilir.

// toggle butonuna tıklandığında çalışacak fonksiyon
toggleBtn.onclick = ()=> {
    // eğer input alanı "password" tipindeyse
    if(pswrdField.type == "password"){
        // input alanının tipini "text" olarak değiştir
        pswrdField.type = "text";
        // toggle butonuna "active" sınıfını ekle
        toggleBtn.classList.add("active");
    }
    else{
        // input alanının tipini tekrar "password" olarak değiştir
        pswrdField.type = "password";
        // toggle butonundan "active" sınıfını kaldır
        toggleBtn.classList.remove("active");
    }
}

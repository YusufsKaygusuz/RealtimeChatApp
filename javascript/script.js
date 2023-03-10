const pswrdField = document.querySelector(".form input[type='password']"),
toggleBtn = document.querySelector(".form .field i");

// Bu kod, kullanıcının şifre alanındaki metni gizlemek veya göstermek için bir toggle düğmesi oluşturur.
// Kullanıcı düğmeye tıkladığında, şifre alanındaki metin ya gizlenir ya da gösterilir.
// Bu, kullanıcıların şifrelerini gizleyerek girdikleri bir giriş formu için kullanılabilir.

toggleBtn.onclick = ()=> {
    if(pswrdField.type == "password"){
        pswrdField.type = "text";
        toggleBtn.classList.add("active");
    }
    else{
        pswrdField.type = "password";
        toggleBtn.classList.remove("active");
    }
}

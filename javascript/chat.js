const form = document.querySelector(".typing-area"),
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector('.chat-box');

/*Bu aşağıdaki form.onsubmit kodu, bir HTML formunun submit (gönderme) işlemi gerçekleştiğinde sayfanın yenilenmesini
engellemek için kullanılıyor. form değişkeni, .typing-area sınıfı olan HTML formunu seçiyor.
form.onsubmit olayı, form gönderildiğinde çalıştırılacak fonksiyonu belirtiyor.
Bu fonksiyonda e.preventDefault() kullanılarak, formun varsayılan işlemini durdurarak sayfanın yenilenmesi önlenebiliyor.
*/

form.onsubmit = (e) =>{
    e.preventDefault();
}

sendBtn.onclick = ()=>{
    // Ajax'a başlıyoruz
    let xhr = new XMLHttpRequest(); // XML nesnesi oluşturma
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                inputField.value = ""; // mesaj veritabanına eklendikten sonra giriş alanını boş bırakın
                scrollToBottom();
            }
        }
    }
    // form verilerini ajax aracılığıyla php'ye göndermeliyiz
    let formData = new FormData(form); //yeni formData nesnesi oluşturma
    xhr.send(formData); //form verilerini php'ye gönderme
}

chatBox.onmouseenter = () =>{
    chatBox.classList.add("active");
}
chatBox.onmouseleave = () =>{
    chatBox.classList.remove("active");
}

function escapeHtml(unsafe) {
    return String(unsafe)
           .replace('argo', "Kural dışı mesaj ");
}

// Get Yöntemini kullanacağız çünkü verileri göndermek için almamız gerekiyor
setInterval( ()=>{
    // Ajax'a başlıyoruz
    let xhr = new XMLHttpRequest(); // XML nesnesi oluşturma
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onreadystatechange = ()=>{
        if(xhr.readyState === 4){
            if(xhr.status === 200){
                let data = xhr.response;
                data = escapeHtml(data);
                data = document.createElement("div").innerText = data;
                chatBox.innerHTML = data;
                if(!chatBox.classList.contains("active"))
                {
                    scrollToBottom();
                }
            }
        }
    }
    // form verilerini ajax aracılığıyla php'ye göndermeliyiz
    let formData = new FormData(form); //yeni formData nesnesi oluşturma
    xhr.send(formData); //form verilerini php'ye gönderme
}, 500); // bu fonksiyon her 500ms'de çalışacak

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
}

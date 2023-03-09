const form = document.querySelector(".typing-area"),
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector('.chat-box');

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
            .replace('<script>', "hata")
           .replace('/script', "hata")
           .replace('alert()', "hata")
           .replace('script', "hata")
           .replace('<script>', "hata")
           .replace('</h2', "hata")
           .replace('</h2', "hata")
           .replace('</h3', "hata")
           .replace('</h4', "hata")
           .replace('</h5', "hata")
           .replace('</h6', "hata")
           .replace('document.', "hata")
           .replace('();', "hata")
           .replace('', "hata")
           .replace('.querySelector', "");
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

// Kullanıcı girdilerini kontrol eden bir fonksiyon
function validateData(data){
    // verileri filtreleyerek veya doğrulayarak güvenli hale getirin
    // örneğin, özel karakterleri filtreleyebilirsiniz
    // yalnızca metin verilerine izin vermek için aşağıdaki örneği kullanabilirsiniz
    return data.replace(/<\/?[^>]+(>|$)/g, '');
}

const searchBar = document.querySelector(".users .search input"),
searchBtn = document.querySelector(".users .search button"),
userList = document.querySelector(".users .users-list");

searchBtn.onclick = ()=>{
    searchBar.classList.toggle("active");
    searchBar.focus();
    searchBtn.classList.toggle("active");
    searchBar.value = "";
}
// HTML'de oluşturduğumuz arama çubuğunun değerini değişiklikleri dinlemek için tanımlıyoruz
searchBar.onkeyup = ()=>{
    let searchTerm = searchBar.value; // Arama çubuğundaki değeri alıyoruz
    if (searchTerm != ""){
        searchBar.classList.add("active"); // Eğer değer varsa arama çubuğuna "active" class'ını ekliyoruz
    }
    else{
        searchBar.classList.remove("active"); // Değer yoksa "active" class'ını çıkarıyoruz
    }
    // Yeni bir XMLHttpRequest nesnesi oluşturuyoruz
    let xhr = new XMLHttpRequest(); 
    xhr.open("POST", "php/search.php", true); // PHP dosyasına istek göndermek için HTTP POST isteği yapıyoruz
    xhr.onreadystatechange  = ()=>{
        if(xhr.readyState === 4){ // İstek tamamlandı mı diye kontrol ediyoruz
            if(xhr.status === 200){ // HTTP yanıt kodu 200 ise (yani işlem başarılı olduysa)
                let data = xhr.response; // PHP dosyasından gelen verileri alıyoruz
                userList.innerHTML = data; // Verileri kullanıcı listesi HTML elementine ekliyoruz
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // POST isteği ile gönderilen verilerin türünü belirtiyoruz
    xhr.send("searchTerm=" + searchTerm); // Arama çubuğundaki değeri POST isteği ile gönderiyoruz
}

// Aşağıdaki kod, her 500 milisaniyede bir users.php dosyasına GET isteği göndererek,
// kullanıcıların listesini alıp userList elementinin içeriğini güncelliyor.
// Eğer arama kutusu aktif değilse (searchBar elementi active class'ını içermiyorsa),
// kullanıcı listesini güncelliyor. Bu sayede, anlık olarak kullanıcıların
// eklenip çıkarılması durumunda da kullanıcı listesi güncel tutuluyor.
setInterval( ()=>{
    // Ajax'a başlıyoruz
    let xhr = new XMLHttpRequest(); // XML nesnesi oluşturma
    xhr.open("GET", "php/users.php", true);
    xhr.onreadystatechange  = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if(!searchBar.classList.contains("active")){
                    userList.innerHTML = data
                }
            }
        }
    }
    xhr.send();
}, 500); // bu fonksiyon her 500ms'de çalışacak

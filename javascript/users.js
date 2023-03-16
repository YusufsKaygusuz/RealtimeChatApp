const searchBar = document.querySelector(".users .search input"),
    searchBtn = document.querySelector(".users .search button"),
    userList = document.querySelector(".users .users-list");

searchBtn.onclick = () => {
    searchBar.classList.toggle("active");
    searchBar.focus();
    searchBtn.classList.toggle("active");
    searchBar.value = "";
}

searchBar.onkeyup = () => {
    let searchTerm = searchBar.value.trim();
    if (searchTerm != "") {
        searchBar.classList.add("active");
    }
    else {
        searchBar.classList.remove("active");
    }
    // Ajax'a başlıyoruz
    let xhr = new XMLHttpRequest(); // XML nesnesi oluşturma
    xhr.open("POST", "php/search.php", true);
    
    // CSRF koruması
    let csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
      xhr.setRequestHeader("X-CSRF-Token", csrfToken.getAttribute('content'));
    }

    xhr.onreadystatechange = () => {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                let data = xhr.response;
                userList.innerHTML = data;
            }
        }
    }
    // SQL enjeksiyonuna karşı koruma
    searchTerm = searchTerm.replace(/'/g, "\\'");
    searchTerm = searchTerm.replace(/"/g, '\\"');
    let params = "searchTerm=" + encodeURI(searchTerm);

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(params);
    //xhr.send("searchTerm=" + searchTerm); // ajax ile php dosyasına kullanıcı arama terimi gönderme
}

// Get Yöntemini kullanacağız çünkü verileri göndermek için almamız gerekiyor
setInterval(() => {
    // Ajax'a başlıyoruz
    let xhr = new XMLHttpRequest(); // XML nesnesi oluşturma
    xhr.open("GET", "php/users.php", true);
    xhr.onreadystatechange = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                if (!searchBar.classList.contains("active")) {
                    userList.innerHTML = data
                }
            }
        }
    }
    xhr.send();
}, 500); // bu fonksiyon her 500ms'de çalışacak

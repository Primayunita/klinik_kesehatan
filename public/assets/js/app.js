/* public/assets/js/app.js
   Utility sederhana untuk aplikasi Klinik Kesehatan
   - konfirmasi delete
   - real-time search table
   - loader on submit
   - debounce helper
*/

/* ----------------------------------------
   KONFIRMASI DELETE BERDASARKAN CLASS
-----------------------------------------*/
document.addEventListener("click", function(e) {
    if (e.target.classList.contains("btn-delete")) {
        const confirmDelete = confirm("Yakin ingin menghapus data ini?");
        if (!confirmDelete) e.preventDefault();
    }
});

/* ----------------------------------------
   REAL TIME TABLE SEARCH
   (Tambahkan <input id="search"> di halaman)
-----------------------------------------*/
function debounce(func, delay = 200) {
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => func.apply(this, args), delay);
    };
}

const searchInput = document.querySelector("#search");
if (searchInput) {
    searchInput.addEventListener(
        "keyup",
        debounce(function () {
            const keyword = searchInput.value.toLowerCase();
            const rows = document.querySelectorAll("table tbody tr");

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(keyword) ? "" : "none";
            });
        }, 150)
    );
}

/* ----------------------------------------
   AUTO-HIDE ALERT (Flash message)
-----------------------------------------*/
const alerts = document.querySelectorAll(".alert");
alerts.forEach(alert => {
    setTimeout(() => {
        alert.style.opacity = "0";
        alert.style.transition = "0.6s";
        setTimeout(() => alert.remove(), 600);
    }, 2200);
});

/* ----------------------------------------
   SHOW LOADING WHEN SUBMIT FORM
-----------------------------------------*/
const forms = document.querySelectorAll("form");
forms.forEach(form => {
    form.addEventListener("submit", () => {
        const btn = form.querySelector("button[type='submit']");
        if (btn) {
            btn.disabled = true;
            btn.innerText = "Memproses...";
        }
    });
});

/* ----------------------------------------
   SMOOTH SCROLL TO TOP (opsional)
-----------------------------------------*/
function scrollToTop() {
    window.scrollTo({ top: 0, behavior: "smooth" });
}

/* ----------------------------------------
   TABLE HOVER HIGHLIGHT (opsional)
-----------------------------------------*/
document.addEventListener("mouseover", function(e){
    if (e.target.tagName === "TD") {
        e.target.parentElement.style.background = "#f9fbff";
    }
});
document.addEventListener("mouseout", function(e){
    if (e.target.tagName === "TD") {
        e.target.parentElement.style.background = "";
    }
});

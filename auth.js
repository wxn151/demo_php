const baseURL = "http://localhost:8000/";

document.getElementById("loginForm")?.addEventListener("submit", async (e) =>{
    e.preventDefault();
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value; // hash "password" aquí
    const res = await fetch(`${baseURL}api/login.php`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ email, password })
  });
  const data = await res.json();
  if (data.token) {
    localStorage.setItem("jwt", data.token);
    window.location.href = "home.html";
  } else alert(data.message);
});


document.getElementById("form-register")?.addEventListener("submit", async (e) => {
    e.preventDefault();
    const username = document.getElementById("username").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const photoFile = document.getElementById("photo").files[0];

    const toBase64 = file => new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.onloadend = () => resolve(reader.result);
      reader.onerror = reject;
      reader.readAsDataURL(file);
    });

    let photoBase64 = "";
    if (photoFile) {
      photoBase64 = await toBase64(photoFile);
    }

    const res = await fetch(`${baseURL}api/register.php`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ username, email, password, photo: photoBase64 })
    });

    const data = await res.json();

    if (res.ok && data.success) {
      setTimeout(() => {
        window.location.href = "index.html";
      }, 500); // 500 ms delay
    } else {
      alert(data.message || "Registration failed.");
    }
  });


document.querySelectorAll('[data-togglebutton="password"]').forEach(icon => {
  icon.addEventListener("click", () => {
    const input = document.getElementById("password");
    const isHidden = input.type === "password";

    input.type = isHidden ? "text" : "password";

    document.querySelector(".password_invisible").style.display = isHidden ? "none" : "inline";
    document.querySelector(".password_visible").style.display = isHidden ? "inline" : "none";
  });
});


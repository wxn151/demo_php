const baseURL = "http://localhost:8000/";

if (window.location.pathname.includes("home.html")) {
      const jwt = localStorage.getItem("jwt");
      if (!jwt) window.location.href = "index.html";

      fetch(`${baseURL}api/profile.php`, {
        headers: { Authorization: `Bearer ${jwt}` }
      })
        .then(res => res.json())
        // .then(console.log)
        .then(data => {
          document.getElementById("email").textContent = data.email;
          if (data.username) document.getElementById("username").value = data.username;
          if (data.photo) document.getElementById("basePicture").src = data.photo;
          document.getElementById("status").checked = data.status === 1;
        });
    }

    document.getElementById("form-profile")?.addEventListener("submit", async (e) => {
        e.preventDefault();

        const jwt = localStorage.getItem("jwt");
        if (!jwt) {
            alert("No estás autenticado.");
            return;
        }

        const username = document.getElementById("username").value.trim();
        const status = document.getElementById("status").checked ? "active" : "inactive";
        const photoInput = document.getElementById("photo");
        const photoFile = photoInput.files[0];

        // Función para convertir imagen a base64
        const toBase64 = file =>
            new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onloadend = () => resolve(reader.result);
            reader.onerror = reject;
            reader.readAsDataURL(file);
            });

        let photo = "";

        // Si hay imagen nueva, la convertimos
        if (photoFile) {
            try {
            photo = await toBase64(photoFile);
            } catch (err) {
            console.error("Error al convertir la imagen:", err);
            alert("No se pudo procesar la imagen.");
            return;
            }
        }

        // Enviar la solicitud
        try {
            const res = await fetch(`${baseURL}api/update_profile.php`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${jwt}`
            },
            body: JSON.stringify({ username, status, photo })
            });

            const result = await res.json();

            if (!res.ok) {
            throw new Error(result.message || "Error desconocido");
            }

            alert(result.message || "Perfil actualizado correctamente");

            // Opcional: Recargar la página o los datos del usuario
            location.reload();

        } catch (error) {
            console.error("Error al actualizar el perfil:", error);
            alert("No se pudo actualizar el perfil.");
        }
    });


    function logout() {
      localStorage.removeItem("jwt");
      window.location.href = "index.html";
    }

    
    const statusInput = document.getElementById("status");
    const statusLabel = document.getElementById("statusLabel");
    statusLabel.textContent = statusInput.checked ? "Activo" : "Inactivo";
    statusInput.addEventListener("change", () => {
        statusLabel.textContent = statusInput.checked ? "Activo" : "Inactivo";
    });

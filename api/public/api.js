document.addEventListener("DOMContentLoaded", () => {
  const API_URL = "../api.php";
  const PRODUCTS_API = "../apiProductos.php";

  const tbody = document.getElementById("usuarios-body");
  const editarForm = document.getElementById("editar-form");
  const editarModalEl = document.getElementById("editarModal");

  const addForm = document.getElementById("add-form");
  const addModal = document.getElementById("modalAddUser");

  const productosTbody = document.getElementById("productos-body");

  function cargarUsuarios() {
    fetch(API_URL)
      .then(res => res.json())
      .then(json => {
        tbody.innerHTML = "";
        if (json && json.estado === "Exito" && Array.isArray(json.data)) {
          json.data.forEach(u => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
              <td>${u.id_usuario}</td>
              <td>${u.nombre}</td>
              <td>${u.email}</td>
              <td>
                <button class="btn btn-sm btn-outline-primary btn-editar" data-id="${u.id_usuario}">Editar</button>
                <button class="btn btn-sm btn-outline-danger btn-eliminar" data-id="${u.id_usuario}">Eliminar</button>
              </td>
            `;
            tbody.appendChild(tr);
          });

          document.querySelectorAll(".btn-editar").forEach(btn => {
            btn.addEventListener("click", () => editarUsuario(btn.dataset.id));
          });

          document.querySelectorAll(".btn-eliminar").forEach(btn => {
            btn.addEventListener("click", () => eliminarUsuario(btn.dataset.id));
          });

        } else {
          tbody.innerHTML =
            `<tr><td colspan="4" class="text-muted">No se encontraron usuarios.</td></tr>`;
        }
      })
      .catch(() => {
        tbody.innerHTML =
          `<tr><td colspan="4" class="text-danger">Error cargando usuarios</td></tr>`;
      });
  }
  function editarUsuario(id) {
    fetch(API_URL + "?id=" + id)
      .then(res => res.json())
      .then(json => {
        if (json && json.estado === "Exito") {
          document.getElementById("edit-id").value = json.data.id_usuario;
          document.getElementById("edit-nombre").value = json.data.nombre;
          document.getElementById("edit-email").value = json.data.email;
          document.getElementById("edit-password").value = "";

          const modal = new bootstrap.Modal(editarModalEl);
          modal.show();
        } else {
          alert("Usuario no encontrado");
        }
      })
      .catch(() => alert("Error al obtener usuario"));
  }



  //Eliminar Usr:


  function eliminarUsuario(id_usuario) {
    if (!confirm("¿Seguro que deseas eliminar este usuario?")) return;

    fetch(API_URL, {
      method: "DELETE",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id_usuario }),
    })
      .then(res => res.json())
      .then(json => {
        if (json.estado === "Exito") {
          alert("Usuario eliminado correctamente");
          cargarUsuarios();
        } else {
          alert("Error al eliminar usuario");
        }
      })
      .catch(() => alert("Error al eliminar usuario"));
  }

  if (addForm) {
    addForm.addEventListener("submit", e => {
      e.preventDefault();

      const nombre = document.getElementById("add-nombre").value;
      const email = document.getElementById("add-email").value;
      const password = document.getElementById("add-password").value;

      fetch(API_URL, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ nombre, email, password }),
      })
        .then(res => res.json())
        .then(json => {
          if (json.estado === "Exito") {
            alert("Usuario añadido correctamente");

            const modal = bootstrap.Modal.getInstance(addModal);
            modal.hide();

            addForm.reset();
            cargarUsuarios();
          } else {
            alert("Error al añadir usuario");
          }
        })
        .catch(() => alert("Error al añadir usuario"));
    });
  }

  if (editarForm) {
    editarForm.addEventListener("submit", e => {
      e.preventDefault();

      const id_usuario = document.getElementById("edit-id").value;
      const nombre = document.getElementById("edit-nombre").value;
      const email = document.getElementById("edit-email").value;
      const password = document.getElementById("edit-password").value;

      fetch(API_URL, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id_usuario, nombre, email, password }),
      })
        .then(res => res.json())
        .then(json => {
          if (json.estado === "Exito") {
            const modal = bootstrap.Modal.getInstance(editarModalEl);
            modal.hide();

            alert("Usuario actualizado correctamente");
            cargarUsuarios();
          } else {
            alert("Error al actualizar usuario");
          }
        })
        .catch(() => alert("Error al actualizar usuario"));
    });
  }
  

function eliminarProducto(id_producto) {
    if (!confirm("¿Seguro que deseas eliminar este Producto?")) return;

    fetch(PRODUCTS_API, {
      method: "DELETE",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id_producto }),
    })
      .then(res => res.json())
      .then(json => {
        if (json.estado === "Exito") {
          alert("Producto eliminado correctamente");
          cargarProductos();
        } else {
          alert("Error al eliminar Producto");
        }
      })
      .catch(() => alert("Error al eliminar Producto"));
  }



  function cargarProductos() {
    if (!productosTbody) return;

    fetch(PRODUCTS_API)
      .then(res => res.json())
      .then(json => {
        productosTbody.innerHTML = "";

        if (json.estado === "Exito") {
          json.data.forEach(p => {
            
            const tr = document.createElement("tr");
            tr.innerHTML = `
              <td>${p.imagen_url ? `<img src="/Modelo-Vista-Controlador/${p.imagen_url}" width="180" alt="${p.nombre}">` : ''}</td>
              <td>${p.id_producto}</td>
              <td>${p.nombre}</td>
              <td>${p.descripcion}</td>
              <td>${p.precio} €</td>
              <td>${p.categoria}</td>
              <td>
                <button class="btn btn-sm btn-outline-primary btn-editar" data-id="${p.id_producto}">Editar</button>
                <button class="btn btn-sm btn-outline-danger btn-eliminar" data-id="${p.id_producto}">Eliminar</button>
              </td>
            `;
            productosTbody.appendChild(tr);
          });
           document.querySelectorAll(".btn-editar").forEach(btn => {
            btn.addEventListener("click", () => editarProductos(btn.dataset.id));
          });

          document.querySelectorAll(".btn-eliminar").forEach(btn => {
            btn.addEventListener("click", () => eliminarProducto(btn.dataset.id));
          });

        } else {
          tbody.innerHTML =
            `<tr><td colspan="4" class="text-muted">No se encontraron Productos.</td></tr>`;
        }
      })
      .catch(err => console.error("Error productos:", err));
    }
cargarUsuarios();
cargarProductos();
});

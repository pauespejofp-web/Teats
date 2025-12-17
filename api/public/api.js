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



  //Eliminar:


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
  

// function eliminarProducto(id_usuario) {
//     if (!confirm("¿Seguro que deseas eliminar este usuario?")) return;

//     fetch(API_URL, {
//       method: "DELETE",
//       headers: { "Content-Type": "application/json" },
//       body: JSON.stringify({ id_usuario }),
//     })
//       .then(res => res.json())
//       .then(json => {
//         if (json.estado === "Exito") {
//           alert("Usuario eliminado correctamente");
//           cargarUsuarios();
//         } else {
//           alert("Error al eliminar usuario");
//         }
//       })
//       .catch(() => alert("Error al eliminar usuario"));
//   }





  // función para cargar productos
//   function cargarProductos() {
//     if (!productosTbody) return;
//     fetch(PRODUCTS_API)
//       .then(res => res.json())
//       .then(json => {
//         productosTbody.innerHTML = "";
//         if (json && json.estado === "Exito" && Array.isArray(json.data)) {
//           json.data.forEach(p => {
//             const tr = document.createElement("tr");
//             tr.innerHTML = `
//               <td>${p.id_producto}</td>
//               <td>${escapeHtml(p.nombre)}</td>
//               <td>${Number(p.precio).toFixed(2)} €</td>
//               <td>${p.disponible == 1 ? 'Sí' : 'No'}</td>
//               <td>
//                 <button class="btn btn-sm btn-outline-primary" onclick="window.location.href='/Modelo-Vista-Controlador/index.php?controller=productos&action=editar&id=${p.id_producto}'">Editar</button>
//                 <button class="btn btn-sm btn-outline-danger" onclick="if(confirm('Eliminar producto?')) window.location.href='/Modelo-Vista-Controlador/index.php?controller=productos&action=eliminar&id=${p.id_producto}'">Eliminar</button>
//               </td>
//             `;
//             productosTbody.appendChild(tr);
//           });
//         } else {
//           productosTbody.innerHTML = `<tr><td colspan="5" class="text-muted">No se encontraron productos.</td></tr>`;
//         }
//       })
//       .catch(err => {
//         console.error('Error cargando productos error', err);
//         if (productosTbody) productosTbody.innerHTML = `<tr><td colspan="5" class="text-danger">Error cargando productoss</td></tr>`;
//       });
//   }

//   // llamar cargarProductos al inicio (opcional) y cuando se pulsa el botón Productos del menú
//   window.cargarProductos = cargarProductos;
//   cargarProductos();

//   // detectar clicks en el menú para recargar productos cuando se activa la sección productos
//   document.querySelectorAll('.menu-btn').forEach(btn => {
//     btn.addEventListener('click', () => {
//       if (btn.dataset.target === 'sec-productos') {
//         cargarProductos();
//       }
//     });
//   });

//   cargarUsuarios();
// });

// function escapeHtml(html) {
//   const text = document.createElement('textarea');
//   text.innerHTML = html;
//   return text.value;
// }
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
              <td>${p.id_producto}</td>
              <td>${p.nombre}</td>
              <td>${p.descripcion}</td>
              <td>${p.precio} €</td>
              <td>${p.categoria}</td>
              <td><img src="${p.imagen_url}" width="50"></td>
              <td>
                <button class="btn btn-sm btn-primary">Editar</button>
                <button class="btn btn-sm btn-danger">Eliminar</button>
              </td>
            `;
            productosTbody.appendChild(tr);
          });
        }
      })
      .catch(err => console.error("Error productos:", err));
  }
cargarUsuarios();
cargarProductos();
});


document.addEventListener("DOMContentLoaded", () => {
  const API_URL = "../api.php";
  const PRODUCTS_API = "../apiProductos.php";
  const PEDIDOS_API = "../apiPedidos.php";

  const tbody = document.getElementById("usuarios-body");
  const editarForm = document.getElementById("editar-form");
  const editarModalEl = document.getElementById("editarModal");

  const addForm = document.getElementById("add-form");
  const addModal = document.getElementById("modalAddUser");

  const productosTbody = document.getElementById("productos-body");
  const pedidosTbody = document.getElementById("pedidos-body");

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
  

  function cargarProductos() {
   

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
    
    // PEDIDOS CRUD
  function cargarPedidos() {
    if (!pedidosTbody) return;
    fetch(PEDIDOS_API)
      .then(res => res.json())
      .then(json => {
        pedidosTbody.innerHTML = "";
        if (json && json.estado === "Exito" && Array.isArray(json.data)) {
          json.data.forEach(p => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
              <td>${p.id_pedido}</td>
              <td>${p.id_usuario}</td>
              <td>${p.fecha_pedido}</td>
              <td>${p.hora_pedido}</td>
              <td>${p.importe} €</td>
              <td>${p.estado}</td>
              <td>
                <button class="btn btn-sm btn-outline-primary btn-editar-ped" data-id="${p.id_pedido}">Editar</button>
                <button class="btn btn-sm btn-outline-danger btn-eliminar-ped" data-id="${p.id_pedido}">Eliminar</button>
              </td>
            `;
            pedidosTbody.appendChild(tr);
          });
          pedidosTbody.querySelectorAll(".btn-editar-ped").forEach(btn => {
            btn.addEventListener("click", () => editarPedido(btn.dataset.id));
          });
          pedidosTbody.querySelectorAll(".btn-eliminar-ped").forEach(btn => {
            btn.addEventListener("click", () => eliminarPedido(btn.dataset.id));
          });
        } else {
          pedidosTbody.innerHTML = `<tr><td colspan="7" class="text-muted">No se encontraron pedidos.</td></tr>`;
        }
      })
      .catch(() => {
        pedidosTbody.innerHTML = `<tr><td colspan="7" class="text-danger">Error cargando pedidos</td></tr>`;
      });
  }

  function editarPedido(id) {
    fetch(PEDIDOS_API + "?id=" + id)
      .then(res => res.json())
      .then(json => {
        if (json && json.estado === "Exito") {
          document.getElementById("edit-ped-id").value = json.data.id_pedido;
          document.getElementById("edit-ped-usuario").value = json.data.id_usuario;
          document.getElementById("edit-ped-fecha").value = json.data.fecha_pedido;
          document.getElementById("edit-ped-hora").value = json.data.hora_pedido;
          document.getElementById("edit-ped-importe").value = json.data.importe;
          document.getElementById("edit-ped-estado").value = json.data.estado;
          const modal = new bootstrap.Modal(document.getElementById("editarPedidoModal"));
          modal.show();
        } else {
          alert("Pedido no encontrado");
        }
      })
      .catch(() => alert("Error al obtener pedido"));
  }

  function eliminarPedido(id_pedido) {
    if (!confirm("¿Seguro que deseas eliminar este pedido?")) return;
    fetch(PEDIDOS_API, {
      method: "DELETE",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id_pedido }),
    })
      .then(res => res.json())
      .then(json => {
        if (json.estado === "Exito") {
          alert("Pedido eliminado correctamente");
          cargarPedidos();
        } else {
          alert("Error al eliminar pedido");
        }
      })
      .catch(() => alert("Error al eliminar pedido"));
  }

  const editarPedidoForm = document.getElementById("editar-pedido-form");
  if (editarPedidoForm) {
    editarPedidoForm.addEventListener("submit", e => {
      e.preventDefault();
      const id_pedido = document.getElementById("edit-ped-id").value;
      const id_usuario = document.getElementById("edit-ped-usuario").value;
      const fecha_pedido = document.getElementById("edit-ped-fecha").value;
      const hora_pedido = document.getElementById("edit-ped-hora").value;
      const importe = document.getElementById("edit-ped-importe").value;
      const estado = document.getElementById("edit-ped-estado").value;

      fetch(PEDIDOS_API, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id_pedido, id_usuario, fecha_pedido, hora_pedido, importe, estado }),
      })
        .then(res => res.json())
        .then(json => {
          if (json.estado === "Exito") {
            const modal = bootstrap.Modal.getInstance(document.getElementById("editarPedidoModal"));
            modal.hide();
            alert("Pedido actualizado correctamente");
            cargarPedidos();
          } else {
            alert("Error al actualizar pedido");
          }
        })
        .catch(() => alert("Error al actualizar pedido"));
    });
  }
  
cargarUsuarios();
cargarProductos();
cargarPedidos();
});

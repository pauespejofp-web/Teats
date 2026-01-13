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

  const filterUser = document.getElementById("filter-user");
  const filterDateStart = document.getElementById("filter-date-start");
  const filterDateEnd = document.getElementById("filter-date-end");
  const filterEstado = document.getElementById("filter-estado");
  const filterOrder = document.getElementById("filter-order");


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
          tbody.innerHTML = `<tr><td colspan="4" class="text-muted">No se encontraron usuarios.</td></tr>`;
        }
      })
      .catch(() => {
        tbody.innerHTML = `<tr><td colspan="4" class="text-danger">Error cargando usuarios</td></tr>`;
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
        } else alert("Usuario no encontrado");
      })
      .catch(() => alert("Error al obtener usuario"));
  }

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
        } else alert("Error al eliminar usuario");
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
            bootstrap.Modal.getInstance(addModal).hide();
            addForm.reset();
            cargarUsuarios();
          } else alert("Error al añadir usuario");
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
            bootstrap.Modal.getInstance(editarModalEl).hide();
            alert("Usuario actualizado correctamente");
            cargarUsuarios();
          } else alert("Error al actualizar usuario");
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
              <td>${p.imagen_url ? `<img src="/Modelo-Vista-Controlador/${p.imagen_url}" width="180">` : ""}</td>
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
          productosTbody.querySelectorAll(".btn-editar").forEach(btn => {
            btn.addEventListener("click", () => editarProducto(btn.dataset.id));
          });
          productosTbody.querySelectorAll(".btn-eliminar").forEach(btn => {
            btn.addEventListener("click", () => eliminarProducto(btn.dataset.id));
          });
        } else productosTbody.innerHTML = `<tr><td colspan="7" class="text-muted">No se encontraron Productos.</td></tr>`;
      })
      .catch(err => console.error("Error productos:", err));
  }

  function editarProducto(id) {
    fetch(PRODUCTS_API + "?id=" + id)
      .then(res => res.json())
      .then(json => {
        if (json && json.estado === "Exito") {
          const p = json.data;
          document.getElementById("edit-prod-id").value = p.id_producto;
          document.getElementById("edit-prod-nombre").value = p.nombre || "";
          document.getElementById("edit-prod-precio").value = p.precio || "";
          document.getElementById("edit-prod-descripcion").value = p.descripcion || "";
          document.getElementById("edit-prod-categoria").value = p.categoria || "";
          document.getElementById("edit-prod-imagen").value = p.imagen_url || "";
          const modalEl = document.getElementById("editarProductoModal");
          const modal = new bootstrap.Modal(modalEl);
          modal.show();
        } else alert("Producto no encontrado");
      })
      .catch(() => alert("Error al obtener producto"));
  }

  function eliminarProducto(id_producto) {
    if (!confirm("¿Seguro que deseas eliminar este producto?")) return;
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
        } else alert("Error al eliminar producto");
      })
      .catch(() => alert("Error al eliminar producto"));
  }

  const editarProductoForm = document.getElementById("editar-producto-form");
  if (editarProductoForm) {
    editarProductoForm.addEventListener("submit", e => {
      e.preventDefault();
      const id_producto = document.getElementById("edit-prod-id").value;
      const nombre = document.getElementById("edit-prod-nombre").value;
      const precio = document.getElementById("edit-prod-precio").value;
      const descripcion = document.getElementById("edit-prod-descripcion").value;
      const categoria = document.getElementById("edit-prod-categoria").value;
      const imagen_url = document.getElementById("edit-prod-imagen").value;

      fetch(PRODUCTS_API, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id_producto, nombre, descripcion, precio, categoria, imagen_url }),
      })
        .then(res => res.json())
        .then(json => {
          if (json.estado === "Exito") {
            const modalEl = document.getElementById("editarProductoModal");
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();
            alert("Producto actualizado correctamente");
            cargarProductos();
          } else alert("Error al actualizar producto");
        })
        .catch(() => alert("Error al actualizar producto"));
    });
  }
    let pedidosData = [];

  function applyPedidoFilters() {

    
    if (!pedidosData) return;
    let filtered = [...pedidosData];

    //?.value es usado para evitar errores si lo del filtro no existe
    const userId = parseInt(filterUser?.value);
    const dateStart = filterDateStart?.value;
    const dateEnd = filterDateEnd?.value;
    const estado = filterEstado?.value.trim().toLowerCase();
    const order = filterOrder?.value;

    if (!isNaN(userId)) filtered = filtered.filter(p => p.id_usuario === userId);
    if (dateStart) filtered = filtered.filter(p => p.fecha_pedido >= dateStart);
    if (dateEnd) filtered = filtered.filter(p => p.fecha_pedido <= dateEnd);
    if (estado) filtered = filtered.filter(p => p.estado.toLowerCase() === estado);

    if (order === "asc") filtered.sort((a, b) => parseFloat(a.importe) - parseFloat(b.importe));
    if (order === "desc") filtered.sort((a, b) => parseFloat(b.importe) - parseFloat(a.importe));

    pedidosTbody.innerHTML = "";
    if (filtered.length === 0) {
      pedidosTbody.innerHTML = `<tr><td colspan="7" class="text-center text-muted">No hay pedidos</td></tr>`;
      return;
    }

    filtered.forEach(p => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${p.id_pedido}</td>
        <td>${p.id_usuario}</td>
        <td>${p.fecha_pedido}</td>
        <td>${p.hora_pedido}</td>
        <td>${parseFloat(p.importe).toFixed(2)} €</td>
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
  }


  function editarPedido(id) {
    fetch(PEDIDOS_API + "?id=" + id)
      .then(res => res.json())
      .then(json => {
        if (json && json.estado === "Exito") {
          const p = json.data;
          //Rellena los campos del formulario de edición con los datos del pedido:
          document.getElementById("edit-ped-id").value = p.id_pedido;
          document.getElementById("edit-ped-usuario").value = p.id_usuario || "";
          document.getElementById("edit-ped-fecha").value = p.fecha_pedido || "";
          document.getElementById("edit-ped-hora").value = p.hora_pedido || "";
          document.getElementById("edit-ped-importe").value = p.importe || "";
          document.getElementById("edit-ped-estado").value = p.estado || "";
          const modalEl = document.getElementById("editarPedidoModal");
          const modal = new bootstrap.Modal(modalEl);
          modal.show();
        } else alert("Pedido no encontrado");
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
        } else alert("Error al eliminar pedido");
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
            const modalEl = document.getElementById("editarPedidoModal");
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();
            alert("Pedido actualizado correctamente");
            cargarPedidos();
          } else alert("Error al actualizar pedido");
        })
        .catch(() => alert("Error al actualizar pedido"));
    });
  }

  function cargarPedidos() {
    if (!pedidosTbody) return;
    fetch(PEDIDOS_API)
      .then(res => res.json())
      .then(json => {
        if (json && json.estado === "Exito" && Array.isArray(json.data)) {
          pedidosData = json.data;
          applyPedidoFilters();
        } else pedidosTbody.innerHTML = `<tr><td colspan="7" class="text-muted">No se encontraron pedidos</td></tr>`;
      })
      .catch(() => {
        pedidosTbody.innerHTML = `<tr><td colspan="7" class="text-danger">Error cargando pedidos</td></tr>`;
      });
  }

  [filterUser, filterDateStart, filterDateEnd, filterEstado, filterOrder].forEach(el => {
    el?.addEventListener("input", applyPedidoFilters);
  });

  cargarUsuarios();
  cargarProductos();
  cargarPedidos();
});

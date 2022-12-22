let paso=1;const pasoIni=1,pasoFin=3,cita={id:"",nombre:"",fecha:"",hora:"",servicios:[]};function iniciarApp(){mostrarSeccion(),tabs(),botonesPaginador(),paginaSiguiente(),paginaAnterior(),consultarAPI(),nombreCliente(),idCliente(),seleccionaFecha(),seleccionaHora(),mostrarResumen()}function mostrarSeccion(){const e=document.querySelector(".mostrar");e&&e.classList.remove("mostrar");document.querySelector("#paso-"+paso).classList.add("mostrar");const t=document.querySelector(".actual");t&&t.classList.remove("actual");document.querySelector(`[data-paso="${paso}"]`).classList.add("actual")}function tabs(){document.querySelectorAll(".tabs button").forEach(e=>{e.addEventListener("click",(function(e){paso=parseInt(e.target.dataset.paso),mostrarSeccion(),botonesPaginador()}))})}function botonesPaginador(){const e=document.querySelector("#siguiente"),t=document.querySelector("#anterior");1===paso?(t.classList.add("ocultar"),e.classList.remove("ocultar")):3===paso?(t.classList.remove("ocultar"),e.classList.add("ocultar"),mostrarResumen()):2===paso&&(t.classList.remove("ocultar"),e.classList.remove("ocultar")),mostrarSeccion()}function paginaAnterior(){document.querySelector("#anterior").addEventListener("click",(function(){paso<=1||(paso--,botonesPaginador())}))}function paginaSiguiente(){document.querySelector("#siguiente").addEventListener("click",(function(){paso>=3||(paso++,botonesPaginador())}))}async function consultarAPI(){try{const e=window.location.origin+"/api/servicios";console.log(e);const t=await fetch(e);mostrarServicios(await t.json())}catch(e){console.log(e)}}function mostrarServicios(e){e.forEach(e=>{const{id:t,nombre:o,precio:a}=e,n=document.createElement("P");n.classList.add("nombre-servicio"),n.textContent=o;const c=document.createElement("P");c.classList.add("precio-servicio"),c.textContent="$ "+a;const r=document.createElement("DIV");r.classList.add("servicio"),r.dataset.idServicio=t,r.onclick=function(){seleccionarServico(e)},r.appendChild(n),r.appendChild(c),document.querySelector("#servicios").appendChild(r)})}function seleccionarServico(e){const{id:t}=e,{servicios:o}=cita,a=document.querySelector(`[data-id-servicio="${t}"]`);o.some(e=>e.id===t)?(cita.servicios=o.filter(e=>e.id!=t),a.classList.remove("seleccionado")):(cita.servicios=[...o,e],a.classList.add("seleccionado"))}function nombreCliente(){const e=document.querySelector("#nombre").value;cita.nombre=e}function idCliente(){const e=document.querySelector("#id").value;cita.id=e}function seleccionaFecha(){document.querySelector("#fecha").addEventListener("input",(function(e){const t=new Date(e.target.value).getUTCDay();[6,0].includes(t)?(e.target.value="",mostrarAlerta("Fines de semana no permitidos","error",".formulario")):cita.fecha=e.target.value}))}function seleccionaHora(){document.querySelector("#hora").addEventListener("input",(function(e){const t=e.target.value.split(":")[0];t<10||t>18?(e.target.value="",mostrarAlerta("Hora no valida","error",".formulario")):cita.hora=e.target.value}))}function mostrarAlerta(e,t,o,a=!0){const n=document.querySelector(".alerta");n&&n.remove();const c=document.createElement("DIV");c.textContent=e,c.classList.add("alerta"),c.classList.add(t);document.querySelector(o).appendChild(c),!0&&setTimeout(()=>{c.remove()},3e3)}function mostrarResumen(){const e=document.querySelector(".contenido-resumen");for(;e.firstChild;)e.removeChild(e.firstChild);if(Object.values(cita).includes("")||0===cita.servicios.length)return void mostrarAlerta("Faltan datos de Servicios,Fecha u Hora","error",".contenido-resumen",!1);const{nombre:t,fecha:o,hora:a,servicios:n}=cita,c=document.createElement("H3");c.textContent="Resumen de Servicios",e.appendChild(c),n.forEach(t=>{const{id:o,nombre:a,precio:n}=t,c=document.createElement("DIV");c.classList.add("contenedor-servicio");const r=document.createElement("P");r.textContent=a;const i=document.createElement("P");i.innerHTML="<span>Precio: $</span> "+n,c.appendChild(r),c.appendChild(i),e.appendChild(c)});document.createElement("H3").textContent="Resumen de Cita",e.appendChild(c);const r=document.createElement("P");r.innerHTML="<span>Nombre;</span> "+t;const i=new Date(o),s=i.getMonth(),d=i.getDate()+2,l=i.getFullYear(),u=new Date(Date.UTC(l,s,d)).toLocaleDateString("es-MX",{weekday:"long",year:"numeric",month:"long",day:"numeric"}),m=document.createElement("P");m.innerHTML="<span>Fecha:</span> "+u;const p=document.createElement("P");p.innerHTML=`<span>Hora:</span> ${a} Horas`;const v=document.createElement("BUTTON");v.classList.add("boton"),v.textContent="Reservar Cita",v.onclick=reservarCita,e.appendChild(r),e.appendChild(m),e.appendChild(p),e.appendChild(v)}async function reservarCita(){const{id:e,fecha:t,hora:o,servicios:a}=cita,n=a.map(e=>e.id),c=new FormData;c.append("fecha",t),c.append("hora",o),c.append("usuarioId",e),c.append("servicios",n);try{const e="http://localhost:3000/api/citas",t=await fetch(e,{method:"POST",body:c});(await t.json()).resultado&&Swal.fire({icon:"success",title:"Cita Creada",text:"Tu cita a sido creada",button:"OK"}).then(()=>{setTimeout(()=>{window.location.reload()},1e3)})}catch(e){Swal.fire({icon:"error",title:"Oops...",text:"Hubo un error al guardar la cita"})}}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));
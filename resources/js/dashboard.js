const board = document.getElementById("dashboard-cards");
const taskLists = document.querySelectorAll(".task-list");
const addCategoria = document.getElementById("addCategoria");
const dashboardCards = document.getElementById("dashboard-cards");
const btnSaveKanban = document.getElementById("saveKanban");
const loadingOverlay = document.getElementById("loading-overlay");
let request;

new Sortable(board, {
  animation: 180,
  handle: ".task-boards",
  ghostClass: "sortable-ghost",
  chosenClass: "sortable-chosen",
  dragClass: "sortable-drag",
  forceFallback: true,
  fallbackOnBody: true,

  onStart: () => {
    const placeholder = document.createElement("div");
    placeholder.className = "list-placeholder";
  },

  onEnd: (evt) => {},
});

taskLists.forEach((cardsEl) => {
  new Sortable(cardsEl, {
    group: "trello-cards",
    animation: 180,
    draggable: ".task",
    ghostClass: "sortable-ghost",
    chosenClass: "sortable-chosen",
    forceFallback: true,
    fallbackOnBody: true,

    onEnd: (evt) => {},
  });
});

document.addEventListener("dblclick", function (e) {
  if (e.target.classList.contains("task")) {
    changeFieldEditable(
      e.target,
      "form-control task w-full mb-2 p-2 rounded border",
      "div",
      "form-control task w-full mb-2 p-2 rounded border",
      "tarefa",
    );
  }

  if (e.target.classList.contains("card-title")) {
    changeFieldEditable(
      e.target,
      "input-title",
      "h5",
      "card-title fw-semibold py-2",
      "categoria",
    );
  }
});

const changeFieldEditable = (el, classInput, newElType, classNewEl, type) => {
  const taskDiv = el;
  const currentText = taskDiv.textContent.trim();
  const posElement = el.classList.contains("task")
    ? el.getAttribute("data-tarefa-pos")
    : el.getAttribute("data-categoria-pos");
  const idElement = el.classList.contains("task")
    ? el.getAttribute("data-tarefa-id")
    : el.getAttribute("data-categoria-id");

  const input = document.createElement("input");
  input.className = classInput;
  input.value = currentText;

  taskDiv.replaceWith(input);

  input.focus();
  input.select();

  const saveField = () => {
    const newEl = document.createElement(newElType);
    newEl.className = classNewEl;
    newEl.textContent = input.value.trim();

    if (type === "categoria") {
      newEl.setAttribute("data-categoria-pos", posElement);
      newEl.setAttribute("data-categoria-id", idElement);
    } else {
      newEl.setAttribute("data-tarefa-pos", posElement);
      newEl.setAttribute("data-tarefa-id", idElement);
    }

    input.replaceWith(newEl);
  };

  input.addEventListener("blur", saveField);

  input.addEventListener("keydown", function (event) {
    if (event.key === "Enter" && !event.shiftKey) {
      event.preventDefault();
      saveField();
    }
  });
};

addCategoria.addEventListener("click", function () {
  const dashboardCards = document.getElementById("dashboard-cards");

  const categoria = document.createElement("div");
  categoria.className = "card task-boards";
  categoria.style.minWidth = "18rem";
  const proxCategoriaPos = document.querySelectorAll(".card-title").length + 1;

  categoria.innerHTML = `
    <div class="card-body">
        <h5 class="card-title fw-semibold py-2"
            data-categoria-id=""
            data-data-categoria-pos="${proxCategoriaPos}">
        Digite um Título...
        </h5>

        <div class="task-list">
        <div class="task w-full mb-2 p-2 rounded border"
            data-tarefa-id=""
            data-data-tarefa-pos="1">
            Digite uma Tarefa...
        </div>
        </div>

        <div class="flex justify-content-center mt-2">
        <button class="btn btn-secondary btn-add-tarefa">Adicionar Tarefa +</button>
        </div>
    </div>
    `;

  dashboardCards.appendChild(categoria);
});

dashboardCards.addEventListener("click", function (e) {
  const btn = e.target.closest(".btn-add-tarefa");
  if (!btn) return;

  const cardBody = btn.closest(".card-body");
  const taskList = cardBody.querySelector(".task-list");
  if (!taskList) return;

  const proxTarefaPos = taskList.querySelectorAll(".task").length + 1;
  const task = document.createElement("div");
  task.className = "task w-full mb-2 p-2 rounded border";
  task.textContent = "Crie uma Tarefa...";
  task.setAttribute("data-tarefa-pos", proxTarefaPos);

  taskList.appendChild(task);
});

async function saveDashboardData() {
  const cards = document.querySelectorAll(".card");
  const categorias = [];

  cards.forEach((card, indexCat) => {
    const title = card.querySelector(".card-title");

    const categoriaId = title.dataset.categoriaId || null;

    const categoriaPos = indexCat + 1;

    title.dataset.categoriaPos = String(categoriaPos);

    const objCategoria = {
      id: categoriaId ? Number(categoriaId) : null,
      categoriaPos: categoriaPos,
      name: title.textContent.trim(),
      tarefas: [],
    };
    const tarefas = card.querySelectorAll(".task-list > .task");

    tarefas.forEach((task, indexTask) => {
      const tarefaId = task.dataset.tarefaId || null;
      const tarefaPos = indexTask + 1;

      task.dataset.tarefaPos = String(tarefaPos);

      const objTarefa = {
        id: tarefaId ? Number(tarefaId) : null,
        tarefaPos: tarefaPos,
        name: task.textContent.trim(),
      };

      objCategoria.tarefas.push(objTarefa);
    });

    categorias.push(objCategoria);
  });

  if (request) {
    request.abort();
  }

  request = new AbortController();

  try {
    showLoading();

    const res = await fetch("/salvar-kanban", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
          .content,
      },
      body: JSON.stringify(categorias),
      signal: request.signal,
    });

    hideLoading();

    if (!res.ok) {
      console.log(res.status);
      alert("ocorreu um erro, contacte o suporte");
      return;
    }
  } catch (error) {
    if (error.name !== "AbortError") {
      console.error(error);
    }
  }
}

btnSaveKanban.addEventListener("click", function (e) {
  saveDashboardData();
});

function showLoading() {
  loadingOverlay.classList.remove("d-none");
}

function hideLoading() {
  loadingOverlay.classList.add("d-none");
}

function sortTable(columnIndex) {
  var table = document.getElementById("participantsTable");
  var rows = table.getElementsByTagName("tr");
  var type;
  if (columnIndex === 0) {
    type = "number";
  } else if (columnIndex === 1) {
    type = "string";
  } else {
    type = "number";
  }
  sortRows(table, rows, columnIndex, type);
}

function sortRows(table, rows, columnIndex, type) { // Изменяем аргументы функции
 var sortDirection = getSortDirection(columnIndex);
 var sortedRows = Array.from(rows).slice(1); // не включаем строку с заголовками
 sortedRows.sort(function(rowA, rowB) {
    var cellA = rowA.getElementsByTagName("td")[columnIndex].innerText;
    var cellB = rowB.getElementsByTagName("td")[columnIndex].innerText;
    if (type === "number") {
      return sortDirection === "asc" ? Number(cellA) - Number(cellB) : Number(cellB) - Number(cellA);
    } else {
      return sortDirection === "asc" ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
    }
 });
 var tbody = table.getElementsByTagName("tbody")[0];
 tbody.innerHTML = "";
 sortedRows.forEach(function(row) {
    tbody.appendChild(row);
 });
}

function getSortDirection(columnIndex) {
 var table = document.getElementById("participantsTable");
 var sortedColumnIndex = table.getAttribute("data-sorted-column-index");
 if (sortedColumnIndex !== columnIndex.toString()) {
    table.setAttribute("data-sorted-column-index", columnIndex);
    table.setAttribute("data-sort-direction", sortDirection === "asc" ? "desc" : "asc");
    return "asc";
 } else {
    var sortDirection = table.getAttribute("data-sort-direction");
    table.setAttribute("data-sort-direction", sortDirection === "asc" ? "desc" : "asc");
    return sortDirection === "asc" ? "desc" : "asc";
 }
}

function showErrorModal(errorMessage) {
    $('#errorModalBody').html(errorMessage);
    $('#errorModal').modal('show');
}

function validateInput(input){
    var names = input.split(',');
    // проверяем каждое имя
    for (var i = 0; i < names.length; i++) {
        var name = names[i].trim();
        // проверяем, не пусто ли имя
        if (name === '') {
            return false;
        }
        // проверяем, состоят ли только из символов кирилицы и запятой
        var isValid = /^[а-яА-ЯёЁ,]+$/.test(name);

        if (!isValid) {
            return false;
        }
    }
    return true;
}

var currentId = 1;

function addNamesToTable() {
  var input = document.getElementById('participantsInput').value;
  var names = input.split(","); 
  var table = document.getElementById("participantsTable");
  var points;
  $.ajax({
        url: 'generate_score.php', 
        data: { length: names.length },
        success: function(response) {
            points = response;
        },
        dataType: 'json', 
        async: false 
  });
  for(var i = 0; i<names.length; i++){
    var name = names[i].trim(); 
    $('#participantsTableBody').append('<tr><td>' + currentId++ + '</td><td>' + name + '</td><td>'  + points[i] + '</td></tr>');
  }
}

$(document).ready(function () {
    document.getElementById("addButton").addEventListener("click", function() {
        var table = document.getElementById("participantsTable");
        var hasInvisibleClass = table.classList.contains("invisible");
        if (hasInvisibleClass) {
            var obj = document.getElementById("participantsTable");
            obj.className = obj.className.replace(/\binvisible\b/,'');
        }
        var input = document.getElementById('participantsInput').value;
        if (input.trim() === "") {
            showErrorModal("Пустой ввод. Введите список участников");
            return;
        }
        if(validateInput(input)){
            addNamesToTable();
            document.getElementById("participantsInput").value = "";
        }else{
            showErrorModal("Найден не подходящий символ. Доступны только символы кирилицы и запятая");
        }
    });
    window.addEventListener("keydown", function(e) {
        if(e.key === "Enter"){
            var button = document.getElementById("addButton");
            var isButtonInFocus = document.activeElement === button;
            if (!isButtonInFocus) {
                button.click();
            }
        }
    });
});

@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
    <link rel="icon" href="./exceIcon.png" type="favicon/ico" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script
      type="text/javascript"
      src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"
      defer
    >
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <title>Excel File Importer with Dynamic Table</title>
  </head>
  <body>

@section("content")
    <div class="container">
      <!-- <button id="btn_import" class="btn btn-primary">Import Excel</button> -->
      <input type="file" id="excel_file" style="display: none" />
      <table
        id="table_output"
        class=" table table-striped table-bordered table-sm"
        cellspacing="0"
      >
      <thead>
        <tr class="dataPerRow">
          <th id="wanted">ID</th>
          <th id="wanted">Item Code</th>
          <th id="wanted">Arabic Translation</th>
          <th id="wanted">English Translation</th>
          <th id="wanted">Username</th>
          <th style="width: 20%;">Action</th>
        </tr>
      </thead>
        <tbody id="table_body"></tbody>
      </table>
 
      <div id="EnglishDescription" class="modal"  tabindex="-1"  aria-hidden="true" >
        <div class="modal-dialog ">
          <div class="modal-content">
            <div class="modal-header">
            <h5
                class="modal-title"
                style="color: rgba(1, 86, 66); font-weight: bold"
              >Translation Description</h5>
            </div>
            <div class="modal-body" id="englishDescriptionContent">
            </div>
            <div class="modal-footer">
              <button id="closeButton" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div id="Alert!" class="modal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content" style="height: 48vh">
            <div class="modal-header">
              <h5
                class="modal-title"
                style="color: rgba(1, 86, 66); font-weight: bold"
              >
                Alert!
              </h5>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
              <button
                id="closeButtonAlert"
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                Close
              </button>
            </div>
          </div>
        </div>
      </div>
      <div id="pagination" class="pagination">
        <!-- Pagination buttons will be inserted here -->
      </div>
  </div>
</div>
<script>
  let display = [];
  const itemsPerPage = 5;
  let currentPage = 1;
 
  function displayTableRows() {
    const tableBody = document.getElementById('table_body');
    tableBody.innerHTML = '';
 
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const displayedItems = display.slice(startIndex, endIndex);
 
    displayedItems.forEach(item => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td id="wanted_id">${item.id}</td>
        <td id="wanted_item_code">${item.item_code}</td>
        <td id="wanted_arabic_translation">${item.arabic_translation}</td>
        <td id="wanted_english_translation"><textarea class="form-control" rows="8" cols="120" disabled style=resize:none>${item.english_translation}</textarea></td>
        <td id="wanted_username">${item.username}</td>
        <td>
          <button class="btn btn-success" onclick="handleEditButtonClick(this.parentNode.parentNode)">Edit</button>
          <button class="btn btn-primary" onclick="handleSaveButtonClick(this.parentNode.parentNode)">Save</button>
          <button class="btn btn-primary" onclick="viewDescription(this.parentNode.parentNode)">View</button>
        </td>
      `;
      tableBody.appendChild(row);
    });
  }
 
  function handleEditButtonClick(row) {
  const textareas = row.querySelectorAll("textarea");
  textareas.forEach((textarea) => {
    textarea.disabled = false;
    textarea.style.color = "black";
    textarea.style.background = "white";
  });
}
 
  function handleSaveButtonClick(row) {
    console.log(row);
    row.style.backgroundColor = "lightgray";
    const textarea = row.querySelector("textarea");
    textarea.disabled = true;
    textarea.style.background = "lightgray";
    alert("Saved Successfully");
    const ID = row.querySelector("#wanted_id").innerText;
    console.log("Item ID is: "+ ID);
    const itemId = ID;
    const updatedText = textarea.value;
    console.log("Updated Text is "+ updatedText);
    updateDatabaseText(itemId, updatedText);
    const editButton = row.querySelector(".btn-success");
    const saveButton = row.querySelector(".btn-primary");
    editButton.disabled = true;
    saveButton.disabled = true;
  }
 
  function viewDescription(row) {
    const englishDescription = row.cells[3].querySelector("textarea").value;
    const arabicDescription = row.cells[2].textContent;
    const itemCode = row.cells[1].textContent;
    displayTranslationDescription(itemCode,englishDescription, arabicDescription);
  }
 
  function displayTranslationDescription(itemCode,englishDescription, arabicDescription) {
    const modal = document.getElementById("EnglishDescription");
    const modalBody = modal.querySelector(".modal-body");
 
    modalBody.innerHTML = `
  <p><strong style="color:rgba(1, 86, 66)">Item Code:</strong><p style="border:2px solid rgba(229, 231, 235);border-radius:15px;padding:20px;background-color:rgba(234, 245, 220);">${itemCode}</p></p>
  <p><strong style="color:rgba(1, 86, 66)">English Description:</strong> <p style="border:2px solid rgba(229, 231, 235);border-radius:15px;padding:20px;background-color:rgba(234, 245, 220);" >${englishDescription}</p></p>
  <p><strong style="color:rgba(1, 86, 66)">Arabic Description:</strong> <p style="border:2px solid rgba(229, 231, 235);border-radius:15px;padding:20px;background-color:rgba(234, 245, 220)" >${arabicDescription}</p></p>
`;
    modal.classList.add("show");
    modal.style.display = "block";
 
    const closeButton = document.querySelector("#closeButton");
    closeButton.addEventListener("click", function () {
      modal.classList.remove("show");
      modal.style.display = "none";
    });
}
 
  function updatePagination() {
    const pagination = document.getElementById("pagination");
  pagination.innerHTML = '';
  const totalPages = Math.ceil(display.length / itemsPerPage);
  for (let i = 1; i <= totalPages; i++) {
    const li = document.createElement("li");
    li.classList.add("page-item");
    const link = document.createElement("a");
    link.classList.add("page-link");
    link.textContent = i;
    link.href = "#";
    link.addEventListener("click", function() {
      currentPage = i;
      displayTableRows();
      updatePagination();
    });
    li.appendChild(link);
    pagination.appendChild(li);
  }
  }
  document.addEventListener("DOMContentLoaded", function() {
    fetch('http://localhost:8000/api/translation')
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        display = data.data;
        displayTableRows();
        updatePagination();
      })
      .catch(error => console.error('Error fetching data:', error));
  });

</script>
<button style=" margin:10px 80px 0px" id="exportButton" class="btn btn-primary">Export as CSV</button>
@endsection
</body>
</html>
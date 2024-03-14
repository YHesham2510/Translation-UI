// const tableBody = document.getElementById("table_body");
// const pageSize = 1; // Number of rows per page
// let currentPage = 1;
 
// // function createCell(cellData, j, rowData) {
// //   const cell = document.createElement("td");
 
// //   if (j === 1) {
// //     // English Description column
// //     const englishDescription = cellData;
// //     const descriptionInput = createTextArea(englishDescription);
// //     descriptionInput.addEventListener("blur", function () {
// //       const newEnglishDescription = this.value;
// //       rowData[j] = newEnglishDescription;
// //     });
 
// //     cell.appendChild(descriptionInput);
// //   } else {
// //     cell.textContent = cellData;
// //   }
 
// //   return cell;
// // }
 
// // function createTextArea(englishDescription) {
// //   const descriptionInput = document.createElement("textarea");
// //   descriptionInput.type = "text";
// //   descriptionInput.value = englishDescription;
// //   descriptionInput.classList.add("editable-input", "form-control");
// //   descriptionInput.style.width = "300px"; // Set width
// //   descriptionInput.style.height = "200px"; // Set height
// //   descriptionInput.style.resize = "none"; // Disable resize
// //   return descriptionInput;
// // }
 
// // function createButtons(rowData, row) {
// //   const actionCell = document.createElement("td");
// //   const viewButton = createButton("View");
// //   viewButton.addEventListener("click", function () {
// //     const englishDescription = rowData[1];
// //     displayEnglishDescription(englishDescription);
// //   });
 
// //   const saveButton = createButton("Save");
// //   saveButton.addEventListener("click", function () {
// //     const textarea = row.querySelector("textarea");
// //     textarea.style.color = "black";
// //     textarea.style.backgroundColor = "lightgreen";
// //     textarea.disabled = true;
// //   });
 
// //   const editButton = createButton("Edit");
// //   editButton.addEventListener("click", function () {
// //     const textarea = row.querySelector("textarea");
// //     textarea.disabled = false;
// //     textarea.style.color = "black";
// //     textarea.style.backgroundColor = "white";
// //     textarea.focus();
// //   });
 
// //   actionCell.appendChild(viewButton);
// //   actionCell.appendChild(editButton);
// //   actionCell.appendChild(saveButton);
 
// //   return actionCell;
// // }
 
// // function createButton(text) {
// //   const button = document.createElement("button");
// //   button.textContent = text;
// //   button.classList.add("btn", "btn-primary", "btn-sm");
// //   button.style.marginRight = "5px";
 
// //   return button;
// // }
 
// function showPage(page) {
//   tableBody.innerHTML = "";
//   const start = (page - 1) * pageSize + 1;
//   const end = Math.min(start + pageSize - 1, data.length - 1);
 
//   for (let i = start; i <= end; i++) {
//     const rowData = data[i];
//     const row = document.createElement("tr");
 
//     for (let j = 0; j < rowData.length + 1; j++) {
//       const cellData = rowData[j];
//       const cell = createCell(cellData, j, rowData);
//       row.appendChild(cell);
//     }
 
//     const actionCell = createButtons(rowData, row);
//     row.appendChild(actionCell);
//     tableBody.appendChild(row);
//   }
//   function updatePagination() {
//     const pagination = document.getElementById("pagination");
//     pagination.innerHTML = "";
 
//     const pageCount = Math.ceil((data.length - 1) / pageSize);
 
//     for (let i = 1; i <= pageCount; i++) {
//       const li = document.createElement("li");
//       li.classList.add("page-item");
//       const link = document.createElement("a");
//       link.classList.add("page-link");
//       link.href = "#";
//       link.textContent = i;
//       link.addEventListener("click", function () {
//         currentPage = i;
//         showPage(currentPage);
//         updatePagination();
//       });
//       li.appendChild(link);
//       pagination.appendChild(li);
//     }
//   }
 
//   showPage(currentPage);
//   updatePagination();
// }
 
function displayEnglishDescription(englishDescription) {
    const modal = document.getElementById("EnglishDescription");
    const modalTitle = modal.querySelector(".modal-title");
    const modalBody = modal.querySelector(".modal-body");
   
    modalTitle.textContent = "English Description";
    modalBody.textContent = englishDescription;
   
    modal.classList.add("show");
    modal.style.display = "block";
   
    const closeButton = document.querySelector("#closeButton");
    closeButton.addEventListener("click", function () {
      modal.classList.remove("show");
      modal.style.display = "none";
    });
  }
   
  document.addEventListener("DOMContentLoaded", function () {
    document
      .getElementById("exportButton")
      .addEventListener("click", function () {
        exportToCsv("translate_users.csv");
      });
   
    function exportToCsv(filename) {
      
      const table = document.getElementById("table_output");
      const header = ["ID", "Item Code", "Arabic Translation", "English Translation", "Username"];
      const rows = [header];
   
      for (const row of table.getElementsByTagName('tbody')[0].getElementsByTagName('tr')) {
        const rowData = [];
        
        // Fetch specific data using getElementById or any other method you prefer
        const id = row.querySelector('#wanted_id').textContent.trim();
        const itemCode = row.querySelector('#wanted_item_code').textContent.trim();
        const arabicTranslation = row.querySelector('#wanted_arabic_translation').textContent.trim();
        const englishTranslation = row.querySelector('#wanted_english_translation').textContent.trim();
        const username = row.querySelector('#wanted_username').textContent.trim();
        rowData.push(id, itemCode, arabicTranslation, englishTranslation, username);
        
        rows.push(rowData);
    }
  
      const csvContent = Papa.unparse(rows, { encoding: "UTF-8" });
      const blob = new Blob([String.fromCharCode(0xFEFF), csvContent], { type: 'text/csv;charset=utf-8;' });
      const link = document.createElement("a");
      if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute("href", url);
        link.setAttribute("download", filename);
        link.style.visibility = "hidden";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      }
    }
  });
  
  function updateDatabaseText(itemId, updatedText, updatedBooleanValue) {
    let url = `http://localhost:8000/api/update-text/${itemId}`; 
    console.log("itemID: " + itemId);
    console.log(updatedBooleanValue)
    let data = { text: updatedText, booleanValue: updatedBooleanValue };
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify(data),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Database updated successfully:', data);
    })
    .catch(error => {
        console.error('Error updating database:', error);
    });
  }
   
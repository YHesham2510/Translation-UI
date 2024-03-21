const itemsPerPage = 5;
let currentPage = 1;

function displayTableRows() {
    const tableBody = document.getElementById("table_body");
    tableBody.innerHTML = "";

    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const displayedItems = display.slice(startIndex, endIndex);

    displayedItems.forEach((item) => {
        const row = document.createElement("tr");
        // console.log(item.is_updated==1);
        if (item.is_updated == 1) {
            row.classList.add("table-secondary");
            // console.log(row.classList);
            row.innerHTML = `
          <td id="wanted_id">${item.id}</td>
          <td id="wanted_item_code">${item.item_code}</td>
          <td id="wanted_arabic_translation"><textarea class="table-secondary form-control" rows="8" cols="120" disabled style=resize:none>${item.arabic_translation}</textarea></td>
          <td id="wanted_english_translation"><textarea class="table-secondary form-control" rows="8" cols="120" disabled style=resize:none>${item.english_translation}</textarea></td>
          <td id="wanted_username">${item.username}</td>
          <td>
            <button class="btn btn-success" disabled onclick="handleEditButtonClick(this.parentNode.parentNode)">Edit</button>
            <button class="btn btn-primary" disabled onclick="handleSaveButtonClick(this.parentNode.parentNode)">Save</button>
            <button class="btn btn-primary" onclick="viewDescription(this.parentNode.parentNode)">View</button>
          </td>
        `;
        } else {
            row.innerHTML = `
        <td id="wanted_id">${item.id}</td>
        <td id="wanted_item_code">${item.item_code}</td>
        <td id="wanted_arabic_translation"><textarea class="form-control" rows="8" cols="120" disabled style=resize:none id="arabic">${item.arabic_translation}</textarea></td>
        <td id="wanted_english_translation"><textarea class="form-control" rows="8" cols="120" disabled style=resize:none>${item.english_translation}</textarea></td>
        <td id="wanted_username">${item.username}</td>
        <td>
          <button class="btn btn-success" onclick="handleEditButtonClick(this.parentNode.parentNode)">Edit</button>
          <button class="btn btn-primary" onclick="handleSaveButtonClick(this.parentNode.parentNode)">Save</button>
          <button class="btn btn-primary" onclick="viewDescription(this.parentNode.parentNode)">View</button>
        </td>
      `;
        }
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
    // row.style.backgroundColor = "lightgray";
    const textareas = row.querySelectorAll("textarea");
    textareas.forEach((textarea) => {
        textarea.disabled = true;
        textarea.style.background = "lightgray";
        const ID = row.querySelector("#wanted_id").innerText;
        const itemId = ID;
        const updatedText = textarea.value;
        const arabic = row.querySelector("#arabic").value;
        fetch(`http://localhost:8000/api/get-boolean-value/${ID}`)
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            let updatedBooleanValue = data.is_updated;
            updatedBooleanValue = "1";
            updateDatabaseText(itemId, updatedText, updatedBooleanValue,arabic);
            const editButton = row.querySelector(".btn-success");
            const saveButton = row.querySelector(".btn-primary");
            editButton.disabled = true;
            saveButton.disabled = true;
        })
        .catch((error) => {
            console.error("Error fetching boolean value:", error);
        });


      
    });
    const modal = document.getElementById("Alert!");
    const modalBody = modal.querySelector(".modal-body");
    modalBody.innerHTML = `<p style="border:2px solid rgba(229, 231, 235);border-radius:15px;padding:20px;background-color:rgba(234, 245, 220);">You have edited this text successfully!<br/>And it can't be edited anymore.</p>`;

    modal.classList.add("show");
    modal.style.display = "block";

    const closeButton = document.querySelector("#closeButtonAlert");
    closeButton.addEventListener("click", function () {
        modal.classList.remove("show");
        modal.style.display = "none";
    });
}

function viewDescription(row) {
    const englishDescription = row.cells[3].textContent;
    const arabicDescription = row.cells[2].textContent;
    const itemCode = row.cells[1].textContent;
    displayTranslationDescription(
        itemCode,
        englishDescription,
        arabicDescription
    );
}

function displayTranslationDescription(
    itemCode,
    englishDescription,
    arabicDescription
) {
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
    pagination.innerHTML = "";
    const totalPages = Math.ceil(display.length / itemsPerPage);
    for (let i = 1; i <= totalPages; i++) {
        const li = document.createElement("li");
        li.classList.add("page-item");
        const link = document.createElement("a");
        link.classList.add("page-link");
        link.textContent = i;
        link.href = "#";
        link.addEventListener("click", function () {
            currentPage = i;
            displayTableRows();
            updatePagination();
        });
        li.appendChild(link);
        pagination.appendChild(li);
    }
}
document.addEventListener("DOMContentLoaded", function () {
    fetch("http://localhost:8000/api/translation")
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            display = data.data;
            displayTableRows();
            updatePagination();
        })
        .catch((error) => console.error("Error fetching data:", error));
});
document.getElementById("exportButton").addEventListener("click", function () {
    exportToCsv("translate_users.csv");
});

function exportToCsv(filename) {
    const table = document.getElementById("table_output");
    const header = [
        "ID",
        "Item Code",
        "Arabic Translation",
        "English Translation",
        "Username",
    ];
    const rows = [header];

    for (const row of table
        .getElementsByTagName("tbody")[0]
        .getElementsByTagName("tr")) {
        const rowData = [];

        // Fetch specific data using getElementById or any other method you prefer
        const id = row.querySelector("#wanted_id").textContent.trim();
        const itemCode = row
            .querySelector("#wanted_item_code")
            .textContent.trim();
        const arabicTranslation = row
            .querySelector("#wanted_arabic_translation")
            .textContent.trim();
        const englishTranslation = row
            .querySelector("#wanted_english_translation")
            .textContent.trim();
        const username = row
            .querySelector("#wanted_username")
            .textContent.trim();
        rowData.push(
            id,
            itemCode,
            arabicTranslation,
            englishTranslation,
            username
        );

        rows.push(rowData);
    }

    const csvContent = Papa.unparse(rows, { encoding: "UTF-8" });
    const blob = new Blob([String.fromCharCode(0xfeff), csvContent], {
        type: "text/csv;charset=utf-8;",
    });
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

function updateDatabaseText(itemId, updatedText, updatedBooleanValue,updatedArabic) {
    let url = `http://localhost:8000/api/update-text/${itemId}`;

    let data = {
        text: updatedText,
        booleanValue: updatedBooleanValue,
        arabic: updatedArabic,
    };
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
        body: JSON.stringify(data),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            console.log("Database updated successfully:", data);
        })
        .catch((error) => {
            console.error("Error updating database:", error);
        });
}

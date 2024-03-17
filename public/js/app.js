document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("exportButton")
        .addEventListener("click", function () {
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

    function updateDatabaseText(itemId, updatedText, updatedBooleanValue) {
        let url = `http://localhost:8000/api/update-text/${itemId}`;
        console.log("itemID: " + itemId);
        console.log(updatedBooleanValue);
        let data = {
            text: updatedText,
            booleanValue: updatedBooleanValue,
            // arabic: updatedArabic,
        };
        fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
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
});

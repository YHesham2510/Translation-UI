<!DOCTYPE html>
@extends('layouts.app')
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
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="/exceIcon.png" type="favicon/ico" />
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
      </div>
  </div>
</div>
<button style=" margin: 0px 170px  " id="exportButton" class="btn btn-primary">Export as CSV</button>
@endsection
</body>
</html>
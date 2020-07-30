<!DOCTYPE html>
<html>
  <head>
    <title>Materi</title>
    <meta charset="UTF-8" />
    <style>
        body {
  margin: 0;
  font-family: sans-serif;
  font-size: 0.9rem;
}
#app {
  display: flex;
  flex-direction: column;
  height: 100vh;
}
#toolbar {
  display: flex;
  align-items: center;
  background-color: #555;
  color: #fff;
  padding: 0.5em;
}
#toolbar button,
#page-mode input {
  color: currentColor;
  background-color: transparent;
  font: inherit;
  border: 1px solid currentColor;
  border-radius: 3px;
  padding: 0.25em 0.5em;
}
#toolbar button:hover,
#toolbar button:focus,
#page-mode input:hover,
#page-mode input:focus {
  color: lightGreen;
}
#page-mode {
  display: flex;
  align-items: center;
  padding: 0.25em 0.5em;
}

#viewport-container {
  flex: 1;
  background: #eee;
  overflow: auto;
}
#viewport {
  width: 90%;
  margin: 0 auto;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
}
#viewport > div {
  text-align: center;
  max-width: 100%;
}
#viewport canvas {
  width: 50%;
  box-shadow: 0 2px 5px gray;
}

    </style>
  </head>

  <body>
    <div id="app">
      <div role="toolbar" id="toolbar">
        <div id="pager">
          <button data-pager="prev">Sebelumnya</button>
          <button data-pager="next">Selanjutnya</button>
        </div>
        <div id="page-mode">
          <label>Menampilkan <input type="number" value="1" min="1"/></label>
        </div>
      </div>
      <div id="viewport-container"><div role="main" id="viewport"></div></div>
    </div>
    <script src="https://unpkg.com/pdfjs-dist@2.0.489/build/pdf.min.js"></script>
    <script type="text/javascript" src="{{ asset('pdff.js') }}"></script>

    <script>
        document.addEventListener('contextmenu', event => event.preventDefault()); // disable right click
        initPDFViewer("{{ $url }}");
    </script>
  </body>
</html>

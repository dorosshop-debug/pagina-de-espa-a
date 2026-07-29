@echo off
cd /d "%~dp0.."
set PORT=8765

where php >nul 2>&1
if errorlevel 1 (
  where python >nul 2>&1
  if errorlevel 1 (
    echo [AVISO] PHP/Python no encontrados. Abriendo file://
    start "" "%~dp0product.html"
    exit /b 0
  )
  echo Iniciando preview Python en http://127.0.0.1:%PORT%/preview/
  start "Doro Preview" cmd /c "python -m http.server %PORT%"
) else (
  echo Iniciando preview PHP en http://127.0.0.1:%PORT%/preview/
  start "Doro Preview" cmd /c "php -S 127.0.0.1:%PORT% -t ."
)

timeout /t 1 /nobreak >nul
start "" "http://127.0.0.1:%PORT%/preview/product.html"
start "" "http://127.0.0.1:%PORT%/preview/index.html"
start "" "http://127.0.0.1:%PORT%/preview/offers.html?logged=1"

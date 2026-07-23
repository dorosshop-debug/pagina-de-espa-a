@echo off
cd /d "%~dp0"
set PORT=8765

where python >nul 2>&1
if errorlevel 1 (
  echo [AVISO] Python no encontrado. Abriendo en file:// (pueden aparecer avisos en consola).
  start "" "%~dp0index.html"
  start "" "%~dp0shop.html"
  start "" "%~dp0product.html"
  start "" "%~dp0category.html"
  start "" "%~dp0cart.html"
  start "" "%~dp0checkout.html"
  start "" "%~dp0wishlist.html"
  start "" "%~dp0account.html"
  start "" "%~dp0thankyou.html"
  exit /b 0
)

echo Iniciando preview en http://127.0.0.1:%PORT%/
start "Doro Preview" cmd /c "python -m http.server %PORT%"
timeout /t 1 /nobreak >nul
start "" "http://127.0.0.1:%PORT%/index.html"
start "" "http://127.0.0.1:%PORT%/shop.html"
start "" "http://127.0.0.1:%PORT%/product.html"
start "" "http://127.0.0.1:%PORT%/category.html"
start "" "http://127.0.0.1:%PORT%/cart.html"
start "" "http://127.0.0.1:%PORT%/checkout.html"
start "" "http://127.0.0.1:%PORT%/wishlist.html"
start "" "http://127.0.0.1:%PORT%/account.html"
start "" "http://127.0.0.1:%PORT%/thankyou.html"

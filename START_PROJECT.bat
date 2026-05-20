@echo off
title SalesPulse Analytics - Launcher
color 0A

echo.
echo  ==========================================
echo    SalesPulse Analytics - Auto Launcher
echo  ==========================================
echo.

:: ---- Check if XAMPP is installed ----
set XAMPP_PATH=C:\xampp

if not exist "%XAMPP_PATH%\xampp-control.exe" (
    echo  [ERROR] XAMPP not found at %XAMPP_PATH%
    echo  Please install XAMPP from https://www.apachefriends.org
    echo.
    pause
    exit /b 1
)

echo  [1/4] Starting Apache...
"%XAMPP_PATH%\apache\bin\httpd.exe" -k start >nul 2>&1
timeout /t 2 /nobreak >nul
echo       Apache started OK

echo  [2/4] Starting MySQL...
"%XAMPP_PATH%\mysql\bin\mysqld.exe" --standalone >nul 2>&1 &
timeout /t 3 /nobreak >nul
echo       MySQL started OK

:: ---- Import database if not already imported ----
echo  [3/4] Setting up database...
"%XAMPP_PATH%\mysql\bin\mysql.exe" -u root -e "USE sales_dashboard;" >nul 2>&1
if errorlevel 1 (
    echo       Importing database schema + sample data...
    "%XAMPP_PATH%\mysql\bin\mysql.exe" -u root < "%~dp0database\schema.sql"
    if errorlevel 1 (
        echo  [WARNING] Database import failed. Please import manually via phpMyAdmin.
    ) else (
        echo       Database imported successfully!
    )
) else (
    echo       Database already exists, skipping import.
)

:: ---- Copy project to htdocs if not already there ----
echo  [4/4] Checking project location...
if not exist "%XAMPP_PATH%\htdocs\sales_dashboard\public\index.php" (
    echo       Copying project to htdocs...
    xcopy "%~dp0" "%XAMPP_PATH%\htdocs\sales_dashboard\" /E /I /Y /Q >nul
    echo       Project copied!
) else (
    echo       Project already in htdocs.
)

echo.
echo  ==========================================
echo    Opening Dashboard in Browser...
echo  ==========================================
echo.

timeout /t 2 /nobreak >nul
start "" "http://localhost/sales_dashboard/public/"

echo  Dashboard URL: http://localhost/sales_dashboard/public/
echo  phpMyAdmin:    http://localhost/phpmyadmin
echo.
echo  Press any key to exit this launcher...
pause >nul

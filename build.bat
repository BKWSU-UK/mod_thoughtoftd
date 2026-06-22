@echo off
REM Build script for Thought of the Day Joomla 5 Module (Windows)
REM Creates a distributable ZIP package

setlocal enabledelayedexpansion

REM Module information
set MODULE_NAME=mod_thoughtoftd
set BUILD_DIR=build

echo ================================================
echo    Thought of the Day - Build Script
echo ================================================
echo.

REM Extract version from XML
for /f "tokens=2 delims=<>" %%a in ('findstr /r "<version>" mod_thoughtoftd.xml') do set VERSION=%%a
set PACKAGE_NAME=%MODULE_NAME%_v%VERSION%.zip

echo Version: %VERSION%
echo Package: %PACKAGE_NAME%
echo.

REM Clean previous build
echo [*] Cleaning previous build...
if exist "%BUILD_DIR%" rmdir /s /q "%BUILD_DIR%"
mkdir "%BUILD_DIR%\%MODULE_NAME%"

REM Copy files
echo [*] Copying module files...

copy mod_thoughtoftd.php "%BUILD_DIR%\%MODULE_NAME%\" >nul
copy mod_thoughtoftd.xml "%BUILD_DIR%\%MODULE_NAME%\" >nul

echo   [OK] Helper/
xcopy /E /I /Q Helper "%BUILD_DIR%\%MODULE_NAME%\Helper\" >nul

echo   [OK] language/
xcopy /E /I /Q language "%BUILD_DIR%\%MODULE_NAME%\language\" >nul

echo   [OK] media/
xcopy /E /I /Q media "%BUILD_DIR%\%MODULE_NAME%\media\" >nul

echo   [OK] tmpl/
mkdir "%BUILD_DIR%\%MODULE_NAME%\tmpl"
copy tmpl\*.php "%BUILD_DIR%\%MODULE_NAME%\tmpl\" >nul

REM Clean up system files
echo [*] Cleaning up...
del /s /q "%BUILD_DIR%\Thumbs.db" 2>nul
del /s /q "%BUILD_DIR%\.DS_Store" 2>nul

REM Create ZIP package
echo [*] Creating package...

REM Check if PowerShell is available for zipping
where powershell >nul 2>&1
if %errorlevel% equ 0 (
    powershell -command "Compress-Archive -Path '%BUILD_DIR%\%MODULE_NAME%' -DestinationPath '%PACKAGE_NAME%' -Force"
    rmdir /s /q "%BUILD_DIR%"
    echo.
    echo ================================================
    echo    Build completed successfully!
    echo ================================================
    echo.
    echo Package: %PACKAGE_NAME%
    echo Version: %VERSION%
    echo.
    echo Ready for installation in Joomla!
    echo.
) else (
    echo.
    echo [ERROR] PowerShell not found. Cannot create ZIP file.
    echo Please install PowerShell or use a ZIP utility manually.
    echo Files are ready in: %BUILD_DIR%\%MODULE_NAME%
    echo.
    pause
)

endlocal


@echo off
echo ==========================================
echo Starting Milestone 1 Setup...
echo ==========================================

:: 1. Create Directories
echo Creating Original and Enhanced directories...
mkdir Original 2>nul
mkdir Enhanced 2>nul

:: 2. Move Files to Original
echo Moving all files and folders to Original...
for /f "delims=" %%F in ('dir /b /a') do (
    if /I not "%%F"=="Original" (
        if /I not "%%F"=="Enhanced" (
            if /I not "%%F"==".git" (
                if /I not "%%F"=="setup_milestone1.bat" (
                    move "%%F" "Original\" >nul
                )
            )
        )
    )
)

:: 3. Copy to Enhanced
echo Copying files to Enhanced...
xcopy "Original" "Enhanced" /E /I /H /Y >nul

:: 4. Git Initialization and Commit
echo Setting up Git repository...
git init
git add .
git commit -m "Milestone 1: Baseline structure with Original and Enhanced folders"
git remote add origin https://github.com/lilBlud/WaqafHub
git branch -M main

echo ==========================================
echo Milestone 1 Setup is complete!
echo ==========================================
echo Please run the following command to push your code:
echo git push -u origin main
echo ==========================================
pause

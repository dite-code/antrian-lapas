@echo off

setlocal
set file="test.cmd"
set maxbytesize=1000

FOR /F "usebackq" %%A IN (`%file%`) DO set size=%%~zA

if %size% LSS %maxbytesize% (
    echo.File is ^< %maxbytesize% bytes
) ELSE (
    echo.File is ^>= %maxbytesize% bytes
)

pause

@echo off
echo Revirtiendo al commit 9837d8d...
git reset --hard 9837d8d76a1572dbee198c05869573d98d5b4391
echo.
echo Verificando el estado actual:
git log --oneline -3
echo.
echo Commit actual:
git rev-parse HEAD
pause

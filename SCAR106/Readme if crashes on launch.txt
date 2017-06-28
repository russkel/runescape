If SCAR crashes as soon as you launch it, try following:
Right click SCAR.exe
Create Shortcut
Right click the shortcut
Take Properties
Change Target line from: "C:\SOMETHING\scar.exe"
to: "C:\SOETHING\scar.exe" nonews
(just add [SPACE]nonews at the end)
Click ok and launch the shortcut.
If you did it correctly, SCAR will display "News
are not displayed on startup" when launched.

If SCAR crashes some seconds after you launch it,
try to double-click in status bar the panel where
SCAR shows mouse coords (like 100:150) and get it
to show "Off" on the panel instead.

If SCAR crashes on certain scripts only, please
report it in bug reports thread and include the script
as well. If you want to fix it yourself, try to remove
all lines containing readln for starters.

If scripts are not working because it says "Map failed"
do following setps:
1) Map has to be turned so that compass arrows make perfect 
cross + and north is pointing up.
2) Map has to be completely visible and no other windows can
cover it, also it has to be in the screen completely not partially.
3) Take with the color picker colors of compass arrows, water,
etc and compare with colors in Tools > Map Colors. If they
don't match - enter your values there.

For more help visit http://bovinelabs.com/forum/ 
and click on SCAR forum.
(c) 2003, Kaitnieks (Aivars Irmejs), aivars@serveris.lv

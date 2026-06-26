Set WshShell = CreateObject("WScript.Shell")

' --- Reminder popup ---
MsgBox "Open the OpenDigitalDiscovery.vbs first. If done then click OK to continue.", 64, "Digital Discovery"

' --- Open browser to system ---
WshShell.Run "http://localhost/DigitalDiscoveryBinasbas/adminpanel.php", 0, False

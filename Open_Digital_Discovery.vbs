Set WshShell = CreateObject("WScript.Shell")
Set fso = CreateObject("Scripting.FileSystemObject")

' --- STEP 1: Open XAMPP Control Panel ---
WshShell.Run """C:\xampp\xampp-control.exe""", 0, False

' --- STEP 2: Start Apache ---
WScript.Sleep 2000
WshShell.Run """C:\xampp\apache_start.bat""", 0, False

' --- STEP 3: Start MySQL ---
WScript.Sleep 2000
WshShell.Run """C:\xampp\mysql_start.bat""", 0, False

' Wait a bit to ensure both services are running
WScript.Sleep 4000

' --- STEP 4: Detect drive with DigitalDiscoveryBinasbas ---
foundDrive = ""

For Each d In fso.Drives
    If d.IsReady Then
        If fso.FolderExists(d.Path & "\DigitalDiscoveryBinasbas") Then
            foundDrive = d.Path
            Exit For
        End If
    End If
Next

If foundDrive = "" Then
    MsgBox "Source folder not found! Please insert DVD/USB containing the DigitalDiscoveryBinasbas folder.", 16, "Error"
    WScript.Quit
End If

' --- STEP 5: Auto Copy folder to XAMPP ---
src = foundDrive & "\DigitalDiscoveryBinasbas"
dest = "C:\xampp\htdocs\DigitalDiscoveryBinasbas"

WshShell.Run "xcopy """ & src & """ """ & dest & """ /E /I /Y", 0, True

' --- STEP 6: Create database ---
WshShell.Run """C:\xampp\mysql\bin\mysql.exe"" -u root -e ""CREATE DATABASE IF NOT EXISTS digital_discovery;""", 0, True

' --- STEP 7: Import admins.sql ---
sqlFile = foundDrive & "\DigitalDiscoveryBinasbas\database\admins.sql"
WshShell.Run """C:\xampp\mysql\bin\mysql.exe"" -u root digital_discovery < """ & sqlFile & """", 0, True

' --- STEP 8: Open system in browser ---
WshShell.Run "http://localhost/DigitalDiscoveryBinasbas/user.php", 0, False

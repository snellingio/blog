# Dashlane’s Password Changer Is Terrible (Security Wise)

So let's get this straight - You send your credentials to Dashlane's AWS instances, and then they log in and change your password from a foreign IP address. Sounds lovely.

From
http://support.dashlane.com/customer/portal/articles/1788196-what-is-and-how-does-password-changer-work-#title21

>To change a password for a particular website, the Dashlane application generates a new strong password and encrypts both the current password and the new password with a unique private key, just like our Secure Sharing or Emergency features already work in Dashlane.
>
>Then the application on your computer sends both encrypted passwords to Dashlane's servers. This is done using secure WebSockets – actually WebSockets over SSL/TLS – for maximum security and also prevent any Man-in-The-Middle attacks.
>
>Then our servers try to log in to the targeted Web site and change your password with the newly generated one. This is done using either a headless browser (i.e. a web browser without a graphical user interface) or a call to an API if the Website offers one.
At the end of the operation, our server simply notifies the user with the result: in case of success, the application updates the current password locally with the new password which was previously generated.
